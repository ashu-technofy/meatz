<?php

namespace Modules\Common\Controllers;

use App\Http\Controllers\Controller;
use Modules\Common\Models\Notification;
use Modules\Common\Models\Setting;
use Modules\Common\Models\Visitor;
use Modules\Contactus\Models\Contactus;
use Modules\Orders\Models\Order;
use Modules\Pages\Models\Page;
use Modules\Stores\Models\Store;
use Modules\Stores\Models\StoreProduct;
use Modules\User\Models\User;

class AdminController extends Controller
{
    public function home()
    {
        if (auth('stores')->check()) {
            return $this->store_home();
        }

        $roles = auth()->user()->role->roles;
        if (!in_array('Common', $roles)) {
            return redirect()->route('admin.' . strtolower($roles[0]) . '.index');
        }
        $title = __("Home page");
        $boxes = [
            [
                'title' => __("Orders"),
                'url' => route('admin.orders.index'),
                'count' => Order::count(),
                'icon' => 'fa-th-large',
                'type' => 'blue',
            ],
            [
                'title' => __("Express Orders"),
                'url' => route('admin.orders.index', ['delivery_type' => 'express']),
                'count' => Order::where('delivery_type', 'express')->count(),
                'icon' => 'fa-th-large',

                'type' => 'red',
            ],
            [
                'title' => __("Normal Orders"),
                'url' => route('admin.orders.index', ['delivery_type' => 'usual']),
                'count' => Order::where('delivery_type', 'usual')->count(),
                'icon' => 'fa-th-large',
                'type' => 'orange',
            ],
            [
                'title' => __("Total"),
                'url' => route('admin.orders.index'),
                'count' => Order::where('status', '!=', 'Canceled')->sum('total') . ' ' . __('KD'),
                'icon' => 'fa-money',
                'type' => 'green',
            ],
            [
                'title' => __("App Users"),
                'url' => route('admin.users.index'),
                'count' => User::count(),
                'icon' => 'fa-users',
                'type' => 'orange',
            ],
            [
                'title' => __("Vendors"),
                'url' => route('admin.stores.index'),
                'count' => Store::whereNull('type')->count(),
                'icon' => 'fa-building',
                'type' => 'purple',
            ],
            // [
            //     'title' => __("Join Requests"),
            //     'url' => route('admin.stores.index' , ['type' => 'request']),
            //     'count' => Store::whereNotNull('type')->count(),
            //     'icon' => 'fa-hand-paper-o',
            //     'type' => 'red',
            // ],
            [
                'title' => __("Products"),
                'url' => route('admin.products.index'),
                'count' => StoreProduct::count(),
                'icon' => 'fa-th-large',
                'type' => 'blue',
            ],
            [
                'title' => __("Pages"),
                'url' => route('admin.pages.index'),
                'count' => Page::count(),
                'icon' => 'fa-file',
                'type' => 'green',
            ],
            // [
            //     'title' => __("Areas"),
            //     'url' => route('admin.areas.index'),
            //     'count' => Area::count(),
            //     'icon' => 'fa-map-marker',
            //     'type' => 'red',
            // ],
        ];

        $orders_count = Order::count();
        $orders = Order::latest()->take(6)->get();
        $latest_orders_count = Order::where('created_at', '>', date('Y-m-d', strtotime('-1 month')))->count();

        $stores = Store::latest()->take(6)->get();
        $stores_count = Store::count();
        $latest_stores_count = Store::where('created_at', '>', date('Y-m-d', strtotime('-1 month')))->count();

        $products = StoreProduct::latest()->take(6)->get();
        $products_count = StoreProduct::count();
        $latest_products_count = StoreProduct::where('created_at', '>', date('Y-m-d', strtotime('-1 month')))->count();

        $v_count = Visitor::count();
        $visits_count = Visitor::where('created_at', '>', date('Y-m-d', strtotime('-1 month')))->count();
        $counters = [
            [
                'title' => __('Orders'),
                'count' => $latest_orders_count,
                'width' => $latest_orders_count ? ($latest_orders_count / $orders_count) * 100 : 0,
                'icon' => 'fa-th-list',
                'color' => 'blue',
            ],
            [
                'title' => __('Stores'),
                'count' => $latest_stores_count,
                'width' => $latest_stores_count ? ($latest_stores_count / $stores_count) * 100 : 0,
                'icon' => 'fa-th-large',
                'color' => 'green',
            ],
            [
                'title' => __('Products'),
                'count' => $latest_products_count,
                'width' => $latest_products_count ? ($latest_products_count / $products_count) * 100 : 0,
                'icon' => 'fa-users',
                'color' => 'red',
            ],
            [
                'title' => __('Visitors'),
                'count' => $visits_count,
                'width' => $v_count ? ($visits_count / $v_count) * 100 : 0,
                'icon' => 'fa-user',
                'color' => 'purple',
            ],
        ];

        return view('Common::admin.home', get_defined_vars());
    }

