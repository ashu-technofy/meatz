<?php

namespace Modules\Copons\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Copons\Models\Copon;

class ApiController extends Controller
{

    public function check_copon(Request $request)
    {
        $this->validate($request, [
            'code'  =>  'required',
            'total' =>  'required|numeric'
        ]);
        $total = request('total');
        $copon = Copon::valid()->whereCode(request('code'))->first();
        if (!$copon) {
            return api_response('error', __("Copon code is invalid"));
        }
        if(($user = auth('api')->user())){
            if(($user->orders && $user->orders()->where('copon_id' , $copon->id)->exists()) 
            // || $copon->code == $user->last_copon
            ){
                return api_response('success' , __('This copon used before , you can not use it again') , ['used' => 1]);
            }
        }
        $discount = $copon->discount;
        if ($copon->type == 'precentage') {
            $discount = $total * ($copon->discount / 100);
            $discount = $copon->max_discount && $discount > $copon->max_discount ? $copon->max_discount : $discount;
        }

        if(($total - $discount) < 0){
            return api_response('error' , __("The coupon doesn’t meet the conditions specified"));
        }
        $total = round_me(($total - $discount) , 2);
        return api_response('success', __("Your copon added successfully"), [
            'copon_id' => $copon->id,
            'discount' => round_me($discount , 2),
            'total' => $total > 0 ? $total : 0
        ]);
    }
}
