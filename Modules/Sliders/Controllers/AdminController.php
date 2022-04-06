<?php

namespace Modules\Sliders\Controllers;

use Modules\Common\Controllers\HelperController;
use Modules\Sliders\Models\Slider;
use Modules\Stores\Models\Store;
use Modules\Stores\Models\StoreProduct;

class AdminController extends HelperController
{
    public function __construct()
    {
        $this->model = new Slider();
        $this->title = "Sliders";
        $this->name = 'sliders';
        $this->list = ['title' => 'الاسم' , 'for' => 'تشير إلى'];
    }

    public function form_builder(){
        
        $this->lang_inputs = [
            'title' => ['title' => 'عنوان الشريحة'],
        ];
        $stores = $boxes = $products = [];
        $rows = Store::get();
        foreach ($rows as $row) {
            $stores[$row->id] = $row->name->{app()->getLocale()} ?? '';
        }
        $rows = StoreProduct::type('box')->whereNull('store_id')->get();
        foreach ($rows as $row) {
            $boxes[$row->id] = $row->name->{app()->getLocale()} ?? '';
        }
        $rows = StoreProduct::type('product')->get();
        foreach ($rows as $row) {
            $products[$row->id] = $row->name->{app()->getLocale()} ?? '';
        }
        $types = [
            'none' => 'عرض فقط',
            'store' => 'متجر',
            'box' => 'صندوق',
            'product' => 'منتج'
        ];
        $this->inputs = [
            'sort' => ['title' => 'الترتيب'],
            'model' => ['title' => 'نوع السليدر' , 'type' => 'select' , 'values' => $types],
            'store_id' => ['title' => 'المتجر', 'type' => 'select', 'values' => $stores],
            'box_id' => ['title' => 'الصندوق', 'type' => 'select', 'values' => $boxes],
            'product_id' => ['title' => 'المنتج', 'type' => 'select', 'values' => $products],
            'image' => ['title' => 'الصورة', 'type' => 'image'],
        ];

        $this->includes[] = "Sliders::admin.script";

        $this->switches['status'] = ['url' => route("admin.sliders.status")];
    }

    public function status()
    {
        $info = Slider::findOrFail(request('id'));
        $status = $info->status ? 0 : 1;
        $info->update(['status' => $status]);
        return 'success';
    }
}
