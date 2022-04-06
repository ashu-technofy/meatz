<?php

namespace Modules\Stores\Controllers;

use Illuminate\Http\Request;
use Modules\Common\Controllers\HelperController;
use Modules\Stores\Models\Store;
use Modules\Stores\Models\StoreCategory;
use Modules\Stores\Models\StoreOption;
use Modules\Stores\Models\StoreProduct;

class ProductController extends HelperController
{
    public function __construct()
    {
        $this->model = new StoreProduct();
        if (request('store_id')) {
            $this->rows = StoreProduct::where('store_id', request('store_id'));
        } elseif (request('type') == 'special_box') {
            $this->rows = StoreProduct::where('type', 'special_box');
        } else {
            $this->rows = StoreProduct::whereNull('store_id');
        }
        switch (request('type')) {
            case 'box':
                $this->title = "Boxes";
                break;
            case 'special_box':
                $this->title = "Stores offers";
                break;
            default:
                $this->title = "Products";
                break;
        }
        $this->name = 'products';

        $this->list = [
            'all_name' => 'الاسم',
            'mycategories' => 'الانواع',
            'price' => 'السعر',
            'store_name' => 'المتجر'
        ];

        $this->queries = ['store_id' => request('store_id')];
        $this->more_actions = ['product_options'];

        $this->switches['status'] = ['url' => route("admin.products.status")];
        $type = request('type');
        if (in_array($type, ['box', 'special_box'])) {
            $this->list['original_price'] = 'السعر قبل الخصم';
            $this->list['persons'] = 'عدد الأشخاص';
            if($type == 'special_box'){
                $this->queries = ['type' => 'special_box'];
            }
        }
    }

    protected function form_builder()
    {
        $categories = [];
        $store_id = auth('stores')->user()->id ?? request('store_id');
        $rows = StoreCategory::get();
        foreach ($rows as $row) {
            $categories[$row->id] = $row->name->{app()->getLocale()};
        }

        $this->lang_inputs = [
            'name' => ['title' => 'الاسم'],
            'content' => ['title' => 'وصف', 'type' => 'textarea'],
        ];
        $this->inputs = [];
        $type = request('type');
        if (in_array($type, ['box', 'special_box'])) {
            $this->inputs['persons'] = ['title' => 'عدد الأشخاص', 'type' => 'number'];
            $this->images_text = "1000px*460px";
            // dd(get_object_vars($this));
        }
        $rows = Store::get();
        foreach ($rows as $row) {
            $stores[$row->id] = $row->name->{app()->getLocale()};
        }
        if ($type == 'special_box') {
            $this->inputs['store_id'] = ['title' => '', 'type' => 'select', 'values' => $stores];
        }

        $this->inputs = array_merge($this->inputs, [
            'categories[]' => ['title' => 'النوع', 'type' => 'select', 'multiple' => 'multiple', 'values' => $categories],
            'price' => ['title' => 'السعر'],
            'price_before' => ['title' => 'السعر قبل الخصم ان وجد', 'empty' => 1],
            'num' => ['title' => 'العدد المتاح', 'type' => 'number'],
        ]);

        // $this->has_map = 1;
        $this->options = StoreOption::get();
        if ($type != 'special_box') {
            $this->includes[] = "Stores::admin.products.options";
        }

        $this->has_images = true;
    }

    public function remove_option()
    {
        \DB::table('store_product_options')->where('option_id', request('id'))->delete();
        return 'success';
    }

    public function product_options($product)
    {
        $cats = request('categories', []);
        $product->categories()->sync($cats);
        if (isset($cats[0])) {
            $product->update(['category_id' => $cats[0]]);
        }

        $options = request('option_id');
        $min = request('min');
        $max = request('max');
        if (is_array($options)) {
            foreach ($options as $i => $option_id) {
                if ($option_id) {
                    // $row = ['min' => $min[$i], 'max' => $max[$i]];
                    $row = ['min' => 1, 'max' => 1];
                    if ($option = $product->options()->where('store_product_options.option_id', $option_id)->first()) {
                        $option->update($row);
                    } else {
                        $product->options()->attach($option_id);
                        $product->options()->where('store_product_options.option_id', $option_id)->update($row);
                    }
                }
            }
        }
    }

    public function status()
    {
        $item = StoreProduct::findOrFail(request('id'));
        $status = $item->status ? 0 : 1;
        $item->update(['status' => $status]);
        return 'success';
    }

}