    public function store_home()
    {
        $store = auth('stores')->user();
        $title = __("Home page");
        $boxes = [
            [
                'title' => __("Orders"),
                'url' => route('admin.orders.index' , ['store_id' => $store->id]),
                'count' => Order::forStore()->count(),
                'icon' => 'fa-th-large',
                'type' => 'blue',
            ],
            [
                'title' => __("Total"),
                'url' => route('admin.orders.index'),
                'count' => Order::forStore()->where('status', '!=', 'Canceled')->sum('total') . ' ' . __('KD'),
                'icon' => 'fa-money',
                'type' => 'green',
            ],
            [
                'title' => __("Products"),
                'url' => route('admin.products.index' , ['store_id' => $store->id , 'type' => 'product']),
                'count' => StoreProduct::forStore()->where('type' , 'product')->count(),
                'icon' => 'fa-th-large',
                'type' => 'blue',
            ],
            [
                'title' => __("Stores offers"),
                'url' => route('admin.products.index' , ['store_id' => $store->id , 'type' => 'special_box']),
                'count' => StoreProduct::forStore()->where('type' , 'special_box')->count(),
                'icon' => 'fas fa-th-large',
                'type' => 'purple',
            ],
            // [
            //     'title' => __("Areas"),
            //     'url' => route('admin.store_areas', ['store_id' => $store->id]),
            //     'count' => $store->areas()->count(),
            //     'icon' => 'fa-map-marker',
            //     'type' => 'red',
            // ],
            // [
            //     'title' => __("Categories"),
            //     'url' => route('admin.categories.index', ['store_id' => $store->id]),
            //     'count' => $store->categories()->count(),
            //     'icon' => 'fa-th-large',
            //     'type' => 'red',
            // ],
            [
                'title' => __("Options"),
                'url' => route('admin.options.index', ['store_id' => $store->id]),
                'count' => $store->options()->count(),
                'icon' => 'fa-th-list',
                'type' => 'red',
            ],
            [
                'title' => __("Days off"),
                'url' => route('admin.store_days_off', ['store_id' => $store->id]),
                'count' => $store->dates_off()->count(),
                'icon' => 'fa-clock',
                'type' => 'red',
            ],
        ];

        $orders_count = Order::forStore()->count();
        $orders = Order::forStore()->latest()->take(6)->get();
        $latest_orders_count = Order::forStore()->where('created_at', '>', date('Y-m-d', strtotime('-1 month')))->count();

        $products = StoreProduct::forStore()->latest()->take(6)->get();
        $products_count = StoreProduct::forStore()->count();
        $latest_products_count = StoreProduct::forStore()->where('created_at', '>', date('Y-m-d', strtotime('-1 month')))->count();

        return view('Common::admin.home', get_defined_vars());
    }

    public function monthly_orders()
    {
        $months = range(1, 12);
        $monthly_orders = [];
        foreach ($months as $row) {
            $monthly_orders[] = [
                "label" => get_month($row + 1),
                "title" => get_month($row + 1),
                "fillColor" => "rgba(" . rand(1, 250) . "," . rand(1, 250) . "," . rand(1, 250) . ",0.1)",
                "strokeColor" => "rgba(" . rand(1, 250) . "," . rand(1, 250) . "," . rand(1, 250) . ",0.1)",
                "pointColor" => "#1" . rand(1, 9) . rand(1, 9) . "cbe",
                "pointStrokeColor" => "rgba(" . rand(1, 250) . "," . rand(1, 250) . "," . rand(1, 250) . ",0.1)",
                "pointHighlightFill" => "#1" . rand(1, 9) . rand(1, 9) . "22b",
                "pointHighlightStroke" => "rgba(" . rand(1, 250) . "," . rand(1, 250) . "," . rand(1, 250) . ",0.1)",
                "data" => Order::whereMonth('created_at', $row)->whereYear('created_at', date('Y'))->count(),
            ];
        }
        return response()->json($monthly_orders);
    }

