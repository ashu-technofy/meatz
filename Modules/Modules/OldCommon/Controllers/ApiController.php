<?php

namespace Modules\Common\Controllers;

use App\Http\Controllers\Controller;
use Modules\Ads\Models\Ad;
use Modules\Areas\Models\Area;
use Modules\Common\Models\Notification;
use Modules\Common\Resources\NotificationResource;
use Modules\Orders\Models\Guest;
use Modules\Services\Models\Service;
use Modules\Sliders\Models\Slider;
use Modules\Stores\Models\Store;
use Modules\Stores\Models\StoreCategory;
use Modules\Stores\Models\StoreProduct;
use Modules\Stores\Resources\BoxesResource;
use Modules\Stores\Resources\StoresResource;

class ApiController extends Controller
{

    public function home()
    {
        $data['categories'] = StoreCategory::get();
        $data['sliders'] = Slider::get();
        $stores = Store::where('featured' , 1)->take(6)->get();
        $data['featured'] = StoresResource::collection($stores);
        $boxes = StoreProduct::type('box')->whereNull('store_id')->latest()->take(6)->get();
        $data['boxes'] = BoxesResource::collection($boxes);
        // $data['banner'] = Ad::where('type' , 'home')->first();
        return api_response('success', '', $data);
    }
}
