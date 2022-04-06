<?php

namespace Modules\User\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Common\Controllers\MyFatoora;
use Modules\Common\Models\Notification;
use Modules\Common\Resources\NotificationResource;
use Modules\Orders\Models\Guest;
use Modules\User\Models\Device;
use Modules\User\Models\User;
use Modules\User\Requests\UserRequest;
use Modules\User\Resources\UserResource;

class ApiController extends Controller
{

    public function show()
    {
        $user = auth('api')->user();
        $user = User::where('id', $user->id)->first();
        $user->access_token = auth('api')->login($user);
        return api_response('success', '', new UserResource($user));
    }


    public function change_password(Request $request)
    {
        $user = auth('api')->user();
        if (($user->social_id && $user->password) || !$user->social_id) {
            if (!\Hash::check(request('old_password'), $user->password)) {
                return api_response('error', __("Old password not matched"));
            }
        }
        $this->validate($request, [
            'password' => 'required|min:6'
        ]);
        $user->update(['password' => request('password')]);
        return api_response('success', __('Your password changed successfully'));
    }

    public function update(UserRequest $request)
    {
        $user = auth('api')->user();
        if (request('old_password')) {
            if (($user->social_id && $user->password) || !$user->social_id) {
                if (!\Hash::check(request('old_password'), $user->password)) {
                    return api_response('error', __("Old password not matched"));
                }
            }
            // $user->update(['password' => request('password')]);
        }
        $user->update(array_filter(request()->all()));
        $user->access_token = auth('api')->login($user);
        return api_response('success', __("Your Profile has been Successfully updated."), new UserResource($user));
    }

    public function notifications()
    {
        $user = auth('api')->user() ?? Guest::where('fb_token', request()->header('FbToken'))->first() ?? new User;
        if (!$user) {
            return api_response('error', 'User or Guest not found');
        }
        if(!$user->id) $user->created_at = date('Y-m-d');
        
        if (auth('api')->check()) {
            $notifications = Notification::where(function($query) use($user){
                return $query->where('user_id', $user->id)
                ->orWhere('type', 'global');
            })
            ->where('created_at' , '>=' , $user->created_at)
            ->latest()
            ->paginate(20);
        }else{
            $notifications = Notification::where(function($query) use($user){
                return $query->where('guest_id', $user->id)
                ->orWhere('type', 'global');
            })
            ->where('created_at' , '>=' , $user->created_at)
            ->latest()
            ->paginate(20);
        }

        $notifications = NotificationResource::collection($notifications);
        return api_response('success', '', $notifications);
    }

    public function wallet_get(){
        $user = auth('api')->user();
        $points = $user->points ?? 0;
        return api_response('success' , '' , ['points' => $points]);
    }

    public function wallet_post(Request $request){
        $this->validate($request , [
            'points' => 'required|numeric'
        ]);
        $user = auth('api')->user();
        $data['username'] = $user->username;
        $data['email'] = $user->email;
        $data['total'] = $request->points;
        $data['paymentType'] = 1;
        $data['callback_url'] = route('points_checkout_callback', 'success');
        $data['error_url'] = route('points_checkout_callback', 'payment_fail');
        if(strpos($data['callback_url'] , ':8000')){
            $data['callback_url'] = str_replace('localhost:8000' , 'linekw.net/meatz' , $data['callback_url']);
            $data['error_url'] = str_replace('localhost:8000' , 'linekw.net/meatz' , $data['error_url']);
        }
        $data['order_data'] = ['points' => $request->points , 'user_id' => $user->id];

        $data['items'][] = [
            "ItemName" => __("Charge Wallet"),
            "Quantity" => 1,
            "UnitPrice" => $request->points,
        ];
        // dd($data);

        $payment = new MyFatoora;
        $link = $payment->send_payment($data);
        
        return api_response('success' , '' , [
            'link' => $link
        ]);
    }


    public function logout(Request $request){
        $user = auth('api')->user();
        Device::where('user_id' , $user->id)->delete();
        return api_response('success' , '');
    }
}
