<?php

namespace Modules\Areas\Controllers;

use Modules\Areas\Models\City;
use Modules\Common\Controllers\HelperController;

class CityController extends HelperController
{
    public function __construct()
    {
        $this->model = new City();
        $this->title = __('Cities');
        $this->name =  'cities';
        $this->list = ['name' => 'الاسم'];

        $this->lang_inputs = [
            'name' => ['title' =>  'الاسم ']
        ];
    }
}
