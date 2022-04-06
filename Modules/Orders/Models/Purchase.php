<?php

namespace Modules\Orders\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Products\Models\Product;

class Purchase extends Model
{
    protected $table = 'user_purchases';
    protected $fillable = ['user_id', 'title', 'brief', 'products'];
    protected $casts = ['products' => 'array'];

    public function getImagesAttribute()
    {
        $items = $this->products;
        $images = [];
        if ($items) {
            foreach ($items as $item) {
                $images[] = Product::find($item['product_id'])->image ?? '';
            }
        }
        for ($i = count($images); $i < 4; $i++) {
            $images[] = url('assets/list.png');
        }
        return $images ?? [];
    }

    public function getProductsListAttribute()
    {
        $items = $this->products;
        if ($items) {
            foreach ($items as $item) {
                $product = Product::where('id', $item['product_id'])->first(['id', 'name', 'brief', 'quantity', 'price', 'offer_price', 'stock', 'unit_type', 'increase_by'])->append('image');
                $product->count = $item['count'];
                $product->price = $product->offer_price ?? $product->price;
                $product->unit = [
                    'unit'  =>  $product->quantity,
                    'type'  =>  $product->unit_type
                ];
                $products[] = $product;
            }
        }
        return $products ?? [];
    }
}
