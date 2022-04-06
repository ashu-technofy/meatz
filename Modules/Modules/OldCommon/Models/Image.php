<?php

namespace Modules\Common\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = ['image'];
    /**
     * Get the parent imageable model (post or video).
     */
    public function imageable()
    {
        return $this->morphTo();
    }

    public function setImageAttribute($image)
    {
        $this->attributes['image'] = $image->store("uploads/products");
    }

    public function getImageAttribute($image)
    {
        return $image ? url($image) : url('placeholders/product.png');
    }
}