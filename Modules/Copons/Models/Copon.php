<?php

namespace Modules\Copons\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Orders\Models\Order;

class Copon extends Model
{
    protected $fillable = ['status', 'type', 'code', 'discount', 'max_discount', 'ended_at' , 'last_copon'];

    public function scopeValid($query)
    {
        return $query->where('ended_at', '>=', date('Y-m-d'))->where('status' , 1)->orWhere('ended_at', null);
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'copon_id');
    }

    public function getUsingAttribute()
    {
        return $this->orders()->count();
    }
}
