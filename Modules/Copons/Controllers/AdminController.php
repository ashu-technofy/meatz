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
        $this->list = ['code' => 'الكود', 'using' => 'مرات الاستخدام', 'ended_at' => 'تاريخ الانتهاء'];

        $values = ['usual' => 'قيمة', 'precentage' => 'نسبة مئوية'];
        $this->inputs = [
            'code'  =>  ['title' => 'كود الكوبون'],
            'type'  =>  ['title' => 'النوع', 'type' => 'select', 'values' => $values,'id'=>'coupon_type'],
            'discount'  =>  ['title' => 'الخصم', 'type' => 'number'],
            'max_discount'  =>  ['title' => 'أقصى قيمة خصم', 'type' => 'number', 'empty' => 1],
            'ended_at'  =>  ['title' => 'تاريخ الانتهاء', 'type' => 'date']

        ];
        $this->switches['status'] = ['url' => route("admin.copons.status")];
    }

    public function status()
    {
        $item = Copon::findOrFail(request('id'));
        $status = $item->status ? 0 : 1;
        $item->update(['status' => $status]);
        return 'success';
    }
}
