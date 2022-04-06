<?php

namespace Modules\Stores\Models;

use Modules\Common\Models\HelperModel;

class StoreCategory extends HelperModel
{
    protected $table = "categories";

    protected $fillable = [
        "name",
        "model",
        'model_id',
        'image'
    ];

    protected $casts = [
        'name' => 'array',
    ];

    protected $hidden = [
        'store_id',
        'sort',
        'created_at',
        'updated_at'
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function meals()
    {
        return $this->hasMany(StoreProduct::class , 'category_id')->with('options');
    }

}
