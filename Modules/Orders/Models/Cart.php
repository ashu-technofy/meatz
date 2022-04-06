<?php

namespace Modules\Orders\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Products\Models\Product;
use Modules\Stores\Models\Store;
use Modules\Stores\Models\StoreOption;
use Modules\Stores\Models\StoreProduct;
use Modules\User\Models\User;

class Cart extends Model
{
    protected $table = 'cart';

    protected $fillable = ['user_id', 'product_id', 'count', 'options', 'total', 'guest_id', 'store_id', 'notes'];

    protected $casts = ['options' => 'array'];

    protected static function booted()
    {
        static::addGlobalScope('active', function (Builder $builder) {
            $builder->whereHas('product');
        });
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id')->select('id', 'name' , 'logo');
    }

    public function user()
    {
        return $this->belongsTo(User::class)->select('id', 'username');
    }

    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }

    public function product()
    {
        return $this->belongsTo(StoreProduct::class)->select('id' , 'store_id' , 'type' , 'name', 'price' , 'num' , 'persons');
    }

    public function getMyoptionsAttribute()
    {
        $options = $this->options;
        $rows = [];
        if (is_array($options)) {
            foreach ($options as $op) {
                $option = StoreOption::where('id', $op['id'])->select('id', 'name', 'price');
                $option->count = $op['count'];
                if ($option) {
                    $rows[] = $option;
                }
            }
        }
        return $rows;
    }

    public function getOptionsTxtAttribute()
    {
        $options = [];
        if ($this->options) {
            if(!is_array($this->options)) $this->options = (array) json_decode($this->options);
            $options = StoreOption::whereIn('id', $options)->get();
        }
        $txt = "";
        foreach ($options as $option) {
            $txt .= $option->name.' , ';
        }
        return $txt;
    }
}