    public function load()
    {
        $title = "";
        return view('Common::admin.load', get_defined_vars());
    }

    public function settings()
    {
        if (request()->isMethod('post')) {
            $data = request()->except('_token');
            foreach ($data as $key => $value) {
                Setting::firstOrCreate(['key' => $key, 'type' => 'settings'])->update(['value' => $value]);
            }
            return response()->json(['url' => route('admin.settings.app'), 'message' => __("Info saved successfully")]);
        }
        $lang_inputs = [
            'title' => ['title' => 'عنوان التطبيق', 'setting' => 1],
            'logo' => ['title' => 'اللوجو', 'type' => 'image', 'setting' => 1],
            // 'footer_logo' => ['title' => 'لوجو الفوتر', 'type' => 'image', 'setting' => 1],
            'favicon' => ['title' => 'ايقونة المتصفح', 'type' => 'image', 'setting' => 1],
            // 'working_hours' => ['title' => 'ساعات العمل', 'setting' => 1],
            'keywords' => ['title' => 'الكلمات الدلالية', 'setting' => 1],
            'description' => ['title' => 'وصف مختصر', 'type' => 'textarea', 'setting' => 1],
        ];
        $action = route('admin.settings.app');
        $method = 'post';
        $title = __("Settings");
        $model = new Setting;
        return view('Common::admin.form', get_defined_vars());
    }

    public function store()
    {
        if (request()->isMethod('post')) {
            $data = request()->except('_token');
            foreach ($data as $key => $value) {
                Setting::firstOrCreate(['key' => $key, 'type' => 'settings'])->update(['value' => $value]);
            }
            return response()->json(['url' => route('admin.settings.store'), 'message' => __("Info saved successfully")]);
        }
        $lang_inputs = [
            'express_delivery_message' => ['title' => 'رسالة التوصيل السريع', 'setting' => 1 , 'required' => 1 ],
        ];
        $inputs = [
            'supplier_code' => ['title' => 'كود خدمة التوصيل لميتز', 'setting' => 1 , 'required' => 1],
        ];
        $action = route('admin.settings.store');
        $method = 'post';
        $title = __("Settings");
        $model = new Setting;
        return view('Common::admin.form', get_defined_vars());
    }

    public function app_links()
    {
        if (request()->isMethod('post')) {
            $data = request()->except('_token');
            foreach ($data as $key => $value) {
                Setting::firstOrCreate(['key' => $key, 'type' => 'settings'])->update(['value' => $value]);
            }
            return response()->json(['url' => route('admin.settings.app_links'), 'message' => __("Info saved successfully")]);
        }
        $inputs = [
            'android' => ['title' => 'رابط الاندرويد', 'setting' => 1],
            'ios' => ['title' => 'رابط ال IOS', 'setting' => 1],
        ];
        $action = route('admin.settings.app_links');
        $method = 'post';
        $title = __("App Links");
        $model = new Setting;
        return view('Common::admin.form', get_defined_vars());
    }

    public function messages()
    {
        if (request()->isMethod('post')) {
            $data = request()->except('_token');
            foreach ($data as $key => $value) {
                Setting::firstOrCreate(['key' => $key, 'type' => 'messages'])->update(['value' => $value]);
            }
            return response()->json(['url' => route('admin.settings.messages'), 'message' => __("Info saved successfully")]);
        }
        $groups = [
            __("Email") => [
                'mail_mailer' => ['title' => 'نوع المرسل', 'setting' => 1],
                'mail_host' => ['title' => 'Host', 'setting' => 1],
                'mail_port' => ['title' => 'Port', 'setting' => 1],
                'mail_username' => ['title' => 'اسم المستخدم', 'setting' => 1],
                'mail_password' => ['title' => 'كلمة السر', 'setting' => 1],
                'mail_encryption' => ['title' => 'التشفير', 'setting' => 1],
                'mail_from_address' => ['title' => 'بريد المرسل', 'setting' => 1],
                'mail_from_name' => ['title' => 'اسم المرسل', 'setting' => 1],
            ],
            __("SMS") => [
                'sms_username' => ['title' => 'اسم المستخدم', 'setting' => 1],
                'sms_password' => ['title' => 'كلمة السر', 'setting' => 1],
                'sms_sender' => ['title' => 'اسم المرسل', 'setting' => 1],
            ],
        ];
        $action = route('admin.settings.messages');
        $title = __("Message settings");
        $model = new Setting;
        $method = 'post';
        return view('Common::admin.form', get_defined_vars());
    }

