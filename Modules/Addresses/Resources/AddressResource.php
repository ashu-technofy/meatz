<?php

namespace Modules\Addresses\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
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
            'address_name' => $this->address_name ?? $this->address['address_name'] ?? '',
            'area' => $this->area,
            'address' => $this->myaddress,
        ];
    }
}
