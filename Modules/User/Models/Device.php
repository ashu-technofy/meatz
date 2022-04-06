<?php

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $table = 'user_device';
    protected $fillable = ['user_id', 'type', 'device_type', 'device_token', 'notify'];

    protected $casts = ['location' => 'array'];

    public function scopeNotifiable($query)
    {
        return $query->where('notify', 1);
    }

    public function scopeAndriod($query)
    {
        return $query->where('device_type', 'andriod');
    }

    public function scopeIos($query)
    {
        return $query->where('device_type', 'ios');
    }
}
