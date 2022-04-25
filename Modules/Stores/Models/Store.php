<?php

namespace Modules\Stores\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Areas\Models\Area;
use Modules\Common\Controllers\FullTextSearch;
use Modules\Common\Models\HelperModel;
use Modules\Orders\Models\Cart;
use Modules\Orders\Models\Guest;
use Modules\Orders\Models\Order;
use Modules\Copons\Models\Copon;
use Modules\Stores\Models\StoreBranches;
use Modules\Stores\Resources\MenuResource;
use DB;

class Store extends HelperModel implements AuthenticatableContract
{
    use Authenticatable;
    use SoftDeletes;
    use FullTextSearch;

    protected $table = "stores";

    protected $searchable = [
        'name',
        'about'
    ];

    protected $fillable = [
        "type",
        "name",
        // "contact_name",
        "email",
        "mobile",
        "password",
        "about",
        "logo",
        "banner",
        "mode",
        "featured",
        "status",
        "working_days",
        "days_off",
        "supplier_code",
        "address",
        "google_map"
    ];

    protected $casts = [
        'mode' => 'array',
        'about' => 'array',
        'name' => 'array',
        'working_days' => 'array',
        'days_off' => 'array',
        'address' => 'array'
    ];

    protected static function booted()
    {
        if (strpos(request()->url(), '/admin') === false) {
            static::addGlobalScope('active', function (Builder $builder) {
                $builder->where('stores.status', 1);
            });
        }
    }

    public function scopeForStore($query)
    {
        return $query->where('id', auth('stores')->user()->id);
    }


    public function setLogoAttribute($logo)
    {
        $this->attributes['logo'] = $logo->store("uploads/" . $this->table);
    }

    public function getLogoAttribute($logo)
    {
        return $logo ? url($logo) : url('placeholders/' . $this->table . '.png');
    }

    public function getAddressAttribute($address)
    {
        if (json_decode($address) && strpos(request()->url(), 'admin') === false) {
            $locale = app()->getLocale();
            return json_decode($address)->$locale ?? $address ?? '#';
        }
        return json_decode($address);
    }

    public function getPolicyAttribute($policy)
    {
        if (json_decode($policy) && strpos(request()->url(), 'admin') === false) {
            $locale = app()->getLocale();
            return json_decode($policy)->$locale;
        }
        return json_decode($policy);
    }

    public function categories()
    {
        return $this->belongsToMany(StoreCategory::class , 'store_categories' , 'store_id' , 'category_id');
    }

    public function branches()
    {
        return $this->hasMany(StoreBranches::class,'store_id') ;
    }
    
    public function copons()
    {
        return $this->belongsToMany(Copon::class,'store_copons','store_id','copon_id');
    }

    public function subcategories()
    {
        return $this->belongsToMany(StoreSubcategory::class, 'store_subcategories' , 'store_id' , 'subcategory_id');
    }

    public function insertSubCategory($subCategoryId, $categoryIds, $storeId, $action="insert")
    {
       
      if (!empty($subCategoryId) && !empty($categoryIds) && !empty($storeId)) {
        if ($action == "update") {
          DB::table('store_subcategories')->where('store_id',$storeId)->delete();
        }
        foreach ($categoryIds as $categoryId) {
          $subcatId = [];
          $subCategoriesDetail = DB::table('subcategories')->where('category_id',$categoryId)->get();
          
          if (!empty($subCategoriesDetail)) {
            foreach ($subCategoriesDetail as $subCategory) {
              $subcatId[] = $subCategory->id;
            }
          }

          foreach ($subCategoryId as $subCat) {
            if (in_array($subCat, $subcatId)) {
              $insertData = array('store_id' => $storeId  ,'category_id' => $categoryId , 'subcategory_id' =>$subCat);
              DB::table('store_subcategories')->insert($insertData);
            }
          }

        }
      }
    }

    public function getMycategoriesAttribute(){
        $cats = $this->categories;
        $strs = [];
        foreach($cats as $cat){
            $strs[] = $cat->name->{app()->getLocale()};
        }
        return implode(',',$strs);
    }

     public function getStoreNameAttribute(){
        return $this->name->{app()->getLocale()};
    }

    public function getMysubcategoriesAttribute(){
        $cats = $this->subcategories;
        $strs = [];
        foreach($cats as $cat){
            $strs[] = $cat->subcategory_title;
        }
        return implode(',',$strs);
    }
   

    public function options()
    {
        return $this->hasMany(StoreOption::class);
    }

    public function products()
    {
        return $this->hasMany(StoreProduct::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'store_services');
    }

    public function getMyservicesAttribute()
    {
        return $this->services()->pluck('service_id')->toArray();
    }

    public function areas()
    {
        return $this->belongsToMany(Area::class, 'store_areas')->withPivot('delivery');
    }


    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function getMenuAttribute()
    {
        return MenuResource::collection($this->categories()->with('meals')->orderBy('sort', 'asc')->get());
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'store_id');
    }

    public function getMyordersAttribute(){
        $prods = $this->products()->pluck('id')->toArray();
        return Order::whereHas('items' , function($query) use($prods){
            return $query->whereIn('product_id' , $prods);
        });
    }

    public function getMyOrdersCountAttribute(){
        return $this->myorders->count();
    }

    public function getWeekDaysAttribute()
    {
        $days = $this->working_days ?? [];
        $rows = [];
        foreach ($days as $day) {
            $rows[] = weekdays_index($day);
        }
        return $rows;
    }

    public function periods(){
        return $this->hasMany(StorePeriod::class , 'store_id');
    }

    public function dates_off()
    {
        return $this->hasMany(StoreDayOff::class, 'store_id');
    }

    public function getTotalAttribute()
    {
        if ($user = auth('api')->user()) {
            $total = Cart::where('store_id', $this->id)->where('user_id', $user->id)->sum('total') ?? 0;
        } elseif ($user = Guest::firstOrCreate(['fb_token' => request()->header('FbToken')])) {
            $total = Cart::where('store_id', $this->id)->where('user_id', $user->id)->sum('total') ?? 0;
        } else {
            $total = 0;
        }
        return number_format($total, 3);
    }
}
