<?php

namespace Modules\Common\Controllers;

use Modules\Common\Models\Section;

class SectionsController extends HelperController
{

    public function __construct()
    {
        $this->model = new Section();
        $this->title = "Home Content";
        $this->name = 'home_sections';
        $this->list = ['type' => 'النوع', 'title' => 'العنوان'];
        $this->lang_inputs = [
            'title' => ['title' => 'العنوان'],
            'content' => ['title' => 'الحتوي', 'type' => 'textarea'],
        ];
        $types = [
            'about' => 'من نحن',
            'features' => 'مميزات'
        ];
        $this->inputs = [
            'type' => ['type' => 'select' , 'title' => 'النوع' , 'values' => $types],
            'sort' => ['title' => 'الترتيب'],
            'image' => ['title' => 'الصورة', 'type' => 'image'],
        ];
        $this->can_delete = false;
    }
}
