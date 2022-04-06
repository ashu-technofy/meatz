<?php

namespace Modules\Stores\Controllers;

use Illuminate\Http\Request;
use Modules\Common\Controllers\HelperController;
use Modules\Stores\Models\Store;
use Modules\Stores\Models\StoreCategory;
use DB;
use Carbon\Carbon;

class CategoryController extends HelperController
{
    public function __construct()
    {
        $this->model = new StoreCategory();
        if (request('store_id')) {
            $this->rows = StoreCategory::where('store_id', request('store_id'));
        }
        $this->title = "Categories";
        $this->name = 'categories';
        $this->list = ['name' => 'الاسم'];

        $this->lang_inputs = [
            'name' => ['title' => 'الاسم'],
        ];
        $this->inputs = [
            'sort' => ['title' => 'الترتيب', 'type' => 'number'],
            'image' => ['title' => 'الصورة', 'type' => 'image'],
        ];
        $this->can_add = false;
        $this->queries = ['store_id' => request('store_id')];
    }


    
    // protected function store(Request $request)
    // {
    //     $data = request()->all();
    //     // dd($data);
    //     $store = auth()->user()->id == 1 ? Store::find(request('store_id')) : auth('stores')->user();
    //     $model = $store->categories()->create($data);
    //     return response()->json(['url' => route('admin.' . $this->name . '.index', $this->queries), 'message' => __("Info saved successfully")]);
    // }

    // protected function update(Request $request, $id)
    // {
    //     $data = request()->all();
    //     // dd($data);
    //     $store = auth()->user()->id == 1 ? Store::find(request('store_id')) : auth('stores')->user();
    //     $model = $store->categories()->findOrFail($id)->update($data);
    //     return response()->json(['url' => route('admin.' . $this->name . '.index', $this->queries), 'message' => __("Info saved successfully")]);
    // }
}
