<?php

namespace Modules\Orders\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Orders\Models\Purchase;
use Modules\Orders\Resources\PurchaseResource;
use Modules\Orders\Resources\PurchasesResource;

class PurchasesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index($message = null)
    {
        $row = auth('api')->user()->purchases()->get();
        return \api_response('success', $message, PurchasesResource::collection($row));
    }


    public function show($id)
    {
        $user = auth('api')->user();
        $purchase = $user->purchases()->findOrFail($id);
        return \api_response('success', '', new PurchaseResource($purchase));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' =>  'required',
            'brief' =>  'required'
        ]);
        $user = auth('api')->user();
        $list = $user->purchases()->create([
            'title' =>  request('title'),
            'brief' => request('brief')
        ]);
        return api_response('success', __("Purchase list created successfully"));
    }


    public function update(Request $request, $id)
    {
        $user = auth('api')->user();
        $purchase = $user->purchases()->findOrFail($id);
        $data = array_filter(request(['title', 'brief']));
        $purchase->update($data);
        return api_response('success', __("Purchase list updated successfully"));
    }

    public function destroy($id)
    {
        $purchase = auth('api')->user()->purchases()->findOrFail($id);
        $purchase->delete();
        return $this->index(__("Purchase list deleted successfully"));
        return \api_response('success', __("Purchase list deleted successfully"));
    }


    public function add_to_list()
    {
        $this->validate(request(), [
            'list_id'    =>  'required',
            'product_id'    =>  'required',
            'count' =>  'required'
        ]);
        $user = auth('api')->user();
        $list = $user->purchases()->findOrFail(request('list_id'));
        $products = $list->products;
        $i = 0;
        $rows = [];
        if ($products) {
            foreach ($products as $row) {
                if ($row['product_id'] == request('product_id')) {
                    if (!request('count')) {
                        return $this->remove_from_list(request('list_id'), request('product_id'));
                    }
                    $row['count'] = request('count');
                    $i = 1;
                }
                $rows[] = $row;
            }
        }
        if (!$i) {
            $rows[] = [
                'product_id'    =>  request('product_id'),
                'count' =>  request('count')
            ];
        }
        $list->update(['products' => $rows]);
        return api_response('success', __('Product added to list successfully'));
    }

    public function remove_from_list($list_id = null, $product_id = null)
    {
        if (!($list_id && $product_id)) {
            $this->validate(request(), [
                'list_id'    =>  'required',
                'product_id'    =>  'required'
            ]);
            $list_id = request('list_id');
            $product_id = request('product_id');
        }
        $user = auth('api')->user();
        $list = $user->purchases()->findOrFail($list_id);
        $products = $list->products;
        $rows = [];
        if ($products) {
            foreach ($products as $key => $row) {
                if ($row['product_id'] != $product_id) {
                    $rows[] = $row;
                }
            }
        }
        $list->update(['products' => $rows]);
        return api_response('success', __('Product removed from list successfully'), $list->products_list);
    }

    public function list_to_cart($id)
    {
        $user = auth('api')->user();
        $list = $user->purchases()->findOrFail($id);
        if (!$list->products) {
            return api_response('success', "قائمة المشتريات فارغة", ['empty' => 1]);
        }
        if (request()->has('empty_cart')) {
            if (request('empty_cart')) {
                $user->cart()->delete();
            }
        } elseif ($user->cart) {
            return api_response('success', __('Your cart is not empty do you want to empty it ?'), ['cart' => 1]);
        }
        foreach ($list->products as $row) {
            $user->cart()->firstOrCreate(['product_id' =>  $row['product_id']])->update(['count'      =>  $row['count']]);
        }
        return api_response('success', __('List added to cart successfully'));
    }
}
