<?php

namespace Modules\Contactus\Controllers;

use App\Http\Controllers\Controller;
use Modules\Common\Models\Setting;
use Modules\Contactus\Models\Contactus;
use Modules\Contactus\Requests\ContactRequest;

class ApiController extends Controller
{

    public function send_message(ContactRequest $request)
    {
        Contactus::create(request()->all());
        return api_response('success', __("Thanks for your message, We will contact you soon."));
    }

    public function send_request(ContactRequest $request)
    {
        Contactus::create(request()->all());
        return api_response('success', __("Request sent successfully"));
    }

    public function contacts()
    {
        $contacts = Setting::contacts()->pluck('value', 'key')->toArray();
        return api_response('success', '', [
            'whatsapp'    =>  $contacts['whatsapp'] ?? '',
            'mobile'    =>  $contacts['mobile'] ?? '',
            'email'    =>  $contacts['email'] ?? '',
            'facebook'    =>  $contacts['facebook'] ?? '',
            'twitter'    =>  $contacts['twitter'] ?? '',
            'instagram'    =>  $contacts['instagram'] ?? '',
            'address'    =>  $contacts['address'] ?? '',
            'lat'    =>  $contacts['lat'] ?? '',
            'lng'    =>  $contacts['lng'] ?? ''
        ]);
    }

    public function socials()
    {
        $contacts = Setting::socials()->get();
        $user = auth('api')->user();
        $credits = $user ? $user->credits : null;
        return api_response('success', '', ['socials' => $contacts, 'remain_credits' => $credits]);
    }
}
