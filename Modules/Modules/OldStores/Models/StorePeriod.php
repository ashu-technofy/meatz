<?php

namespace Modules\Stores\Models;

use Modules\Common\Models\HelperModel;

class StorePeriod extends HelperModel
{
    protected $table = "store_periods";

    protected $fillable = [
        'from',
        'to',
        'weekday',
        "store_id",
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }


}
