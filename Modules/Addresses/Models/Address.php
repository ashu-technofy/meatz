<?php

namespace Modules\Addresses\Models;

use Modules\Areas\Models\Area;
use Modules\Common\Models\HelperModel;

class Address extends HelperModel
{
    protected $fillable = ['status', 'user_id', 'area_id', 'address_name', 'address'];
    protected $casts = ['address' => 'array'];
    protected $hidden = ['created_at', 'updated_at'];

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function getMyaddressAttribute()
    {
        $address = (array) $this->address;
        $address = array_map(function ($val) {
            return $val ? $val : "";
        }, $address);
        return $address;
    }

    public function getFullAddressAttribute(){
        $address = $this->myaddress;
        $arr = [
            __('Area') => Area::find($address['area_id'])->name->{app()->getLocale()} ?? '',
            __('Street') => $address['street'] ?? '',
            __('Block') => $address['block'] ?? '',
            __('House') => $address['house_number'] ?? '',
            __('Level') => $address['level_no'] ?? '',
            __('Aprtment no') => $address['apartment_no'] ?? ''
        ];
        $arr = array_filter($arr);
        $str = "";
        foreach($arr as $key => $val){
            $str .= "<b style='font-weight:bold;'>".$key." : </b>".$val.' , ';
        }
        return $str;
    }

    // public function getAddressAttribute($address){
    //     $address = (array) json_decode($address);
    //     $address['apratment_no'] = $address['apratment_no'] ?? $address['apartment_no'];
    //     $address['apartment_no'] = $address['apartment_no'] ?? $address['apratment_no'];
    //     return $address;
    // }

}
