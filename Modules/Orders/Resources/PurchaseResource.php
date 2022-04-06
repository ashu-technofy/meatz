<?php

namespace Modules\Orders\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'    =>  $this->id,
            'title' =>  $this->title,
            'brief' =>  $this->brief,
            'products'    =>  $this->products_list
        ];
    }
}
