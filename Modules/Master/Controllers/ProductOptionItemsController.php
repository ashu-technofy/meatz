<?php

namespace Modules\Master\Controllers;

use Modules\Common\Controllers\HelperController;
use Modules\Master\Models\ProductOptions;
use Modules\Master\Models\ProductOptionItems;
use Illuminate\Http\Request;

class ProductOptionItemsController extends HelperController
{
    public function __construct()
    {

        $this->model = new ProductOptionItems();
        $this->title = 'Product Options items';
        $this->name =  'option_items';
        $this->list = ['name' => 'الاسم','content' => 'المحتوى' , 'price' => 'السعر','number' => 'رقم'];
        

    }

    protected function list_builder()
    {
        if (request('product_option_id')) {
            $product_option_id = request('product_option_id');
            $this->rows =   ProductOptionItems::where(function($query) use ($product_option_id){
                                $query->where('product_option_id', $product_option_id);
                            });
        } else {
            if(auth('stores')->check()){
                $store_id = auth('stores')->user()->id;
                $this->rows = ProductOptionItems::where(function($query) use ($store_id){
                                $query->where('store_id', $store_id);
                              });
            }else{
               $this->rows = ProductOptionItems::query();
            }
        }

       
        if(!auth('stores')->check()){
          $this->switches['status'] = ['url' => route("admin.option_items.status")];
        }

    }

    protected function form_builder()
    {

      $this->lang_inputs = [
            'name' => ['title' => 'الاسم '],
            'content' => ['title' => 'الاسم '],
        ];

        $this->inputs = [
            'price' => ['title' => 'السعر'],
            'number' => ['title' => 'العدد المتاح', 'type' => 'number'],
        ];

        $this->has_images = true;
        
    }

    public function status()
    {
        $item = ProductOptionItems::findOrFail(request('id'));
        $status = $item->status ? 0 : 1;
        $item->update(['status' => $status]);
        return 'success';
    }

    protected function store(Request $request)
    {
        $data = request()->all();
        if (!auth()->check()) {
            $data['store_id'] = auth('stores')->user()->id ?? null;
        }
        // dd($data);
        $model = $this->model->create($data);
        if ($images = request('images')) {
            foreach ($images as $image) {
                $model->images()->create(['image' => $image]);
            }
        }
        foreach ($this->more_actions as $action) {
            $this->{$action}($model);
        }
        return response()->json(['url' => route('admin.' . $this->name . '.index', $this->queries), 'message' => __("Info saved successfully")]);
    }
  
    protected function update(Request $request, $id)
    {
        $data = request()->all();
        $queries = request()->query();

        if(auth('stores')->check()){
           $data['store_id'] = auth('stores')->user()->id;
        }
        if(auth('stores')->check()){
            $data['store_id'] = auth('stores')->user()->id;
        }
        if (request('product_id')) {
            $data['product_id'] = request('product_id');
            $queries['product_id'] = request('product_id');
        }
        if (request('product_option_id')) {
            $data['product_option_id'] = request('product_option_id');
            $queries['product_option_id'] = request('product_option_id');
        }
        
        $model = ProductOptionItems::findOrFail($id)->update($data);
        if ($images = request('images')) {
            foreach ($images as $image) {
                $model->images()->create(['image' => $image]);
            }
        }
        foreach ($this->more_actions as $action) {
            $this->{$action}($model);
        }
        return response()->json(['url' => route('admin.' . $this->name . '.index', $queries), 'message' => __("Info saved successfully")]);
    }


    
}
