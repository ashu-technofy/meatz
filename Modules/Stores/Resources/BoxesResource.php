<?php

namespace Modules\Stores\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BoxesResource extends JsonResource
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
            'image' => $this->image,
            'stocks' => $this->num
        ];
    }
}
