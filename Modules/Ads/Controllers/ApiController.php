<?php

namespace Modules\Ads\Controllers;

use App\Http\Controllers\Controller;
use Modules\Ads\Models\Ad;

class ApiController extends Controller
{

    public function index()
    {
        $ads = Ad::where('status', 1)->where('type' , 'splash')->orderBy('sort' , 'asc')->first(['id', 'image']);
        return api_response('success', '', $ads);
    }
}
