<?php

namespace Modules\Orders\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Orders\Models\Guest;
use Modules\Stores\Models\StoreOption;
use Modules\Stores\Models\StoreProduct;

class CartController extends Controller
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

    public function cart($message = null)
    {
        $data['products'] = $out_stock = [];
        $can_checkout = 1;
        $subtotal = 0;
        $cart = $this->user->cart;
        if (!$cart->count()) {
            return api_response('success', __("Your cart is empty"), ['products' => []]);
        }
        foreach ($cart as $row) {
            $store = $row->store;
            $product = $row->product()->first();
            if ($product) {
                $product->cart_id = $row->id;
                $product->count = $row->count > $product->num ? $product->num : $row->count;
                $product->price = $row->total = $row->count > $product->num ? $row->price * $product->count : $row->total;
                $product->options = is_array($row->options) && count($row->options) ? StoreOption::whereIn('id' , $row->options)->get(['id' , 'name']) : [];
                $product->options_txt = $row->options_txt;
                $product->store = $product->store()->withoutGlobalScopes()->first(['id' , 'name' , 'logo']);
                if($product->num <= 0 && request('clear_out_of_stock')){
                    $row->delete();
                }else{
                    if($product->num <= 0){
                        $can_checkout = 0;
                        $out_stock[] = $product->name;
                    }
                    if(request('test')) dd($row->count , $product->num , $product);
                    $data['products'][] = $product;
                    $subtotal += $row->total;
                    $store_id = $row->store_id;
                }
            }
        }
        $delivery = 0;
        if (($user = auth('api')->user())) {
            $address = $user->addresses()->first();
            $delivery = $address->area->delivery ?? 10;
        }
        // $store = Store::whereId($store_id)->first(['id', 'mode', 'working_days', 'working_from', 'working_to']);
        // $store->working_days = $store->week_days;

        // $days_off = $store->days_off()->pluck('date')->toArray();
        // $days_rows = [];
        // if (in_array($store->mode, ['"later"' , 'later'])) {
        //     $day_orders_count = Order::where('store_id' , $store->id)->whereDate('delivery_date' , date('Y-m-d'))->count();
        //     if ($day_orders_count >= $store->day_orders) {
        //         $days_rows[] = date('d-m-Y');
        //     }
        // }
        // foreach($days_off as $day){
        //     $days_rows[] = date('d-m-Y' , strtotime($day));
        // }
        // $store->days_off = $days_rows;
        // $store->areas = $store->areas()->pluck('areas.id')->toArray();
        if($store) unset($store->areas);
        $data['store'] = $store;
        $data['subtotal'] = number_format($subtotal, 3);
        $data['delivery'] = number_format($delivery, 3);
        $data['total'] = number_format($subtotal + $delivery, 3);
        $data['can_checkout'] = $can_checkout;
        $data['out_of_stock'] = $out_stock;
        return api_response('success', $message, $data);
    }

    public function add_to_cart($data = null)
    {
        $user = $this->user;
        
        if ((!$data) && !request('product_id')) {
            return api_response('error', '', ['product_id' => 'product_id is required'], 422);
        }elseif($data){
            $num = StoreProduct::find($data['product_id'])->num ?? 0;
            if(!$num) return api_response('error' , __('This product not available'));
            if (!is_array($data['options'])) {
                $ops = $data['options'];
                $data['options'] = array_map('intval', explode(',', str_replace('"' , '' , $data['options'])));
                $data['options'] = array_filter($data['options']);
                sort($data['options']);
                // if(count($data['options'])) dd($data , $ops);
            }
            $pcart = $user->cart()
            ->where('product_id' , $data['product_id'])
            ->where('options' , json_encode($data['options']))
            ->first();
            if($pcart){
                $data['count'] += $pcart->count;
                // if($data['product_id'] == 3) dd($data['count']);
                $num = $pcart->product->num;
                if($data['count'] > $pcart->product->num) $data['count'] = $num;
            }
            // if($data['product_id'] == 3) dd($data , $num);
        } elseif (!$data) {
            $data = [
                'product_id' => request('product_id'),
                'count' => request('count', 1),
                'options' => request('options', [])
            ];
        }
        if(is_string($data['options'])){
            $data['options'] = array_map('intval', explode(',', str_replace('"' , '' , $data['options'])));
            $data['options'] = array_filter($data['options']);
        }
        sort($data['options']);
        
        $product = StoreProduct::findOrFail($data['product_id']);
        $count = $data['count'];

        $total = $product->price * $data['count'];
        // dd($data);
        if (is_array($data['options'])) {
            foreach ($data['options'] as $op) {
                $option = StoreOption::find($op);
                $price = $option ? $option->price * $count : 0;
                $total += $price;
            }
        }

        $cart = $user->cart()->first();
        $data = [
            'store_id' => $product->store_id,
            'product_id' => $product->id,
            'count' => $data['count'],
            'options' => $data['options'],
            'notes' => $data['notes'] ?? '',
            'total' => $total,
        ];
        $stores = $user->cart()->pluck('store_id')->toArray();
        $stores = array_filter($stores);
        $data['options'] = array_map('intval', $data['options']);
        if ($cart) {
            // dd(count($stores) , $product->store_id , !in_array($product->store_id , $stores));
            // if (count($stores) && $product->store_id && !in_array($product->store_id , $stores)) {
            //     return api_response('error', __("You can order from one restaurant only at single order"));
            // }
            if ($pcart = $user->cart()->where(['product_id' => $data['product_id']])
            ->where('options' , json_encode($data['options']))->first()) {
                $pcart->update($data);
            } else {
                $user->cart()->create($data);
            }
        } else {
            $user->cart()->create($data);
        }
        // $this->user->update(['last_copon' => null]);
        return $this->cart(__("Product added to cart"));
        return api_response('success', __("Product added to cart"), ['cart' => $user->cart()->count()]);
    }

    public function clear_cart()
    {
        $this->user->cart()->delete();
        return api_response('success', __("Cart cleared successfully"), ['cart' => 0]);
    }

    public function remove_from_cart()
    {
        // $this->user->cart()->where('product_id', request('product_id'))->delete();
        $this->user->cart()->where('id', request('product_id'))->delete();
        return $this->cart(__("Product removed from cart"));
        return api_response('success', __("Product removed from cart"), ['cart' => $this->user->cart()->count()]);
    }
}
