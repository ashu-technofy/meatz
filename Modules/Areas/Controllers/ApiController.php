<?php

namespace Modules\Areas\Controllers;

use App\Http\Controllers\Controller;
use Modules\Areas\Models\Area;

class ApiController extends Controller
{

    public function areas()
    {
        // $cities = City::orderBy('name', 'asc')->get()->sortBy('name')->values();
        // foreach ($cities as $city) {
        //     $city->areas = Area::where('city_id', $city->id)->orderBy('name', 'asc')->get()->sortBy('name')->values();
        // }
        $cities = Area::whereNull('city_id')->with('cities')->orderBy('name', 'asc')->get();
        return api_response('success', '', $cities);
    }
}
