<?php

namespace Modules\Contactus\Controllers;

use App\Http\Controllers\Controller;
use Modules\Common\Models\Setting;
use Modules\Contactus\Models\Contactus;
use Modules\Contactus\Requests\ContactRequest;
use Modules\Offices\Models\Office;

class WebController extends Controller
{

    public function index()
    {
        $offices = Office::get();
        $contacts = Setting::whereType('contacts')->get();
        $title = __("Contactus");
        return view('Contactus::index', get_defined_vars());
    }


    public function store(ContactRequest $request)
    {
        Contactus::create(request()->all());
        return back()->with('sent', 'success');
    }
}
