<?php

namespace Modules\Stores\Controllers;

use Illuminate\Http\Request;
use Modules\Areas\Models\Area;
use Modules\Common\Controllers\HelperController;
use Modules\Stores\Models\Store;
use Modules\Stores\Models\StoreCategory;
use Modules\Stores\Models\StoreSubcategory;
use Modules\Stores\Models\StorePeriod;

class AdminController extends HelperController
{
    public function __construct()
    {
        $this->model = new Store();

        $this->title = "Stores";
        $this->name = 'stores';
    }

    protected function list_builder()
    {
        if (request('type') == 'request') {
            $this->rows = Store::where('type', 'request');
            $this->list = [
                'name' => 'اسم المتجر',
                'mycategories' => 'الأقسام',
                'products_count' => 'عدد المنتجات',
                'my_orders_count' => 'عدد الطلبات',
            ];
        } else {
            $this->rows = Store::whereNull('type');
            $this->list = [
                'name' => 'الاسم',
                'mycategories' => 'الأقسام',
                'mysubcategories' => 'الأقسام',
                'products_count' => 'عدد المنتجات',
                'my_orders_count' => 'عدد الطلبات',
            ];
        }
        if (request('type') != 'request') {
            $this->links = [
                [
                    'title' => 'Orders',
                    'type' => 'warning',
                    'key' => 'store_id',
                    'url' => 'admin.orders.index',
                    'icon' => 'fa-th-list',
                ],
                [
                    'title' => 'Branches',
                    'type' => 'primary',
                    'key' => 'store_id',
                    'url' => 'admin.branches.index',
                    'icon' => 'fa-th-list',
                ],
                // [
                //     'title' => 'Areas',
                //     'type' => 'primary',
                //     'key' => 'store_id',
                //     'url' => 'admin.store_areas',
                //     'icon' => 'fa-map-marker',
                // ],
                [
                    'title' => 'Products',
                    'type' => 'warning',
                    'key' => 'store_id',
                    'url' => 'admin.products.index',
                    'icon' => 'fa-file',
                ],
            ];
            $this->can_delete = false;
            $this->can_add = false;
            if (auth()->user()) {
                $this->switches['status'] = ['url' => route("admin.stores.status")];
                $this->can_delete = true;
                $this->can_add = true;
            }
        }
        $this->links[] = [
            'title' => 'Periods',
            'type' => 'success',
            'key' => 'store_id',
            'url' => 'admin.store_periods',
            'icon' => 'fa-clock',
        ];
        // $this->has_map = 1;
    }

    protected function form_builder()
    {
        $this->lang_inputs = $this->inputs = [];
        if (auth()->check()) {
            $this->lang_inputs['name'] = ['title' => 'الاسم'];
        }
        $this->lang_inputs = array_merge($this->lang_inputs, [
            'about' => ['title' => 'نبذة مختصرة', 'type' => 'textarea'],
            'address' => ['title' => 'العنوان', 'type' => 'text' , 'empty' => 1],
        ]);
        if (auth()->check()) {
            $this->inputs['featured'] = ['title' => 'مميز', 'type' => 'select', 'values' => boolean_vals(), 'id' =>'featured'];
        }
        $cats = [];
        $subcat = [];
        $rows = StoreCategory::where('parent_id' ,0)->get();
        
        // echo "<pre>"; print_r($rows1); die;
        foreach ($rows as $row) {
            $cats[$row->id] = $row->name->{app()->getLocale()};
            $sub_rows = StoreSubcategory::where('category_id',$row->id)->get();
            foreach ($sub_rows as $sub_row) {
            $subcat[$sub_row->id] = $sub_row->subcategory_title;
            }
        }

        $this->inputs = array_merge($this->inputs, [
            'email' => ['title' => 'البريد الإلكترونى', 'type' => 'email', 'id' =>'email'],
            'mobile' => ['title' => 'رقم الجوال', 'empty' => 1, 'id' =>'mobile'],
            'password' => ['title' => 'كلمة المرور', 'type' => 'password', 'id' =>'password'],
            'supplier_code' => ['title' => 'MyFatoorah Supplier code', 'id' =>'supplier_code'],
            'categories[]' => ['title' => 'الأقسام', 'type' => 'select', 'multiple' => 'multiple', 'values' => $cats, 'id'=>'category'],
            'subcategories[]' => ['title' => 'الفئات الفرعية', 'type' => 'select', 'multiple' => 'multiple', 'values' => $subcat, 'id' =>'sub-cat'],
            'days_off[]' => ['title' => 'العطلات', 'type' => 'select', 'values' => days_off(), 'multiple' => 'multiple' , 'empty' => 1, 'id' =>'days_off'],
            // 'working_to' => ['title' => 'ساعات العمل إلى', 'type' => 'select', 'values' => hours()],
            'google_map' => ['title' => 'رابط جوجل ماب', 'type' => 'text' , 'empty' => 1, 'id' =>'google-map'],
            'logo' => ['title' => 'اللوجو', 'type' => 'image', 'id' =>'logo'],
            // 'banner' => ['title' => 'البنر', 'type' => 'image'],
        ]);

    }

