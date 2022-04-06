<?php

namespace Modules\Orders\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Addresses\Models\Address;
use Modules\Areas\Models\Area;
use Modules\Common\Controllers\MyFatoora;
use Modules\Copons\Models\Copon;
use Modules\Orders\Models\Guest;
use Modules\Orders\Models\Order;
use Modules\Orders\Resources\OrderResource;
use Modules\Stores\Models\StoreProduct;

class CheckoutController extends Controller
{
    private $user;
    public function __construct(Request $request)
    {
        $user = auth('api')->user();
        if (!$user) {
            $fbToken = request()->header('FbToken');
            if (!$fbToken) {
                $this->validate($request, ['FbToken' => 'required']);
            }
            $user = Guest::firstOrCreate(['fb_token' => $fbToken]);
        }
        $this->user = $user;
    }

    function new (Request $request, $schedule = false) {
        $user = auth('api')->user();
        $execute = $request->isMethod('GET') ? 0 : 1;
        if (!auth('api')->check()) {
            if (!$request->isMethod('GET')) {
                $this->validate($request, [
                    'username' => 'required',
                    'email' => 'sometimes|nullable|email',
                    'mobile' => 'required',
                    'address' => 'required',
                    'area_id' => 'required|exists:areas,id',
                    'payment_method' => 'required|in:knet,visa,gift,cash',
                    'delivery_type' => 'required|in:usual,express',
                ]);
            }
            $guest = $this->user;
            $guest_info = request()->all();
            $guest_info['lang'] = request()->header('Lang') ?? 'ar';
            // dd($guest_info);
            $guest->update($guest_info);
            $cart = $guest->cart;
        } else {
            $cart = $user->cart;
        }
        $guest = Guest::where('fb_token', request()->header('FbToken'))->first();
        if ($user && !$cart->count()) {
            $cart = $guest->cart ?? [];
            $user->cart()->delete();
            foreach ($cart as $item) {
                $user->cart()->create($item->toArray());
            }
        }
        if ($user) {
            $address = Address::find(request('address_id')) ?? $user->addresses()->first();
            if (!request('purchase_id') && !$request->isMethod('GET')) {
                $this->validate($request, [
                    'address_id' => 'required|exists:addresses,id',
                    'delivery_type' => 'required|in:usual,express',
                ]);
            } elseif (!$address) {
                return \api_response('error', __('You should add address firstly'));
            }
        }
        if ($schedule) {
            if (!$request->isMethod('GET')) {
                $this->validate($request, [
                    'delivery_date' => 'required|date',
                    'delivery_time' => 'required',
                ]);
            }
        }
        // dd($cart);
        if ((!count($cart)) && !request('purchase_id')) {
            return api_response('success', __("Your cart is empty"), ['products' => []]);
        }
        // create payment paramters
        $subtotal = 0;
        $products = $prices = $counts = $myitems = [];
        $delivery_type = request('delivery_type', 'usual');
        $all_stores = $this->user->cart()->has('store')->pluck('store_id') ?? [];
        $subtotal = $cart->sum('total');
        // dd($subtotal , $cart);
        if (($user = auth('api')->user())) {
            $address = $user->addresses()->find(request('address_id')) ?? $user->addresses()->first();
            $delivery_area = $address->area;
        } else {
            $delivery_area = Area::find(request('area_id'));
        }
        $delivery = $delivery_area->delivery ?? 10;
        $delivery_express = $delivery_area->delivery_express ?? 15;
        $discount = 0;
        $copon = null;
        $copon = $this->check_copon($subtotal);
        if(is_array($copon)){
            $subtotal = $copon['subtotal'];
            $discount = $copon['discount'];
            $copon = $copon['copon'];
        }
        $total = $subtotal + $delivery;
        if ($delivery_type == 'express') {
            $total = $subtotal + $delivery_express;
        }

        $pay_now = $pay_later = 0;
        if (request('payment_method') == '50') {
            $pay_now = $pay_later = $total / 2;
        }

        if (!$execute) {
            return \api_response('success', '', [
                'discount' => $discount,
                'subtotal' => $subtotal,
                'express_delivery' => count(array_filter(array_unique($this->user->cart()->pluck('store_id')->toArray()))) > 1 ? 0 : 1,
                'express_delivery_cost' => $delivery_express,
                'express_delivery_message' => app_setting('express_delivery_message'),
                'delivery' => $delivery,
                'total' => $total,
                // 'fast_delivery_cost' => app_setting('fast_delivery_cost'),
                'wallet' => $this->user->wallet ?? 0,
                'dates' => date_range($all_stores),
                'periods' => store_periods($all_stores),
            ]);
        }
        $last_id = Order::latest()->first()->id ?? 1;
        $last_id += 1001;
        $code = "MZ" . $last_id;
        // if (request('payment_method') != 'cash') $status = -1;
        $order = Order::create([
            'status' => !in_array(request('payment_method'), ['cash', 'wallet']) ? -1 : "pending",
            'code' => $code,
            'user_id' => $user->id ?? null,
            'store_id' => $store->id ?? null,
            'schedule' => $schedule ? 1 : 0,
            'address_id' => request('address_id') ?? $address->id ?? null,
            'guest_id' => isset($guest) ? $guest->id : null,
            'copon_id' => request('copon_id'),
            'discount' => $discount ?? null,
            'total' => round_me($total),
            'credits' => $credits ?? null,
            'subtotal' => round_me($subtotal),
            'delivery_type' => $delivery_type,
            'delivery' => $delivery_type == 'usual' ? $delivery : $delivery_express,
            'delivery_date' => date('Y-m-d', strtotime(request('delivery_date'))),
            'delivery_time' => request('delivery_time'),
            'payment_method' => request('payment_method'),
            'type' => request('delivery_date') ? 'later' : "now",
            'delivery_period_id' => request('delivery_period_id'),
            // 'notes' => request('notes'),
        ]);

        if ($copon && !is_object($copon)) {
            $this->user->update(['last_copon' => $copon->code]);
        }
        foreach ($cart as $item) {
            $order->items()->create($item->toArray());
        }

        $this->credit_payment($order, $total);

        // if (isset($user) && $user->invited_by && $user->orders()->count() == 1 && $by = User::find($user->invited_by)) {
        //     $by->update(['credits' => $by->credits + 10]);
        // }
        // $this->user->update(['last_copon' => null]);

        // $order->myuser->cart()->delete();
        // $guest->cart()->delete();
        // $this->user->orders()->withoutGlobalScopes()->where('status', "-1")->delete();

        if (request('payment_method') == 'knet') {
            $paymentUrl = $this->create_payment_url($order, request('payment_method'));
            return api_response('success', '', ['paymentUrl' => $paymentUrl, 'order_id' => $order->id]);
        }elseif(request('payment_method') == 'cash'){
            foreach ($order->products as $product) {
                if ($current = StoreProduct::find($product->id)) {
                    // dd($current->num , $product->pivot->count);
                    $current->update(['num' => $current->num - $product->pivot->count]);
                }
            }
        }

        $this->send_notf($order);

        $this->user->cart()->delete();
        return api_response('success', '', ['paymentUrl' => "", 'order_id' => $order->id]);
        return api_response('success', __("Order created successfully"), new OrderResource($order));
    }

