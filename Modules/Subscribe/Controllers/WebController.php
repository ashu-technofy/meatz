<?php

namespace Modules\Subscribe\Controllers;

use App\Http\Controllers\Controller;
use Modules\Subscribe\Models\Subscribe;

class WebController extends Controller
{
    public function subscribe()
    {
        if (!request('email')) {
            return back()->with('error', __('Please fill email field'));
        }
        Subscribe::firstOrCreate(['email' => request('email')]);
        return back()->with('success', __('Thanks for your subscription'));
    }
}
