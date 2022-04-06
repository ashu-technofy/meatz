<?php

namespace Modules\Orders\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Orders\Models\Guest;
use Modules\Orders\Models\Order;
use Modules\Orders\Resources\OrderResource;
use Modules\Orders\Resources\OrdersResource;

class ApiController extends Controller
{
    public function index()
    {
        $orders = auth('api')->user()->orders()->latest()->get();
        return api_response('success', '', OrdersResource::collection($orders));
    }

    public function show($id)
    {
        $user = auth('api')->user() ?? Guest::firstOrCreate(['fb_token' => request()->header('FbToken')]);
        $order = $user->orders()->withoutGlobalScopes()->findOrFail($id);
        return api_response('success', '', new OrderResource($order));
    }

    public function rate(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $this->validate($request, [
            'rate'  =>  'required|numeric'
        ]);
        $order->rate()->create([
            'user_id'   =>  auth('api')->user()->id,
            'rate'  =>  request('rate'),
            'text'  =>  request('text')
        ]);
        return api_response('success', __("Order rated successfully"));
    }

    public function reorder($id)
    {
        $order = auth('api')->user()->orders()->where('id', $id)->firstOrFail(['address_id' , 'items', 'total', 'subtotal', 'delivery'])->toArray();
        $order = auth('api')->user()->orders()->create($order);
        return api_response('success', __("Order created successfully"), new OrderResource($order));
    }

    public function cancel_request(Request $request , $id){
        $user = auth('api')->user();
        if (!$user) {
            $fbToken = request()->header('FbToken');
            if (!$fbToken) {
                $this->validate($request, ['FbToken' => 'required']);
            }
            $user = Guest::firstOrCreate(['fb_token' => $fbToken]);
        }
        // dd($user);
        $order = $user->orders()->findOrFail($id);
        if(!$order){
            return api_response('error' , __('This order not found'));
        }elseif($order->status == 'Delivered'){
            return api_response('error' , __('You can not cancel this order'));
        }
        $order->cancel_request = 1;
        $order->seen = null;
        $order->save();
        return api_response('success' , __('Your cancellation request has been sent to our team') , new OrderResource($order));
    }
    
}
