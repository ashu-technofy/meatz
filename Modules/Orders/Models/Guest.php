<?php

namespace Modules\Orders\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Areas\Models\Area;
use Modules\Common\Models\Notification;

class Guest extends Model
{
    protected $table = 'guests';
    protected $fillable = [
        'fb_token',
        'username',
        'email',
        'mobile',
        'area_id',
        'address',
        'lang'
    ];

    public function cart()
    {
        return $this->hasMany(Cart::class);
    }

    public function orders(){
        return $this->hasMany(Order::class , 'guest_id');
    }

    public function notifications(){
        return $this->hasMany(Notification::class , 'guest_id');
    }

}
