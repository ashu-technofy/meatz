<?php

namespace Modules\Common\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
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
            'text'  =>  $this->text,
            'model' =>  $this->model,
            'model_id'  =>  $this->model_id,
            'image' =>  $this->image ?? url('placeholders/bell.PNG'),
            'created_at'    =>  $this->created_at
        ];
    }
}
