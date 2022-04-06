<?php

namespace Modules\Ads\Models;

use Modules\Common\Models\HelperModel;

class Ad extends HelperModel
{
    protected $table = 'ads';

    protected $fillable = [
        'title',
        'image',
        'sort',
        'status',
        'type'
    ];
    protected $hidden = ['created_at', 'updated_at'];
    protected $casts = ['title' => 'array'];
}
