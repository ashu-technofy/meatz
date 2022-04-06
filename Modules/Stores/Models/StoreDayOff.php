<?php

namespace Modules\Stores\Models;

use Modules\Common\Models\HelperModel;

class StoreDayOff extends HelperModel
{
    protected $table = "store_dayoff";

    protected $fillable = [
        'date',
        "store_id",
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }


}