    public function contacts()
    {
        if (request()->isMethod('get')) {
            $action = route('admin.settings.contacts');
            $method = 'post';
            $title = __('Contacts');
            $model = new Setting;
            $contacts = Setting::whereType('contacts')->get();
            // dd($contacts);
            return view('Common::admin.settings.contacts', get_defined_vars());
        }
        $keys = array_filter(request('key'));
        $values = request('value');
        $images = request('image');
        foreach ($keys as $i => $key) {
            $setting = Setting::firstOrCreate(['key' => $key, 'type' => 'contacts']);
            $values && isset($values[$i]) && $values[$i] ? $setting->value = $values[$i] : '';
            $images && isset($images[$i]) && $images[$i] ? $setting->image = $images[$i] : '';
            $setting->save();
        }
        return response()->json(['url' => route('admin.settings.contacts'), 'message' => __('Info saved successfully')]);
    }
    public function remove_contact()
    {
        Setting::findOrFail(request('id'))->delete();
        return 'success';
    }

    public function remove_img()
    {
        \DB::table('images')->where('id', request('id'))->delete();
        return 'success';
    }

    public function notifications($id = null)
    {
        if (request()->isMethod('get')) {
            if ($id) {
                $notf = Notification::findOrFail($id);
                $row = $notf->toArray();
                $row['text'] = (array) json_decode($notf->getRawOriginal('text'));
                $row['title'] = (array) json_decode($notf->getRawOriginal('title'));
                unset($row['id'], $row['created_at'], $row['updated_at']);
                Notification::create($row);
                // return redirect()->route('admin.notifications');
            } else {
                $notifications = Notification::global()->latest()->paginate(20);
                // $products = Product::get(['id', 'name']);
                // $services = Service::get(['id', 'name']);
                $title = "Notifications";
                return view('Common::admin.notifications', get_defined_vars());
            }
        }
        $data = $id ? $row : request()->all();
        $data = array_filter($data);
        $data['type'] = 'global';
        // dd($data);
        if (!$id) {
            Notification::create($data);
        }
        if (!isset($data['title'])) {
            $data['title'] = [
                'ar' => 'ميتز',
                'en' => 'Meatz',
            ];
        }
        if ($data['for'] == 'all') {
            send_fcm(null, 'android', $data['text']['ar'], null, null, null, 'Android_ar', $data['title']['ar']);
            send_fcm(null, 'ios', $data['text']['ar'], null, null, null, 'IOS_ar', $data['title']['ar']);
            send_fcm(null, 'android', $data['text']['en'], null, null, null, 'Android_en', $data['title']['en']);
            send_fcm(null, 'ios', $data['text']['en'], null, null, null, 'IOS_en', $data['title']['en']);
            // dd('dssd');
        } elseif ($data['for'] == 'android') {
            send_fcm(null, 'android', $data['text']['ar'], null, null, null, 'Android_ar', $data['title']['ar']);
            send_fcm(null, 'android', $data['text']['en'], null, null, null, 'Android_en', $data['title']['en']);
        } else {
            send_fcm(null, 'ios', $data['text']['ar'], null, null, null, 'IOS_ar', $data['title']['ar']);
            send_fcm(null, 'ios', $data['text']['en'], null, null, null, 'IOS_en', $data['title']['en']);
        }
        if ($id) {
            return redirect()->route('admin.notifications');
        }

        return response()->json(['url' => route('admin.notifications'), 'message' => __('Notification sent successfully')]);
    }

    public function notifications_delete($id)
    {
        Notification::find($id)->delete();
        return response()->json(['url' => route('admin.notifications'), 'message' => __('Notification deleted successfully')]);
    }

    public function notfs_counter()
    {
        $rows = [
            'orders' => Order::notseen()->count(),
            'requests' => Store::whereType('request')->count(),
            'messages' => Contactus::where('seen', null)->count(),
        ];
        return response()->json($rows);
    }
}
