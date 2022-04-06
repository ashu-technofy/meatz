<?php

namespace Modules\Orders\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Addresses\Models\Address;
use Modules\Common\Models\Notification;
use Modules\Copons\Models\Copon;
use Modules\Stores\Models\Store;
use Modules\Stores\Models\StoreOption;
use Modules\Stores\Models\StorePeriod;
use Modules\Stores\Models\StoreProduct;
use Modules\User\Models\Rate;
use Modules\User\Models\User;

class Order extends Model
{
    use SoftDeletes;

    protected $table = "orders";
    protected $fillable = [
        'code',
        'status',
        'total',
        'discount',
        'delivery',
        'user_id',
        'address_id',
        'delivery_date',
        'delivery_time',
        'subtotal',
        'seen',
        'notes',
        'copon_id',
        'store_id',
        'payment_method',
        'payment_id',
        'transaction_id',
        'type',
        'paid',
        'guest_id',
        'refund_refrence',
        'wallet',
        'delivery_type',
        'delivery_period_id',
        'cancel_request'
    ];
    protected $casts = [
        'total' => 'double',
    ];

    protected static function booted()
    {
        static::addGlobalScope('is_order', function (Builder $builder) {
            $builder->where('orders.status', '!=', -1);
        });
    }

    public function getCanCancelAttribute(){
        return (in_array($this->status , ['On the way' , 'pending' , 'Pending']) && 
        $this->delivery_type != 'express') && 
        !$this->cancel_request ? 1 : 0;
    }

    public function copon(){
        return $this->belongsTo(Copon::class , 'copon_id')->select('id' , 'discount' , 'code');
    }

    public function scopeForStore($query)
    {
        if ($store = auth('stores')->user()) {
            return $query->where('store_id', $store->id)
            ->orWhereHas('items', function ($query) use ($store) {
                return $query->whereHas('product', function ($query) use ($store) {
                    return $query->where('store_id', $store->id);
                });
            });
        }
        return $query->where('id', '>', 0);
    }

    public function scopeSeen($query)
    {
        return $query->where('seen', 1);
    }

    public function scopeNotseen($query)
    {
        return $query->where('seen', null);
    }

    public static function boot()
    {
        parent::boot();
        static::addGlobalScope('hasuser', function (Builder $builder) {
            $builder->whereHas('user')->orWhereHas('guest');
        });
    }

    public function scopeUnseen($query)
    {
        return $query->where('seen', null);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class)->select('id', 'username' , 'first_name' , 'last_name' , 'email' , 'mobile' , 'lang' , 'wallet');
    }

    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }

    public function getMyUserAttribute()
    {
        return $this->user()->first() ?? $this->guest()->first();
    }

    public function getCurrentStatusAttribute(){
        if($store = auth('stores')->user()){
            return $this->items()->whereHas('product', function ($query) use ($store) {
                return $query->where('store_id', $store->id);
            })->first()->status ?? 'pending';
        }
        return $this->status;
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function products()
    {
        return $this->belongsToMany(StoreProduct::class, 'order_items', 'order_id', 'product_id')
        ->withPivot('total', 'count', 'options' , 'status')
        ->withoutGlobalScopes();
    }

    public function getMyproductsAttribute()
    {
        $rows = [];
        if($store = auth('stores')->user()){
            $products = $this->products()->where('store_id' , $store->id)->get();
        }else{
            $products = $this->products;
        }
        foreach ($products as $item) {
            $myoptions = [];
            $options = (array) json_decode($item->pivot->options, true);
            if (is_array($options)) {
                foreach ($options as $op) {
                    $option = StoreOption::where('id', $op)->first(['id', 'option_id', 'name', 'price']);
                    if ($option) {
                        $option->parent_name = $option->parent->name ?? '';
                        $option->count = $op;
                        unset($option->parent);
                        if ($option) {
                            $myoptions[] = $option;
                        }
                    }
                }
            }
            $rows[] = [
                'image' => $item->image,
                'title' => $item->name->ar ?? $item->name,
                'count' => $item->pivot->count,
                'status' => $item->pivot->status,
                'persons' => $item->persons,
                'name' => $item->name,
                'name' => $item->type,
                'total' => number_format($item->pivot->total , 3) . ' ' . __('KD'),
                'options' => $myoptions,
                'store' => $item->store
            ];
        }
        return $rows;
    }

    public function rate()
    {
        return $this->morphOne(Rate::class, 'rated')->select('id', 'user_id', 'rate', 'text');
    }

    public function getBadgeAttribute()
    {
        $status = [
            'Paid' => 'warning',
            'Pending' => 'primary',
            'Inprogress' => 'warning',
            'Delivered' => 'success',
        ];
        $status = $status[ucfirst($this->status)] ?? '';
        return "<span class='btn btn-$status'>" . __(ucfirst($this->status)) . "</span>";
    }

    public function delivery_period(){
        return $this->belongsTo(StorePeriod::class , 'delivery_period_id');
    }

    public function getDeliveryDateAttribute($date)
    {
        if ($date && $date != "1970-01-01") {
            return $date;
        }

        $created_at = $this->getOriginal('created_at');
        $from = date('H', strtotime($created_at . ' +1 hours'));
        if (app_setting('working_to') < $from) {
            return date('Y-m-d', strtotime($created_at . ' +1 day'));
        }
        return date('Y-m-d', strtotime($created_at));
    }

    public function getDeliveryTimeAttribute($time)
    {
        if($p = $this->delivery_period){
            return __("From : ") . hours($p->from) . __(" to : ") . hours($p->to);
        }
        if ($time) {
            $created_at = $this->delivery_date;
            if ($time) {
                $created_at = $created_at . ' ' . $time;
            }

        } else {
            $created_at = $this->created_at;
        }
        if ($this->schedule != 1) {
            $from = date('H', strtotime($created_at . ' +1 hours'));
        } else {
            $from = date('H', strtotime($created_at));
        }
        $to = date('H', strtotime($created_at . ' +2 hours'));
        $hours_range = range(app_setting('working_from'), app_setting('working_to'));
        if (!in_array($from, $hours_range)) {
            $from = app_setting('working_from');
            $from = $from > 12 ? ($from - 12) . ' pm' : $from . ' am';
            $to = date("h:i a", strtotime($from . ' +2 hours'));
        } else {
            if ($this->schedule != 1) {
                $from = date('h a', strtotime($created_at . ' +1 hours'));
                $to = date('h a', strtotime($created_at . ' +2 hours'));
            } else {
                $from = date('h a', strtotime($created_at));
                $to = date('h a', strtotime($created_at . ' +2 hours'));
            }
        }
        return __("From : ") . $from . __(" to : ") . $to;
    }

    public function getMyoptionsAttribute()
    {
        $options = $this->options;
        $rows = [];
        if (is_array($options)) {
            foreach ($options as $op) {
                $option = StoreOption::where('id', $op)->select('id', 'name', 'price');
                $option->count = $op;
                if ($option) {
                    $rows[] = $option;
                }

            }
        }
        return $rows;
    }

    public function store()
    {
        return $this->belongsTo(Store::class)->select('id' , 'logo', 'name', 'mobile');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'order_id');
    }
}
