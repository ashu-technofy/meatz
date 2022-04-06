<?php

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Stores\Models\StoreOption;
use Modules\Stores\Models\StoreProduct;

class Box extends Model
{
    protected $table = 'user_boxes';
    protected $fillable = ['user_id' , 'name'];
    protected $hidden = ['created_at' , 'updated_at'];


    public function user(){
        return $this->belongsTo(User::class);
    }

    public function getIsActiveAttribute(){
        $rows = $this->products;
        foreach($rows as $row){
            if($row->status != 1 || !$row->num) return 0;
        }
        return 1;
    }

    public function products(){
        return $this->belongsToMany(StoreProduct::class , 'user_boxes_products' , 'box_id' , 'product_id')
        ->withPivot('count' , 'options');
    }

    public function getTotalAttribute(){
        $products = $this->products;
        $total = 0;
        // dd($products);
        foreach($products as $row){
            $total += ($row->price * $row->pivot->count); 
            $options = $row->pivot->options ?? '';
            // $options = (array) json_decode($row->pivot->options);
            // if($row->pivot->product_id == 4){
            //     dd($row , $options , $row->pivot->options);
            // }
            if($options && !is_array($options)) $options = explode(',' , $options);
            if ($options && count($options)) {
                $options = array_map(function($v){
                    return str_replace(['"' , " "] , '' , $v);
                } , $options);
                $sum_options = StoreOption::whereIn('id', $options)->sum('price');
                // if($row->id == 3) dd($sum_options , $options , StoreOption::whereIn('id', $options)->get());
                $total += ($row->pivot->count * $sum_options);
            }
        }
        return number_format($total , 3);
    }
}
