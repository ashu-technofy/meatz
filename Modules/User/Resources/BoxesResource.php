<?php

namespace Modules\User\Resources;

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
            'is_active' => $this->is_active,
            'name' => $this->name,
            'items_count' => (int) $this->products()->sum('count'),
            'total' => $this->total
        ];
    }
}
