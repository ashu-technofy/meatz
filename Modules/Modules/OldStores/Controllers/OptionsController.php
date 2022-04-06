<?php

namespace Modules\Stores\Controllers;

use Illuminate\Http\Request;
use Modules\Common\Controllers\HelperController;
use Modules\Stores\Models\Store;
use Modules\Stores\Models\StoreOption;

class OptionsController extends HelperController
{
    public function __construct()
    {
        $this->model = new StoreOption();
        if (request('option_id')) {
            $this->rows = StoreOption::where('option_id', request('option_id'));
        } elseif(request('store_id')) {
            $this->rows = StoreOption::where('store_id', request('store_id'));
        }
        
        $this->title = "Options";
        $this->name = 'options';
        $this->list = ['name' => 'الاسم'];

        $this->lang_inputs = [
            'name' => ['title' => 'الاسم'],
        ];
        $this->inputs = [
            'sort' => ['title' => 'الترتيب', 'type' => 'number'],
        ];
        $this->queries = ['store_id' => request('store_id')];

        if (request('option_id')) {
            $this->inputs['price'] = ['title' => 'السعر', 'type' => 'number'];
            $this->queries['option_id'] = request('option_id');
            $this->list['price'] = 'السعر';
        } else {
            $this->inputs['price'] = ['title' => 'السعر', 'type' => 'number'];
            $this->list['price'] = 'السعر';

            $this->inputs['required'] = ['title' => 'مطلوب', 'type' => 'select', 'values' => boolean_vals()];
            $this->inputs['multiple'] = ['title' => 'اختيار متعدد', 'type' => 'select', 'values' => boolean_vals()];
            $this->inputs['counted'] = ['title' => 'يمكن طلب اكثر من واحد', 'type' => 'select', 'values' => boolean_vals()];

            // $this->list['options_count'] = 'عدد الإضافات';
            // $this->links[] = [
            //     'title' => 'Options',
            //     'type' => 'success',
            //     'key' => 'option_id',
            //     'url' => 'admin.options.index',
            //     'icon' => 'fa-th-list',
            // ];
        }
    }

    protected function store(Request $request)
    {
        $data = request()->all();
        // dd($data);
        $store = auth()->user() && auth()->user()->id == 1 ? Store::find(request('store_id')) : auth('stores')->user();
        $model = StoreOption::create($data);
        return response()->json(['url' => route('admin.' . $this->name . '.index', $this->queries), 'message' => __("Info saved successfully")]);
    }

    protected function update(Request $request, $id)
    {
        $data = request()->all();
        // dd($data);
        $store = auth()->user()->id == 1 ? Store::find(request('store_id')) : auth('stores')->user();
        $model = StoreOption::findOrFail($id)->update($data);
        return response()->json(['url' => route('admin.' . $this->name . '.index', $this->queries), 'message' => __("Info saved successfully")]);
    }
}
