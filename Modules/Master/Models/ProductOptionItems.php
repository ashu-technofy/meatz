<?php

namespace Modules\Master\Models;

use DB;
use Modules\Common\Models\HelperModel;


class ProductOptionItems extends HelperModel 
{
 
    protected $table = "product_option_items";


    protected $fillable = [
        "name",
        "content",
        "price",
        "number",
        "store_id",
        "product_id",
        "product_option_id",
        "status"
    ];

    protected $casts = [
        'name' => 'array',
        'content' => 'array',
    ];

    
    public function getItemNameAttribute(){
        return $this->name->{app()->getLocale()};
    }
    public function getItemContentAttribute(){
        return $this->content->{app()->getLocale()};
    }


}
