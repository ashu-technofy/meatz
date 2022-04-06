<?php

namespace Modules\Common\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Modules\Orders\Models\Guest;
use Modules\Orders\Models\Order;
use Modules\Stores\Models\StoreProduct as Product;

class Notification extends Model
{
    protected $fillable = ['type', 'model', 'user_id', 'guest_id', 'text', 'guest_id', 'product_id', 'order_id' , 'for' , 'title'];
    protected $dates = ['created_at'];

    public function scopeGlobal($query)
    {
        return $query->where('type', 'global');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function setTextAttribute($text)
    {
        if (is_array($text)) {
            $text = json_encode($text);
        }
        $this->attributes['text'] = $text;
    }

    public function getTextAttribute($text)
    {
        if ($decoded_text = json_decode($text)) {
            return $decoded_text->{app()->getLocale()};
        }
        if ($this->model = 'order') {
            return __($text, ['num' => $this->order_id]);
        }
        return $text;
    }



    public function setTitleAttribute($title)
    {
        if (is_array($title)) {
            $title = json_encode($title);
        }
        $this->attributes['title'] = $title;
    }

    public function getTitleAttribute($title)
    {
        if ($decoded_title = json_decode($title)) {
            return $decoded_title->{app()->getLocale()};
        }
        if ($this->model = 'order') {
            return __($title, ['num' => $this->order_id]);
        }
        return $title;
    }

    public function getModelIdAttribute()
    {
        if ($this->model == 'product') {
            return $this->product_id;
        }
        return $this->order_id;
    }

    public function getImageAttribute()
    {
        if ($this->model == 'order') {
            return Order::find($this->order_id)->products[0]->image ?? null;
        }
        return Product::find($this->product_id)->image ?? null;
    }

    public function getCreatedAtAttribute($created_at)
    {
        $created_at = Carbon::parse($created_at);
        return $created_at->diffForHumans();
    }
}
