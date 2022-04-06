<?php

namespace Modules\Stores\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Stores\Models\StoreOption;

class BoxProductsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $total = $this->pivot->count * $this->price;
        if($ops = $this->pivot->options){
            if (json_decode($ops)) {
                $ops = json_decode($ops);
                if(!is_array($ops)){
                    $ops = explode(',' , $ops);
                }
            }
            if (is_array($ops) && count($ops)) {
                $ops_price = StoreOption::whereIn('id', $ops)->sum('price');
                $total += ($ops_price * $this->pivot->count);
                $options = StoreOption::whereIn('id', $ops)->get(['name' , 'price']);
            }
        }
        return [
            'id' => $this->id,
            'is_active' => $this->status,
            'type' => $this->type,
            'name' => $this->name,
            'num' => $this->num,
            'price' => $this->price,
            'price_before' => $this->price_before,
            'store' => $this->store,
            'image' => $this->image,
            'count' => $this->pivot->count,
            'total' => number_format($total , 3) .' '. __("KD"),
            'store' => $this->store()->first(['id' , 'name' , 'logo']),
            'options' => $options ?? []
        ];
    }
}
