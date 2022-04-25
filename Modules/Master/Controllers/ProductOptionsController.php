<?php

namespace Modules\Master\Controllers;

use Modules\Common\Controllers\HelperController;
use Modules\Master\Models\ProductOptions;
use Illuminate\Http\Request;

class ProductOptionsController extends HelperController
{
    public function __construct()
    {

        $this->model = new ProductOptions();
        $this->title = 'Product Options';
        $this->name =  'product_options';
        $this->list = ['name' => 'الاسم','min_selection' => 'اختيار دقيقة' , 'max_selection' => 'أقصى اختيار'];
        

    }

    protected function list_builder()
    {
        if (request('product_id')) {
            $product_id = request('product_id');
            $this->rows =   ProductOptions::where(function($query) use ($product_id){
                                $query->where('product_id', $product_id);
                            });
        } else {
            if(auth('stores')->check()){
                $store_id = auth('stores')->user()->id;
                $this->rows = ProductOptions::where(function($query) use ($store_id){
                                $query->where('store_id', $store_id);
                              });
            }else{
               $this->rows = ProductOptions::query();
            }
        }
         $this->links = [
                [
                    'title' => 'Option Group',
                    'type' => 'warning',
                    'key' => 'product_id',
                    'url' => 'admin.option_items.index',
                    'icon' => 'fa-th-list',
                ]
            ];
        if(!auth('stores')->check()){
          $this->switches['status'] = ['url' => route("admin.option_items.status")];
        }

    }

    protected function form_builder()
    {

        $this->lang_inputs = [
            'name' => ['title' => 'الاسم '],
        ];

        $this->inputs = [
            'min_selection'  =>  ['title' => 'اختيار دقيقة','type' => 'number'],
            'max_selection'  =>  ['title' => 'أقصى اختيار','type' => 'number'],
        ];
        
    }

    public function status()
    {
        $item = ProductOptions::findOrFail(request('id'));
        $status = $item->status ? 0 : 1;
        $item->update(['status' => $status]);
        return 'success';
    }


    protected function store(Request $request)
    {
        $data = request()->all();
        $queries = request()->query();
        // dd($data);
        if(auth('stores')->check()){
            $data['store_id'] = auth('stores')->user()->id;
        }
        if (request('product_id')) {
            $data['product_id'] = request('product_id');
            $queries['product_id'] = request('product_id');
        }
        $model = ProductOptions::create($data);
        return response()->json(['url' => route('admin.' . $this->name . '.index', $queries), 'message' => __("Info saved successfully")]);
    }

    protected function update(Request $request, $id)
    {
        $data = request()->all();
        $queries = request()->query();

        if(auth('stores')->check()){
           $data['store_id'] = auth('stores')->user()->id;
        }
        if (request('product_id')) {
            $data['product_id'] = request('product_id');
            $queries['product_id'] = request('product_id');
            
        }
       
        $model = ProductOptions::findOrFail($id)->update($data);
        return response()->json(['url' => route('admin.' . $this->name . '.index', $queries), 'message' => __("Info saved successfully")]);
    }


    
}
