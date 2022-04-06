<?php

namespace Modules\Orders\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Stores\Models\Store;

class OrdersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $code = "ZW" . (1000 + $this->id);
        // $store = $this->store;
        // if(!$store){
        //     $product = $this->products()->where('type' , 'product')->first();
        //     $store = $product ? $product->store()->first(['id' , 'name' , 'logo']) : null;
        // }
        // $service_name = $this->store->service->title ?? $this->store->services()->first()->title ?? '';

        return [
            'id' => $this->id,
            'code' => $this->code ?? $code,
            'status' => $this->cancel_request == 1 ? __('Cancel Request') : __(str_replace('_' , ' ' , $this->status)),
            'can_reorder' => $this->status == 'Delivered' ? 1 : 0,
            'total' => number_format($this->total, 3),
            // 'service_name' => $service_name,
            'payment_method' => $this->payment_method,
            'items_count' => count($this->myproducts),
            'created_at' => date('d/m/Y', strtotime($this->created_at)),
        ];
    }
}
