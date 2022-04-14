<?php

namespace Modules\Copons\Controllers;

use Modules\Common\Controllers\HelperController;
use Modules\Copons\Models\Copon;

class AdminController extends HelperController
{
    public function __construct()
    {


        $this->model = new Copon();
        $this->title = 'Coupon';
        $this->name =  'copons';
        $this->list = ['code' => 'الكود', 'using' => 'مرات الاستخدام','created_by'  => 'انشأ من قبل', 'ended_at' => 'تاريخ الانتهاء'];

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
        
    }

    public function status()
    {
        $item = Copon::findOrFail(request('id'));
        $status = $item->status ? 0 : 1;
        $item->update(['status' => $status]);
        return 'success';
    }


    
}
