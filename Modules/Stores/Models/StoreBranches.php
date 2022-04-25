<?php

namespace Modules\Stores\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Builder;
use Modules\Areas\Models\Area;
use Modules\Common\Controllers\FullTextSearch;
use Modules\Common\Models\HelperModel;
use Modules\Orders\Models\Cart;
use Modules\Orders\Models\Guest;
use Modules\Orders\Models\Order;
use Modules\Copons\Models\Copon;
use Modules\Stores\Resources\MenuResource;
use DB;

class StoreBranches extends HelperModel implements AuthenticatableContract
{
    use Authenticatable;
    use FullTextSearch;

    protected $table = "store_branches";

    protected $searchable = [
        'name',
    ];

    protected $fillable = [
        "name",
        "mobile",
        "address",
        "store_id",
        "status",
        "google_map"
    ];

    protected $casts = [
        'name' => 'array',
        'address' => 'array'
    ];

    protected static function booted()
    {
        if (strpos(request()->url(), '/admin') === false) {
            static::addGlobalScope('active', function (Builder $builder) {
                $builder->where('store_branches.status', 1);
            });
        }
    }

    public function scopeForStore($query)
    {
        return $query->where('store_id', auth('stores')->user()->id);
    }



    public function getAddressAttribute($address)
    {
        if (json_decode($address) && strpos(request()->url(), 'admin') === false) {
            $locale = app()->getLocale();
            return json_decode($address)->$locale ?? $address ?? '#';
        }
        return json_decode($address);
    }



    public function getBranchNameAttribute(){
        return $this->name->{app()->getLocale()};
    }

  
  
}
