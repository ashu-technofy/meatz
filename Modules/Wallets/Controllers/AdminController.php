<?php

namespace Modules\Wallets\Controllers;

use Modules\Common\Controllers\HelperController;
use Modules\Wallets\Models\Wallet;

class AdminController extends HelperController
{
    public function __construct()
    {
        $this->model = new Wallet();
        $this->title = "Wallets";
        $this->name = 'wallets';
        $this->list = ['price' => 'السعر' , 'sort' => 'الترتيب'];
    }

    public function form_builder(){
        
        $this->inputs = [
            'sort' => ['type' => 'number' , 'title' => 'الترتيب'],
            'price' => ['type' => 'number' , 'title' => 'السعر'],
        ];
    }
}
