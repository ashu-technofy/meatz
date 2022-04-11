<?php

namespace Modules\Copons\Controllers;

use Modules\Common\Controllers\HelperController;
use Modules\Copons\Models\Copon;
use Illuminate\Http\Request;


class CoponController extends HelperController
{
    public function __construct()
    {


        $this->model = new Copon();
        $this->title = 'Coupon';
        $this->name =  'copons';
        $this->list = ['code' => 'الكود', 'using' => 'مرات الاستخدام', 'ended_at' => 'تاريخ الانتهاء'];

        $values = ['usual' => ['ar' => 'قيمة','en' => 'usual'],'precentage' => ['ar' => 'نسبة مئوية','en' => 'precentage']];

    /*    $this->inputs = [
                'code'  =>  ['title' => 'كود الكوبون'],
                'type'  =>  ['title' => 'النوع', 'type' => 'select', 'values' => $values,'id'=>'coupon_type'],
                'discount'  =>  ['title' => 'الخصم', 'type' => 'number'],
                'max_discount'  =>  ['title' => 'أقصى قيمة خصم', 'type' => 'number', 'empty' => 1],
                'ended_at'  =>  ['title' => 'تاريخ الانتهاء', 'type' => 'date']
        ];*/
        
        $this->switches['status'] = ['url' => route("admin.copons.status")];
    }
    
    protected function form_builder()
    {

        if(app()->getLocale() == 'ar'){
            $values = ['usual'=> 'قيمة','precentage'=>'نسبة مئوية'];
        }else{
            $values = ['usual'=> 'usual','precentage'=>'precentage'];
        }
        $this->inputs = [
                'code'  =>  ['title' => 'كود الكوبون'],
                'type'  =>  ['title' => 'النوع', 'type' => 'select', 'values' => $values,'id'=>'coupon_type'],
                'discount'  =>  ['title' => 'الخصم', 'type' => 'number'],
                'max_discount'  =>  ['title' => 'أقصى قيمة خصم', 'type' => 'number', 'empty' => 1],
                'ended_at'  =>  ['title' => 'تاريخ الانتهاء', 'type' => 'date']
        ];

        $this->can_store_add = true;
        $this->can_store_edit = true;
        
    }

    public function status()
    {
        $item = Copon::findOrFail(request('id'));
        $status = $item->status ? 0 : 1;
        $item->update(['status' => $status]);
        return 'success';
    }

     protected function store(Request $request){
    
        $data = request()->all();
        $data['status'] = 1;
        $auth_store_user = auth('stores')->user()->id;
        $model = $this->model->create($data);
        $model->insertStoreMapping($model->id, $auth_store_user);
        return response()->json(['url' => route($this->name . '.index'), 'message' => __("Info saved successfully")]);
        
    }

    protected function update(Request $request, $id)
    {
       
        $this->model = $this->model->findOrFail($id);
        $data = request()->all();
        $auth_store_user = auth('stores')->user()->id;
        $this->model->update($data);
        $this->model->insertStoreMapping($id, $auth_store_user);
        return response()->json(['url' => route($this->name . '.index'), 'message' => __("Info saved successfully")]);
    }


    public function destroy($id)
    {
        $this->model = $this->model->findOrFail($id);
        $auth_store_user = auth('stores')->user()->id;
        $this->model->findOrFail($id)->delete();
        $this->model->deleteStoreMapping($id, $auth_store_user);
        return response()->json(['url' => route( $this->name . '.index', $this->queries), 'message' => __("Deleted successfully")]);
    }

}
