<?php

namespace Modules\Orders\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Stores\Models\StoreProduct;

class OrderItem extends Model
{
    use SoftDeletes;

    protected $table = "order_items";
    protected $fillable = ['product_id', 'count', 'options', 'total' , 'status'];

    protected $casts = ['options' => 'array'];

    public function product()
    {
        return $this->belongsTo(StoreProduct::class, 'product_id');
    }

}
