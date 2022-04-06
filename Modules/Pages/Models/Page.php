<?php

namespace Modules\Pages\Models;

use Modules\Common\Models\HelperModel;

class Page extends HelperModel
{
    protected $table = 'pages';

    protected $fillable = [
        'title',
        'content',
        'type',
        'image'
    ];
    protected $hidden = ['created_at', 'updated_at'];
    protected $casts = ['title' => 'array', 'content' => 'array'];
}
