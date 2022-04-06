<?php

namespace Modules\Orders\Controllers;

use App\Http\Controllers\Controller;
use Modules\Common\Controllers\MyFatoora;
use Modules\HesabeGateway\Controllers\PaymentController;
use Modules\Orders\Models\Order;
use Modules\Stores\Models\StoreProduct;

class WebController extends Controller
{

    public function checkout_callback($status)
    {
        if ($status == 'payment_fail') {
            return view('Orders::success', ['message' => 'Failed payment']);
        }
        $myfatoorah = new MyFatoora();
        $result = $myfatoorah->callback(request('paymentId'));
        if (!$result->IsSuccess) {
            return view('Orders::success', ['message' => 'Failed payment']);
        }
        // dd($result->Data->InvoiceReference , request('paymentId'));
        $data = $result->Data->UserDefinedField;
        $data = (array) json_decode($data);
        $order_id = $data['order_id'];
        $order = Order::withoutGlobalScopes()->findOrFail($order_id);
        $order->payment_id = request('paymentId');
        $order->transaction_id = $result->Data->InvoiceReference;
        $order->paid = 1;
        $order->status = 'pending';
        // $order->payment = request()->all();
        $order->save();
        $order->restore();
        $order->myuser->cart()->delete();
        $order->myuser->notifications()->create([
            'order_id' => $order->id,
            'text' => "Your order #:num status changed to {$order->status}",
            'model' => 'order',
        ]);
        $token = $order->myuser->device->device_token ?? $order->myuser->fb_token ?? '';
        $platform = $order->myuser->device->device_type ?? $order->myuser->platform ?? 'android';
        $lang = $order->myuser->lang ?? 'en';
        if($lang == 'en'){
            $message = "Order status changed to {$order->status} for order #".$order->id;
        }else{
            $message = "تم تغيير حالة الطلب #{$order->id} الى " . __($order->status);
        }
        $result = send_fcm($token, $platform, $message, $order->id);
        // dd($order->myuser , $token, $platform, $message, $order->id , $result);
    
        $order->notifications()->create([
            'user_id' => $order->user_id,
            'text' => __(
                "Successfull payment , your order pending to be transfered"
            ),
        ]);

        foreach ($order->products as $product) {
            if ($current = StoreProduct::find($product->id)) {
                // dd($current->num , $product->pivot->count);
                $current->update(['num' => $current->num - $product->pivot->count]);
            }
        }
        return api_response('success' , '' , [
            'payment_id' => $order->payment_id,
            'transaction_id' => $order->transaction_id,
            'order_id' => $order->id
        ]);
        // return redirect()->to('/')->with('success', __('Successfull payment'));
        return view('Orders::success', ['message' => __('Successfull payment')]);
    }
}
