<?php

namespace Modules\Master\Controllers;

use Modules\Common\Controllers\HelperController;
use Modules\Master\Models\ProductOptions;

class AdminController extends HelperController
{
    public function __construct()
    {

        print_r('die');
        $this->model = new ProductOptions();
        $this->title = 'Product Options';
        $this->name =  'Product_Options';
        $this->list = ['name' => 'الاسم'];
        $this->switches['status'] = ['url' => route("admin.product_options.status")];

    }
    
    protected function form_builder()
    {

        $this->inputs = [
            'name'  =>  ['title' => 'الاسم'],
        ];
        
    }

    public function status()
    {
        $item = ProductOptions::findOrFail(request('id'));
        $status = $item->status ? 0 : 1;
        $item->update(['status' => $status]);
        return 'success';
    }


    
}
