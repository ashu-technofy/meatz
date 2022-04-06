<?php

namespace Modules\Orders\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Addresses\Resources\AddressResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $store = $this->store;
        if(!$store){
            $product = $this->products()->where('type' , 'product')->first();
            $store = $product ? $product->store()->first(['id' , 'name' , 'logo']) : null;
        }
        // $store->service_name = $this->store->service->title ?? $this->store->services()->first()->title ?? '';
        $code = "MZ" . (1000 + $this->id);
        return [
            'id' => $this->id,
            'code' => $this->code ?? $code,
            'status' => $this->cancel_request == 1 ? __('Cancel Request') : __(str_replace('_' , ' ' , $this->status)),
            'store' => $store,
            'user' => $this->user,
            'address' => $this->address ? new AddressResource($this->address) : ['full_address' => $this->guest->address],
            'created_at' => date('d/m/Y', strtotime($this->created_at)),
            'copon' => $this->copon->code ?? '',
            'can_reorder' => in_array($this->status , ['Delivered' , 'Canceled']) ? 1 : 0,
            'can_cancel' => $this->can_cancel,
            'delivery' => [
                'delivery_type' => $this->delivery_type == 'usual' ? __("Normal") : __('Express'),
                'mode' => $this->delivery_date ? __('Later') : __("Now"),
                'date' => $this->delivery_type == 'usual' && $this->delivery_date ? date('d/m/Y' , strtotime($this->delivery_date)) : null,
                'time' => $this->delivery_type == 'usual' ? $this->delivery_time : null,
            ],
            'payment_method' => $this->payment_method,
            'payment' => [
                'discount' => number_format($this->discount, 3),
                'subtotal' => number_format($this->subtotal , 3),
                'delivery' => number_format($this->delivery , 3),
                'total' => number_format($this->total , 3),
                'payment_method' => $this->payment_method == 'knet' ? __('Online') : __(ucfirst($this->payment_method)),
                'payment_id' => $this->payment_id,
                'transaction_id' => $this->transaction_id
                // 'paid' => $paid ?? 0,
                // 'remain' => $remain ?? 0,
            ],
            'products' => $this->myproducts,
        ];
    }
}
