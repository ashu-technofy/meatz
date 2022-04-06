<?php

namespace Modules\Stores\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Orders\Models\Guest;
use Modules\Sliders\Models\Slider;
use Modules\Stores\Models\Store;
use Modules\Stores\Models\StoreCategory;
use Modules\Stores\Models\StoreProduct;
use Modules\Stores\Resources\BoxesResource;
use Modules\Stores\Resources\BoxResource;
use Modules\Stores\Resources\ProductResource;
use Modules\Stores\Resources\ProductsResource;
use Modules\Stores\Resources\StoreResource;
use Modules\Stores\Resources\StoresResource;

class ApiController extends Controller
{
    public function index()
    {
        $rows = Store::when(request('area_id'), function ($query) {
            if (request('area_id') != 'null' && request('area_id') > 0) {
                return $query->whereHas('areas', function ($query) {
                    return $query->where('areas.id', request('area_id'));
                });
            }
        })
            ->when(request('category_id'), function ($query, $word) {
                return $query->whereHas('categories', function ($query) {
                    $cats = explode(',', request('category_id'));
                    // dd($cats);
                    return $query->whereIn('category_id', $cats);
                });
            })
            ->when(request('keyword'), function ($query, $word) {
                return $query->search($word);
            })->latest()->paginate(24);

        $data['stores'] = StoresResource::collection($rows);

        $fbToken = request()->header('FbToken');
        $user = auth('api')->user() ?? Guest::firstOrCreate(['fb_token' => $fbToken]);
        $cart = $user->cart;
        $data['cart'] = [
            'count' => $cart->sum('count') ?? 0,
            'total' => $cart->sum('total') ?? 0,
        ];

        $data['ads'] = Slider::latest()->get();

        return api_response('success', '', $data);
    }

    public function show($id)
    {
        $info = Store::findOrFail($id);
        $products = $info->products()
            ->when(request('category_id'), function ($query, $cat_id) {
                $cats = explode(',', request('category_id'));
                return $query->whereHas('categories', function ($query) use ($cats) {
                    return $query->whereIn('category_id', $cats);
                });
            });
        switch (request('filter_by')) {
            case 'high_price':
                $products = $products->orderBy('price', 'desc');
                break;
            case 'low_price':
                $products = $products->orderBy('price', 'asc');
                break;
            default:
                $products = $products->latest();
                break;
        }
        $info->products_count = $products->count();
        $info->products = $products->paginate(10);

        $fbToken = request()->header('FbToken');
        $user = auth('api')->user() ?? Guest::firstOrCreate(['fb_token' => $fbToken]);

        $cart = $user->cart;
        $data['categories'] = StoreCategory::get();
        $data['store'] = new StoreResource($info);
        $data['cart'] = [
            'count' => $cart->sum('count') ?? 0,
            'total' => $cart->sum('total') ?? 0,
        ];
        $data['ads'] = Slider::latest()->get()->filter(function ($row) {
            return $row->mymodel != null;
        })->values();
        return api_response('success', '', $data);
    }

    public function product($id)
    {
        $product = StoreProduct::findOrFail($id);
        return \api_response('success', '', new ProductResource($product));
    }

    public function like($id)
    {
        $user = auth('api')->user();
        $is = $user->likes()->where('store_products.id', $id)->exists();
        $liked = 0;
        if ($is) {
            $user->likes()->detach($id);
        } else {
            $user->likes()->attach($id);
            $liked = 1;
        }
        $message = __("Product removed from Whishlist successfully");
        if ($liked) {
            $message = __('Product added to Whishlist successfully');
        }
        return api_response('success', $message, ['liked' => $liked]);
    }

    public function likes()
    {
        $user = auth('api')->user();
        $rows = $user->likes()->latest()->paginate(20);
        return api_response('success', '', ProductsResource::collection($rows));
    }

    public function join_us(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'contact_name' => 'required',
            'mobile' => 'required|digits:8',
            'email' => 'sometimes|nullable|email',
            'service_id' => 'required',
        ]);
        $data = $request->all();
        $data['name'] = ['ar' => request('name'), 'en' => request('name')];
        $data['type'] = 'request';
        Store::create($data);
        return api_response('success', __('Your request sent successfully we will contact you as soon as possible'));
    }

    public function boxes()
    {
        $boxes = StoreProduct::type('box')->whereNull('store_id')->latest()->paginate(20);
        $data['boxes'] = BoxesResource::collection($boxes);

        $fbToken = request()->header('FbToken');
        $user = auth('api')->user() ?? Guest::firstOrCreate(['fb_token' => $fbToken]);

        $cart = $user->cart;
        $data['cart'] = [
            'count' => $cart->sum('count'),
            'total' => $cart->sum('total'),
        ];
        return api_response('success', '', $data);
    }

    public function featured_stores()
    {
        $stores = Store::where('featured', 1)->paginate(20);
        $data['stores'] = StoresResource::collection($stores);
        $data['ads'] = Slider::latest()->get();
        return api_response('success', '', $data);
    }

    public function search()
    {
        $word = request('keyword');
        $products = StoreProduct::when($word, function ($query, $word) {
            return $query->search($word);
        })->latest();
        $stores = Store::when($word, function ($query, $word) {
            $endcoded_word = str_replace('"', "", json_encode($word));
            $endcoded_word = addslashes($endcoded_word);
            return $query->where('name', 'like', "%$word%")
                ->orWhere('name', 'like', "%$endcoded_word%");
        })->latest();
        if (request('more')) {
            $products = $products->paginate(20);
            $stores = $stores->paginate(20);
        } else {
            $products = $products->take(6)->get();
            $stores = $stores->take(6)->get();
        }

        $data['products'] = ProductsResource::collection($products);
        $data['stores'] = StoresResource::collection($stores);

        return api_response('success', '', $data);
    }

    public function categories()
    {
        $rows = StoreCategory::get();
        return api_response('success', '', $rows);
    }

    public function special_boxes(Request $request, $id = null)
    {
        if ($id) {
            $box = StoreProduct::findOrFail($id);
            return api_response('success', '', new BoxResource($box));
        }
        $data['categories'] = StoreCategory::get();
        $rows = StoreProduct::where('type', 'special_box')
            ->when(request('keyword'), function ($query) {
                return $query->search(request('keyword'));
            })->when(request('category_id'), function ($query) {
            return $query->whereHas('categories', function ($query) {
                return $query->where('category_id', request('category_id'));
            });
        })
            ->latest()->get();
        $data['boxs'] = BoxesResource::collection($rows);
        return api_response('success', '', $data);
    }

}
