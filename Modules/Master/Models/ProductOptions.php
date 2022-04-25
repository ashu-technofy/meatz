<?php

namespace Modules\Master\Models;

use DB;
use Modules\Common\Models\HelperModel;


class ProductOptions extends HelperModel 
{
 
    protected $table = "product_options";

    protected $fillable = [
        "name",
        "min_selection",
        "product_id",
        "store_id",
        "status"
    ];

    protected $casts = [
        'name' => 'array',
    ];

    
    public function getProductOptionsNameAttribute(){
        return $this->name->{app()->getLocale()};
    }


}
