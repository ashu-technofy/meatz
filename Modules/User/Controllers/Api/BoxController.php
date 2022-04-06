<?php

namespace Modules\User\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Orders\Controllers\CartController;
use Modules\Stores\Models\StoreProduct;
use Modules\Stores\Resources\BoxProductsResource;
use Modules\User\Resources\BoxesResource;

class BoxController extends Controller
{
    public function index(){
        $user = auth('api')->user();
        $boxes = $user->boxes()->latest()->get();
        return api_response('success' , '' , BoxesResource::collection($boxes));
    }

    public function show($id){
        $user = auth('api')->user();
        $box  = $user->boxes()->findOrFail($id);
        $products = BoxProductsResource::collection($box->products);
        unset($box->products);
        $data['box'] = $box;
        $data['products'] = $products;
        return api_response('success' , '' , $data);       
    }

    public function store(Request $request){
        $this->validate($request , [
            'name' => 'required'
        ]);
        $user = auth('api')->user();
        $user->boxes()->create(['name' => $request->name]);
        $boxes = $user->boxes()->latest()->get();
        return api_response('success' , __('Box added successfully') , BoxesResource::collection($boxes));
    }

    public function destroy($id){
        $user = auth('api')->user();
        $user->boxes()->findOrFail($id)->delete();
        $boxes = $user->boxes()->latest()->get();
        return api_response('success' , __('Box removed successfully') , BoxesResource::collection($boxes));
    }

    public function add_item_to_boxes(Request $request){
        $this->validate($request , [
            'product_id' => 'required|exists:store_products,id',
            'count' => 'required',
            'boxes' => 'required'
        ]);
        $id = $request->product_id;
        $boxes = $request->boxes;
        if(is_string($boxes)) $boxes = explode(',' , $boxes);
        $user = auth('api')->user();
        $item = StoreProduct::find($id);

        foreach ($boxes as $box_id) {
            $box = $user->boxes()->findOrFail($box_id);
            // if(count($box->products) && !in_array($item->store_id , $box->products()->pluck('store_id')->toArray())){
            //     return api_response('error' , __('This box have items from another store') , new BoxesResource($box));
            // }
            $box->products()->detach($id);
            $box->products()->attach($id, [
                'count' => request('count', 1),
                'options' => json_encode(request('options', []))
            ]);
        }
        return api_response('success' , __('Item added to box successfully'));
    }
    
    public function clear_items($box_id){
        $user = auth('api')->user();
        $box = $user->boxes()->findOrFail($box_id);
        foreach($box->products as $product){
            $box->products()->detach($product->id);
        }
        return api_response('success' , __('Box is now empty'));
    }

    public function add_item(Request $request , $box_id){
        $this->validate($request , [
            'product_id' => 'required|exists:store_products,id',
            'count' => 'required'
        ]);
        $id = $request->product_id;

        $user = auth('api')->user();
        $box = $user->boxes()->findOrFail($box_id);
        $box->products()->detach($id);
        $box->products()->attach($id , [
            'count' => request('count' , 1),
            'options' => json_encode(request('options' , []))
        ]);
        return api_response('success' , __('Item added to box successfully'));
    }

    public function remove_item(Request $request , $box_id){
        $this->validate($request , [
            'product_id' => 'required|exists:store_products,id'
        ]);
        $ids = $request->product_id;
        $ids = explode(',' , $ids);
        $user = auth('api')->user();
        foreach ($ids as $id) {
            $box = $user->boxes()->findOrFail($box_id);
            $box->products()->detach($id);
        }
        return api_response('success' , __('Item removed from box successfully'));
    }

    public function add_to_cart(Request $request, $id){
        $user = auth('api')->user();
        $box = $user->boxes()->findOrFail($id);
        $cart = new CartController($request);
        $products = $box->products;
        foreach($products as $row){
            $data = [
                'product_id' => $row->pivot->product_id,
                'count' => $row->pivot->count,
                'options' => $row->pivot->options ?? []
            ];
            $cart->add_to_cart($data);
        }
        return api_response('success' , __('Box added to cart successfully'));
    }
}
