<?php

namespace Modules\Stores\Models;

use Modules\Common\Models\HelperModel;

class StoreSubcategory extends HelperModel
{

	protected $table = "subcategories";

    protected $fillable = [
        "subcategory_name", 
        "subcategory_image",
        "category_id"
    ];


    protected $casts = [
        'subcategory_name' => 'array',
    ];

    protected $hidden = [
        'category_id',
        'sort',
        'created_at',
        'updated_at'
    ];

    public function category()
    {
        return $this->belongsTo(StoreCategory::class,'category_id');
    }

    public function getCategoryTitleAttribute(){
      
        return $this->category->name->{app()->getLocale()} ?? "";
    }
    public function getSubcategoryTitleAttribute(){
      
        return $this->subcategory_name[app()->getLocale()];
        
    }

}
