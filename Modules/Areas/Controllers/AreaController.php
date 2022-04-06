<?php

namespace Modules\Areas\Controllers;

use Modules\Areas\Models\Area;
use Modules\Common\Controllers\HelperController;

class AreaController extends HelperController
{
    public function __construct()
    {
        $this->model = new Area;
        if (!request('city_id')) {
            $this->rows = Area::whereNull('city_id');
        }
        $this->title = 'Area';
        $this->name = 'areas';
        $this->list = ['name' => 'الاسم', 'area_name' => 'المنطقة'];

        $this->lang_inputs = [
            'name' => ['title' => 'الاسم '],
        ];
        $cities = [];
        $values = Area::get(['name', 'id']);
        foreach ($values as $city) {
            $cities[$city->id] = $city->name->ar; 
        }

        $this->inputs = [
            'city_id' => ['type' => 'select', 'title' => 'المنطقة', 'values' => $cities],
            'delivery' => ['title' => 'سعر التوصيل' , 'empty' => 1],
            'delivery_express' => ['title' => 'سعر التوصيل السريع' , 'empty' => 1],
        ];

        $this->links[] = [
            'title' => 'Cities',
            'type' => 'success',
            'key' => 'city_id',
            'url' => 'admin.areas.index',
            'icon' => 'fa-map-marker',
        ];
    }
}
