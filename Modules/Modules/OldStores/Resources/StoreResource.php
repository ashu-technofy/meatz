<?php

namespace Modules\Stores\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StoreResource extends JsonResource
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
            'name' => $this->name,
            'logo' => $this->logo,
            'color' => $this->color,
            'products_count' => $this->products_count,
            'products' => ProductsResource::collection($this->products),
        ];
    }
}
