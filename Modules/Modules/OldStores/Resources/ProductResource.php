<?php

namespace Modules\Stores\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $images = $this->images;
        if (!$images->count()) {
            $images = [
                [
                    'id' => 0,
                    'image' => $this->image,
                ],
            ];
        }
        return [
            'id' => $this->id,
            'is_active' => $this->status,
            'type' => $this->type,
            'name' => $this->name,
            'content' => strip_tags($this->content),
            'price' => $this->price,
            'price_before' => $this->price_before,
            'liked' => $this->liked,
            'persons' => $this->persons,
            'num' => $this->num ?? 5,
            'images' => $images,
            'options' => OptionResource::collection($this->options()->latest()->get()),
        ];
    }
}
