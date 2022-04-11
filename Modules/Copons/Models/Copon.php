<?php

namespace Modules\Copons\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Orders\Models\Order;
use Modules\Stores\Models\StoreCoupons;
use Modules\Stores\Models\Store;

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

    public function copons()
    {
        return $this->hasMany(StoreCoupons::class, 'copon_id');
    }


    public function getUsingAttribute()
    {
        return $this->orders()->count();
    }

    public function getCreatedByAttribute()
    {
        $coupon_id          = $this->id;
        $find_store_coupons = StoreCoupons::where('copon_id',$coupon_id)->first();
        if($find_store_coupons){
          $find_store = Store::where('id',$find_store_coupons->store_id)->first();
          return $find_store ? 'Store('.ucwords($find_store->store_name).")" : 'Store';
        }else{
           return "Admin"; 
        }

    }

    public function scopeForStore($query)
    {
        if ($store = auth('stores')->user()) {
            return $query->whereHas('copons', function ($query) use ($store) {
                return $query->where('store_id', $store->id);
            });
        }
        return $query->where('id', '>', 0);
    }

    public function insertStoreMapping($coupon_id,$store_id){
       
        $find_store_coupons = StoreCoupons::where('copon_id',$coupon_id)
                                         ->where('store_id',$store_id)
                                         ->first();

        if(!$find_store_coupons){

            $add_store_coupons = new StoreCoupons;
            $add_store_coupons->copon_id = $coupon_id;
            $add_store_coupons->store_id = $store_id;
            $add_store_coupons->save();

        }
    }

    public function editStoreMapping($coupon_id,$store_id){
       
        $find_store_coupons = StoreCoupons::where('copon_id',$coupon_id)
                                         ->where('store_id',$store_id)
                                         ->first();

        if($find_store_coupons){

            $add_store_coupons = new StoreCoupons;
            $add_store_coupons->copon_id = $coupon_id;
            $add_store_coupons->store_id = $store_id;
            $add_store_coupons->save();
            
        }
    }

    public function deleteStoreMapping($coupon_id,$store_id){
       
        $find_store_coupons = StoreCoupons::where('copon_id',$coupon_id)
                                         ->where('store_id',$store_id)
                                         ->first();

        if($find_store_coupons){
           $find_store_coupons->delete();
        }
    }

    
}
