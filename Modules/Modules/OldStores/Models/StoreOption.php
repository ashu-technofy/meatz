<?php

namespace Modules\Stores\Models;

use Modules\Common\Models\HelperModel;

class StoreOption extends HelperModel
{
    protected $table = "store_options";

    protected $fillable = [
        "name",
        "sort",
        "store_id",
        "option_id",
        "price",
        "required",
        "multiple",
        "counted"
    ];

    protected $casts = [
        'name' => 'array',
        'options' => 'array',
    ];

    public function getPriceAttribute($price)
    {
        return number_format($price, 3);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function products()
    {
        return $this->belongsToMany(StoreProduct::class, 'store_product_options')->withPivot('min', 'max');
    }

    public function options()
    {
        return $this->hasMany(StoreOption::class, 'option_id')->select('id', 'name', 'option_id', 'price');
    }

    public function parent()
    {
        return $this->belongsTo(StoreOption::class, 'option_id');
    }
}
