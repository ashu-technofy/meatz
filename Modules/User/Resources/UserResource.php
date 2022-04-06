<?php

namespace Modules\User\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'username' => $this->username,
            'mobile' => $this->mobile,
            'email' => $this->email,
            'points' => $this->points ?? 0,
            'wallet' => $this->mywallet,
            'access_token' => $this->access_token,
        ];
    }
}
