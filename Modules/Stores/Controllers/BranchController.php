<?php

namespace Modules\Stores\Controllers;

use Illuminate\Http\Request;
use Modules\Common\Controllers\HelperController;
use Modules\Stores\Models\Store;
use Modules\Stores\Models\StoreCategory;
use Modules\Stores\Models\StoreOption;
use Modules\Stores\Models\StoreBranches;

class BranchController extends HelperController
{
    public function __construct()
    {
        $this->model = new StoreBranches();
        if (request('store_id')) {
            $this->rows = StoreBranches::where('store_id', request('store_id'));
        }  else {
            $this->rows = StoreBranches::query();
        }
        
        $this->title = "Branches";
        $this->name = 'branches';

        $this->list = [
            'name' => 'الاسم',
            'mobile' => 'الانواع',
            'address' => 'الانواع',
            'google_map' => 'السعر',
        ];

        $this->queries = ['store_id' => request('store_id')];
    }
    

    protected function list_builder()
    {
        if(auth('stores')->check()){
          $this->can_add = true;
        }else{
          $this->can_add = false;
        }
        $this->switches['status'] = ['url' => route("admin.branches.status")];

    }

    protected function form_builder()
    {
        $categories = [];
        $store_id = auth('stores')->user()->id ?? request('store_id');
        $this->lang_inputs['name'] = ['title' => 'الاسم'];
        $this->lang_inputs = array_merge($this->lang_inputs, [
            'address' => ['title' => 'العنوان', 'type' => 'text' , 'empty' => 1],
        ]);
       $this->inputs = [
            'mobile' => ['title' => 'رقم الجوال', 'empty' => 1, 'id' =>'mobile'],
            'google_map' => ['title' => 'رابط جوجل ماب', 'type' => 'text' , 'empty' => 1, 'id' =>'google-map'],
        ];
    }

   
    public function status()
    {
        $item = StoreBranches::findOrFail(request('id'));
        $status = $item->status ? 0 : 1;
        $item->update(['status' => $status]);
        return 'success';
    }

    

}
