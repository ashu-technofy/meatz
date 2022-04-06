<?php

namespace Modules\Orders\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PurchasesResource extends JsonResource
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
            'products_count'    =>  $this->products ? count($this->products) : 0,
            'images'    =>  $this->images,
        ];
    }
}
