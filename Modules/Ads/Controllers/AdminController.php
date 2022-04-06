<?php

namespace Modules\Ads\Controllers;

use Modules\Ads\Models\Ad;
use Modules\Common\Controllers\HelperController;

class AdminController extends HelperController
{
    public function __construct()
    {
        $this->model = new Ad();
        $this->rows = Ad::orderBy('sort' , 'asc');
        $this->title = "Ads";
        $this->name = 'ads';
        $this->list = ['title' => 'الاسم' , 'sort' => 'الترتيب'];

        $this->lang_inputs = [
            'title' => ['title' => 'عنوان الشريحة'],
        ];
        $places = [
            'home' => 'المتاجر',
            'splash' => 'الاعلان الرئيسى'
        ];
        $this->inputs = [
            'sort' => ['title' => 'الترتيب' , 'type' => 'number'],
            'type' => ['title' => 'مكان الإعلان' , 'type' => 'select' , 'values' => $places],
            'image' => ['title' => 'الصورة', 'type' => 'image']
        ];

        $this->switches['status'] = ['url' => route("admin.ads.status")];
    }

    public function status()
    {
        $info = Ad::findOrFail(request('id'));
        $status = $info->status ? 0 : 1;
        $info->update(['status' => $status]);
        return 'success';
    }
}
