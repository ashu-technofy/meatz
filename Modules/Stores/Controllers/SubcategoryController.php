<?php

namespace Modules\Stores\Controllers;

use Illuminate\Http\Request;
use Modules\Common\Controllers\HelperController;
use Modules\Stores\Models\Store;
use Modules\Stores\Models\StoreCategory;
use Modules\Stores\Models\StoreSubcategory;
use DB;
use Carbon\Carbon;

class SubcategoryController extends HelperController
{
    public function __construct()
    {

        $current_locale = app()->getLocale();
       /* $this->middleware(function ($request, $next){
            $this->current_locale = session('current_locale');
            return $next($request);
         });*/

        $this->model = new StoreSubcategory();

        if (request('category_id')) {
            $this->rows = StoreSubcategory::where('category_id', request('category_id'));
        }

        $this->title = "Subcategories";
        $this->name = 'subcategories';
        $this->list = ['category_title' => 'اسم التصنيف','subcategory_title' => 'اسم الفئة الفرعية'];
        $rows = StoreCategory::get();
        $sub_categories = [];
     
        foreach ($rows as $row) {
            $sub_categories[$row->id] = $row->name;
        }
        $this->lang_inputs = [
            'subcategory_name' => ['title' => 'اسم الفئة الفرعية'],
        ];
        $this->inputs = [
            'category_id' => ['title' => 'اسم التصنيف', 'type' => 'select','values'=> $sub_categories],
            'sort' => ['title' => 'الترتيب', 'type' => 'number'],
            'subcategory_image' => ['title' => 'الصورة', 'type' => 'image'],
        ];
        $this->can_add = true;
        $this->queries = ['category_id' => request('category_id')];
    }

    public function getSubcategories(Request $request,$category_id){

        $rows = StoreSubcategory::whereIn('category_id',explode(',',$category_id))->get();

        $options = "";
        foreach($rows as $rows_key => $rows_value){

            $options .= "<option value='".$rows_value->id."'>".$rows_value->subcategory_title."</option>";   
        }
        return $options;

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
