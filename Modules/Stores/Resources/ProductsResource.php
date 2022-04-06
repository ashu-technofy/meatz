<?php

namespace Modules\Stores\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductsResource extends JsonResource
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
            'id' => $this->id,
            'is_active' => $this->status,
            'type' => $this->type,
            'name' => $this->name,
            'price' => $this->price,
            'price_before' => $this->price_before,
            'image' => $this->image,
        ];
    }
}
