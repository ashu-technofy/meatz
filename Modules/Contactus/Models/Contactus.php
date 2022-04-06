<?php

namespace Modules\Contactus\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Contactus extends Model
{
    protected $table = 'contactus';
    protected $fillable = ['name' , 'first_name', 'last_name', 'email', 'mobile', 'message', 'seen', 'title'];


    public function scopeUnseen($query)
    {
        return $query->where('seen', null);
    }

    public function getTimeAgoAttribute()
    {
        $time = new Carbon($this->created_at);
        return $time->diffForHumans();
    }
    

    public function getShortMessageAttribute()
    {
        return mb_substr($this->message, 0, 70) . '..';
    }

    public function getNameAttribute($name)
    {
        return $name ?? $this->first_name . ' ' . $this->last_name;
    }

    public function getStatusAttribute(){
        if($this->seen){
            return __('Viewed');
        }
        return __('Not viewed');
    }
}
