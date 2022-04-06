<?php

namespace Modules\Wallets\Models;

use Modules\Common\Models\HelperModel;
use Modules\Stores\Models\Store;
use Modules\Stores\Models\StoreProduct;

class Wallet extends HelperModel
{
    protected $table = 'wallet_cards';

    protected $fillable = [
        'price',
        'sort'
    ];

    public function getPriceAttribute($price){
        if(request()->wantsJson()){
            return number_format($price , 3);
        }
        return $price;
    }
}