    public function check_copon($subtotal)
    {
        if ($copon = Copon::find(request('copon_id'))) {
            $discount = $copon->discount;
            if (($this->user->orders && $this->user->orders()->where('copon_id', $copon->id)->exists())
                || $copon->code == $this->user->last_copon) {
                return api_response('success', __('This copon used before , you can not use it again'), ['used' => 1]);
            }
            if ($copon->type == 'precentage') {
                $discount = $subtotal * ($copon->discount / 100);
                $discount = $copon->max_discount && $discount > $copon->max_discount ? $copon->max_discount : $discount;
                $subtotal = $subtotal - $discount;
            } else {
                $discount = $copon->discount;
                $subtotal = $subtotal - $copon->discount;
            }
            $subtotal = $subtotal > 0 ? $subtotal : 0;
            return ['copon' => $copon, 'subtotal' => $subtotal, 'discount' => $discount];
        }
        return ['copon' => null, 'subtotal' => $subtotal, 'discount' => 0];
    }

    public function send_notf($order)
    {
        $order->myuser->notifications()->create([
            'order_id' => $order->id,
            'text' => "Your order #:num status changed to {$order->status}",
            'model' => 'order',
        ]);
        $token = $order->myuser->device->device_token ?? $order->myuser->fb_token ?? '';
        $platform = $order->myuser->device->device_type ?? $order->myuser->platform ?? 'android';
        $lang = request()->header('Lang') ?? $order->myuser->lang ?? 'en';
        if ($lang == 'en') {
            $message = "Order status changed to {$order->status} for order #" . $order->id;
        } else {
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
    }

    public function reorder(Request $request, $order_id)
    {
        $user = auth('api')->user();
        $order = $user->orders()->findOrFail($order_id);
        $store_id = $order->store_id;
        $user->cart()->delete();
        foreach ($order->items as $item) {
            if ($item->product) {
                $item = $item->toArray();
                $item['store_id'] = $store_id;
                $user->cart()->create($item);
            }
        }
        $api = new CartController($request);
        return $api->cart();
        return api_response('success', __('This order products added to your cart'));
    }

    private function credit_payment($order, $total)
    {
        if (request('payment_method') == 'wallet') {
            if ($user = auth('api')->user()) {
                if (!$user->wallet) {
                    // dd($user->id);
                    return api_response('error', __('Your wallet empty'));
                }
                // dd($total , $user->wallet);
                if ($total <= $user->wallet) {
                    $user->wallet -= $total;
                    $user->save();
                    $wallet = $total;
                    $total = 0;
                    $order->status = 'pending';
                    $order->payment_method = 'wallet';
                    $order->wallet = $wallet;
                    $order->save();

                    foreach ($order->products as $product) {
                        if ($current = StoreProduct::find($product->id)) {
                            // dd($current->num , $product->pivot->count);
                            $current->update(['num' => $current->num - $product->pivot->count]);
                        }
                    }
                } else {
                    $wallet = $user->wallet;
                    $user->wallet = 0;
                    $user->save();
                    $order->wallet = $wallet;
                    $order->save();
                    $total -= $wallet;
                }
                if ($user->device) {
                    $token = $user->device->device_token;
                    $platform = $user->device->device_type;
                    $message = __('Your wallet updated successfully');
                    // $message = __("Your order #:num status changed to {$order->status}", ['num' => $order->id]);
                    send_fcm($token, $platform, $message, null, null, $user->wallet);
                }
            }
        }
    }

    private function create_payment_url($order, $payment_method)
    {
        $data['username'] = $order->myuser->username ?? $order->myuser->first_name ?? 'Notdefined';
        $data['email'] = $order->myuser->email ?? 'info@meatzkw.com';
        $data['total'] = $order->total;
        $data['paymentType'] = 1;
        $data['callback_url'] = route('checkout_callback', 'success');
        $data['error_url'] = route('checkout_callback', 'payment_fail');
        if (strpos($data['callback_url'], ':8000')) {
            $data['callback_url'] = str_replace('localhost:8000', 'linekw.net/meatz', $data['callback_url']);
            $data['error_url'] = str_replace('localhost:8000', 'linekw.net/meatz', $data['error_url']);
        }
        $data['order_data'] = ['order_id' => $order->id];
        foreach ($order->products as $row) {
            $data['items'][] = [
                "ItemName" => $row->name,
                "Quantity" => $row->pivot->count,
                "UnitPrice" => $row->pivot->total / $row->pivot->count,
            ];
        }
        if ($order->copon) {
            $data['items'][] = [
                "ItemName" => __("Copon discount"),
                "Quantity" => 1,
                "UnitPrice" => -$order->discount,
            ];
        }
        $data['items'][] = [
            "ItemName" => __("Delivery"),
            "Quantity" => 1,
            "UnitPrice" => $order->delivery,
        ];
        $suppliers = get_supplier_arr($order);
        $sup_total = $suppliers[app_setting('supplier_code')]['InvoiceShare'] ?? 0;
        $suppliers[app_setting('supplier_code')] = [
            "SupplierCode" => app_setting('supplier_code'),
            "InvoiceShare" => $order->delivery + $sup_total,
        ];
        if($order->copon){
            $sup_total = $suppliers[app_setting('supplier_code')]['InvoiceShare'] ?? 0;
            // dd($sup_total);
            $suppliers[app_setting('supplier_code')] = [
                "SupplierCode" => app_setting('supplier_code'),
                'InvoiceShare' => -$order->discount + $sup_total
            ];
        }

        $data['suppliers'] = array_values($suppliers);
        // dd($data);
        $payment = new MyFatoora;
        $link = $payment->send_payment($data);
        // dd($link);
        return $link;
    }
}
