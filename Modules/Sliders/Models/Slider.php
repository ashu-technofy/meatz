<?php

namespace Modules\Sliders\Models;

use Modules\Common\Models\HelperModel;
use Modules\Stores\Models\Store;
use Modules\Stores\Models\StoreProduct;

class Slider extends HelperModel
{
    protected $table = 'sliders';

    protected $fillable = [
        'sort',
        'title',
        'model_id',
        'model',
        'image',
        'status',
    ];
    protected $hidden = ['created_at', 'updated_at'];
    protected $casts = ['title' => 'array'];

    public function setModelAttribute(){
        $model = $this->attributes['model'] = request('model');
        switch ($model) {
            case 'box':
                $this->attributes['model_id'] = request('box_id');
                break;
            case 'product':
                $this->attributes['model_id'] = request('product_id');
                break;
            case 'store':
                $this->attributes['model_id'] = request('store_id');
                break;
        }
    }

    public function getMymodelAttribute(){
        $model = $this->model;
        if(in_array($model , ['product' , 'box'])){
            return StoreProduct::find($this->model_id);
        }elseif($model == 'store'){
            return Store::find($this->model_id);
        }
        return new StoreProduct;
    }

    public function getForAttribute(){
        return $this->mymodel->name ?? 'عرض فقط';
    }
}