    public function status()
    {
        $info = Store::findOrFail(request('id'));
        $status = $info->status ? 0 : 1;
        $info->update(['status' => $status]);
        return 'success';
    }

    protected function store(Request $request)
    {
        $data = request()->all();
        $data['status'] = 1;
        $model = $this->model->create($data);
        $model->categories()->sync($request->categories);



        $model->insertSubCategory($request->subcategories, $request->categories, $model->id);

        if ($images = request('images')) {
            foreach ($images as $image) {
                  $model->images()->create(['image' => $image]);
            }
        }
        return response()->json(['url' => route('admin.' . $this->name . '.index'), 'message' => __("Info saved successfully")]);
    }

    protected function update(Request $request, $id)
    {
        if (auth('stores')->user()) {
            $this->model = auth('stores')->user();
        } else {
            $this->model = $this->model->findOrFail($id);
        }
        $data = request()->all();
        $data['type'] = null;
        $data['store_id'] = auth('stores')->user()->id ?? null;
        if (!$data['password']) {
            unset($data['password']);
        }
        if(!isset($data['days_off'])){
            $data['days_off'] = [];
        }
        $this->model->update($data);
        $this->model->categories()->sync($request->categories);

        $this->model->insertSubCategory($request->subcategories, $request->categories, $id, 'update');
        if ($images = request('images')) {
            foreach ($images as $image) {
                $this->model->images()->create(['image' => $image]);
            }
        }
        return response()->json(['url' => route('admin.' . $this->name . '.index'), 'message' => __("Info saved successfully")]);
    }

    public function areas($store_id)
    {

        $store = Store::findOrFail($store_id);
        if (request()->isMethod('GET')) {
            $title = "Areas";
            $areas = Area::whereNotNull('city_id')->get();
            return view('Stores::admin.areas', get_defined_vars());
        }
        $areas = request('areas');
        $delivery = request('delivery');
        $store->areas()->detach();
        foreach ($areas as $i => $area) {
            if ($delivery[$i]) {
                $store->areas()->attach($area, ['delivery' => $delivery[$i]]);
            }
        }
        return response()->json([
            'url' => route('admin.store_areas', $store_id),
            'message' => __("Info saved successfully"),
        ]);
    }

    public function remove_area()
    {
        $store = Store::findOrFail(request('store_id'));
        $store->areas()->where('area_id', request('area_id'))->delete();
        return 'success';
    }

    public function days_off($store_id)
    {
        $store = Store::findOrFail($store_id);
        if (request()->isMethod('GET')) {
            $title = "Day off";
            return view('Stores::admin.days_off', get_defined_vars());
        }
        $dates = request('dates');
        foreach ($dates as $i => $date) {
            if ($date) {
                $store->dates_off()->firstOrCreate(['date' => $date]);
            }
        }
        return response()->json([
            'url' => route('admin.store_days_off', $store_id),
            'message' => __("Info saved successfully"),
        ]);
    }

    public function remove_day_off()
    {
        $store = Store::findOrFail(request('store_id'));
        $store->days_off()->find(request('day_id'))->delete();
        return 'success';
    }

    public function periods($store_id = null)
    {
        $store = Store::find($store_id) ?? new Store();
        $periods = $store->id ? $store->periods : StorePeriod::whereNull('store_id')->get() ?? [];
        if (request()->isMethod('GET')) {
            $title = "Periods";
            return view('Stores::admin.periods', get_defined_vars());
        }
        $data = request()->all();
        $froms = request('from');
        foreach ($froms as $i => $from) {
            if ($from || $data['to'][$i]) {
                StorePeriod::firstOrCreate([
                    'store_id' => $store->id,
                    'from' => $from,
                    'to' => $data['to'][$i],
                ]);
            }
            $i++;
        }
        return response()->json([
            'url' => route('admin.store_periods', $store_id),
            'message' => __("Info saved successfully"),
        ]);
    }

    public function remove_period()
    {
        $store = Store::find(request('store_id'));
        if ($store) {
            $store->periods()->find(request('day_id'))->delete();
        }else{
            StorePeriod::whereNull('store_id')->where('id' , request('day_id'))->delete();
        }
        return 'success';
    }
}
