<?php

namespace Modules\Sliders\Controllers;

use App\Http\Controllers\Controller;
use Modules\Sliders\Models\Slider;

class ApiController extends Controller
{

    public function index()
    {
        $sliders = Slider::where('status', 1)->get();
        return api_response('success', '', $sliders);
    }
}
