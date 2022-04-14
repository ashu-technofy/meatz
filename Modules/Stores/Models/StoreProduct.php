<?php

namespace Modules\Stores\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Common\Models\HelperModel;
use Modules\Orders\Models\Order;
use Modules\Common\Controllers\FullTextSearch;
use Modules\User\Models\User;

class StoreProduct extends HelperModel
{
    use FullTextSearch;
    protected $table = "store_products";

    protected $fillable = [
        'status',
        "approve_status",
        "name",
        "content",
        "price",
        "num",
        "store_id",
        "category_id",
        "type",
        "price_before",
        "persons"
    ];
    
    public $searchable_relations = ['store'];

    protected $casts = [
        'name' => 'array',
        'content' => 'array',
    ];

    protected $searchable = [
        'name',
        // 'content'
    ];

    protected $appends = ['image'];

    protected static function booted()
    {
        if (strpos(request()->url(), '/admin') === false) {
            static::addGlobalScope('active', function (Builder $builder) {
                $builder->where('status', 1)
                ->where(function($query){
                    return $query->whereNull('store_id')
                    ->orWhereHas('store' , function($query){
                        return $query->where('stores.status' , 1);
                    });
                });
            });
        }
    }

    public function getAllNameAttribute(){
        return $this->name->ar.' /'.$this->name->en;
    }

    public function getOriginalPriceAttribute($price){
        return is_numeric($this->price_before) ? number_format($this->price_before , 3)  : $this->price_before;
    }


    public function scopeType($query , $type){
        return $query->where('type' , $type);
    }

    public function getPriceAttribute($price)
    {
        return number_format($price, 3);
    }

    public function getPriceBeforeAttribute($price)
    {
        if ($price) {
            return number_format($price, 3);
        }
        return null;
    }

    public function getNumAttribute($num){
        return $num ?? 100;
    }

    public function store()
    {
        return $this->belongsTo(Store::class)->select('id' , 'name' , 'logo' , 'address' , 'supplier_code');
    }

    public function getStoreNameAttribute(){
        return $this->store->name->{app()->getLocale()} ?? '';
    }

    public function category()
    {
        return $this->belongsTo(StoreCategory::class);
    }

    public function categories()
    {
        return $this->belongsToMany(StoreCategory::class , 'store_product_categories' , 'product_id' , 'category_id');
    }

    public function getMycategoriesAttribute(){
        $cats = $this->categories;
        $strs = [];
        foreach($cats as $cat){
            $strs[] = $cat->name->{app()->getLocale()};
        }
        return implode(" , " , $strs);
    }

    public function options()
    {
        return $this->belongsToMany(StoreOption::class, 'store_product_options', 'product_id', 'option_id')->withPivot('min', 'max');
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_items', 'product_id', 'order_id')->withPivot('options', 'total', 'count', 'notes');
    }

    public function likes(){
        return $this->belongsToMany(User::class , 'user_likes' , 'product_id' , 'user_id');
    }

    public function getLikedAttribute(){
        if ($user = auth('api')->user()) {
            return $this->likes()->where('user_id' , $user->id)->exists() ? 1 : 0;
        }
        return 0;
    }

}
