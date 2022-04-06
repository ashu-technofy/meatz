<?php

namespace Modules\Stores\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BoxResource extends JsonResource
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
            'price' => $this->price,
            'price_before' => $this->price_before,
            'persons' => $this->persons ?? 1,
            'stocks' => $this->num,
            'images' => $this->images()->pluck('image')->toArray(),
            'content' => explode(',,' , strip_tags($this->content)),
            'store' => $this->store,
        ];
    }
}
