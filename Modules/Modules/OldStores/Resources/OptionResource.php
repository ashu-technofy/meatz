<?php

namespace Modules\Stores\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OptionResource extends JsonResource
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
            'price' => $this->price
            // 'required' => $this->required ? 1 : 0,
            // 'multiple' => $this->multiple ? 1 : 0,
            // 'counted' => $this->counted ? 1 : 0,
            // 'min' => $this->pivot->min,
            // 'max' => $this->pivot->max,
            // 'sub_options' => $this->options,
        ];
    }
}
