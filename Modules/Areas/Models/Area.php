<?php

namespace Modules\Areas\Models;

use Modules\Common\Models\HelperModel;

class Area extends HelperModel
{
    protected $table = 'areas';
    protected $fillable = ['name', 'city_id' , 'delivery' , 'delivery_express'];

    protected $casts = ['name' => 'array'];
    protected $hidden = ['created_at', 'updated_at'];

    public function area()
    {
        return $this->belongsTo(Area::class, 'city_id');
    }

    public function cities()
    {
        return $this->hasMany(Area::class, 'city_id')->orderBy('name', 'asc');
    }
}
