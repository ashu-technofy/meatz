<?php

namespace Modules\Orders\Controllers;

use App\Http\Controllers\Controller;
use Modules\Common\Controllers\MyFatoora;
use Modules\Orders\Models\Order;
use Modules\Stores\Models\Store;
use Modules\Stores\Models\StoreProduct;

class AdminController extends Controller
{
    public function index()
    {
        $orders = auth('stores')->check() ? Order::forStore() : new Order();
        $orders = $orders->when(request('status'), function ($query) {
            if(request('status') == 'cancel_request'){
                return $query->whereNotNull('cancel_request');
            }else{
                return $query->where('status', request('status'));
            }
        });
        if (request('schedule')) {
            $order = $orders->where(function ($query) {
                return $query->where('delivery_date', '!=', null);
            });
        }
        $orders = $orders->when(request('keyword'), function ($query) {
            $word = request('keyword');
            return $query->whereHas('user', function ($query) use ($word) {
                    return $query->where('username', 'like', '%' . $word . '%')
                        ->orWhere('mobile', 'like', '%' . $word . '%')
                        ->orWhere('email', 'like', '%' . $word . '%');
                })->orWhere('id', $word);
            })
            ->when(request('store_id'), function ($query , $val) {
                $prods = Store::find($val)->products()->pluck('id')->toArray() ?? [];
                return $query->whereHas('items' , function($query) use($prods){
                    return $query->whereIn('product_id' , $prods);
                });
            })
            ->when(request('delivery_type'), function ($query) {
                return $query->where('delivery_type', request('delivery_type'));
            })
            ->when(request('payment_method'), function ($query) {
                return $query->where('payment_method', request('payment_method'));
            })
            ->when(request('user_id'), function ($query) {
                return $query->where('user_id', request('user_id'));
            });
        $count = $orders->count();
        $total = $orders->sum('total');

        $cur_orders = clone $orders;
        $total_cash = $cur_orders->where('payment_method', 'cash')->sum('total');

        $cur_orders = clone $orders;
        $total_paid = $cur_orders->where('payment_method', 'cash')->orWhere('paid', 1)->sum('total');

        $cur_orders = clone $orders;
        $total_knet = $cur_orders->where('payment_method', 'knet')->sum('total');

        $cur_orders = clone $orders;
        $total_wallet = $cur_orders->where('payment_method', 'wallet')->sum('total');

        $cur_orders = clone $orders;
        $total_50 = $cur_orders->where('payment_method', '50')->sum('total');

        $orders = $orders->latest()->paginate(25);
        $title = request('status', "Orders");
        return view('Orders::admin.index', get_defined_vars());
    }

    public function show($id)
    {
        $order = auth('stores')->check() ? Order::forStore()->findOrFail($id) : Order::withoutGlobalScopes()->findOrFail($id);
        $title = __("Order ID") . " #" . $order->id;
        $order->update(['seen' => 1]);
        return view('Orders::admin.show', get_defined_vars());
    }

    public function status($order_id = null, $status = null)
    {
        if (!$order_id) {
            $this->validate(request(), [
                'status' => 'required',
                'order_id' => 'required',
            ]);
        }
        $order_id = $order_id ?? request('order_id');
        $status = $status ?? request('status');
        $order = Order::withoutGlobalScopes()->findOrFail($order_id);
        $order_status = $order->status;

        $user = auth()->user();

        $store = auth('stores')->user();
        if ($store) {
            $order->items()->whereHas('product', function ($query) use ($store) {
                return $query->where('store_id', $store->id);
            })->update(['status' => $status]);
        }
        if ($user && $user->role_id) {
            $order->update(['status' => $status]);
            $order->items()->update(['status' => $status]);
        } elseif ($order->items()->where('status', $status)->count() == $order->items()->count()) {
            $order->update(['status' => $status]);
        }

        // $order->update(['status' => $status]);
        // dd($id , $order);
        $order->myuser->notifications()->create([
            'order_id' => $order->id,
            'text' => "Your order #:num status changed to $status",
            'model' => 'order',
        ]);

        $token = $order->myuser->device->device_token ?? $order->myuser->fb_token ?? '';
        $platform = $order->myuser->device->device_type ?? $order->myuser->platform ?? 'android';
        $message = "تم تغيير حالة الطلب #{$order->id} الى " . __($status);
        if ($order->myuser->lang == 'en') {
            $message = "Order #{$order->id} status changed to {$status}";
        }
        send_fcm($token, $platform, $message, $order->id);

        if (in_array($order_status, ['pending', 'Pending']) &&
            $status == 'Canceled' &&
            in_array($order->payment_method, ['knet', 'wallet'])) {
            
            foreach ($order->products as $product) {
                if ($current = StoreProduct::find($product->id)) {
                    // dd($current->num , $product->pivot->count);
                    $current->update(['num' => $current->num + $product->pivot->count]);
                }
            }

            if (!request('refund')) {
                $user = $order->user;
                // mydd([$user->wallet, $order->total]);
                $user->update(['wallet' => $user->wallet + $order->total]);
            }else{
                $this->refund_order($order);
            }
        }

        return response()->json([
            'url' => route('admin.orders.show', $order->id),
            'message' => __('Order status changed succcessfully'),
        ]);
    }

    function refund_order($order){
        
        $myfatoorah = new MyFatoora();
        $suppliers = get_supplier_arr($order , true);
        $suppliers[] = [
            "SupplierCode" => (int) app_setting('supplier_code'),
            "InvoiceShare" => $order->delivery,
        ];
        $data = [
            'order_id' => $order->id,
            'suppliers' => $suppliers,
            'total' =>  $order->total
        ];
        // dd($data);
        $response = $myfatoorah->supplier_refund($order->payment_id, $data);
        // dd($data , $response);
        // dd($response);
        if ($response->IsSuccess && isset($response->Data->RefundReference)) {
            $order->update(['refund_refrence' => $response->Data->RefundReference]);
        }
    }

    public function bill($id)
    {
        $order = Order::findOrFail($id);
        return view("Orders::admin.bill", get_defined_vars());
    }

    public function cancel_request($id, $status)
    {
        $order = Order::find($id);
        if ($status == 'accept') {
            $this->status($order->id, 'Canceled');
            $order->cancel_request = 2;
            $order->save();
            return back()->with('success', __('Request accepted succcessfully'));
        }
        // $order->status = $status = 'pending';
        $order->cancel_request = -1;
        $order->save();
        $token = $order->myuser->device->device_token ?? $order->myuser->fb_token ?? '';
        $platform = $order->myuser->device->device_type ?? $order->myuser->platform ?? 'android';
        $message = "تم رفض إلغاء الطلب #{$order->id} ";
        if ($order->myuser->lang == 'en') {
            $message = "Order #{$order->id} cancelation request rejected";
        }
        send_fcm($token, $platform, $message, $order->id);
        return back()->with('success', __('Request rejected succcessfully'));
    }
}
