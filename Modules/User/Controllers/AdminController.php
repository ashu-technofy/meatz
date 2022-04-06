<?php

namespace Modules\User\Controllers;

use Illuminate\Http\Request;
use Modules\Areas\Models\Area;
use Modules\Common\Controllers\HelperController;
use Modules\User\Models\AdminAction;
use Modules\User\Models\User;

class AdminController extends HelperController
{
    public function __construct()
    {
        $this->model = new User;
        $this->rows = User::where('role_id', null);
        $this->title = "Users";
        $this->name = 'users';
        $this->list = [
            'first_name' => 'الاسم الأول',
            'last_name' => 'الاسم الأخير',
            'mobile' => 'رقم الهاتف',
            'email' => 'البريد الإلكترونى',
            'wallet' => 'رصيد المحفظة',
        ];
        // $this->switches['status'] = ['url' => route("admin.users.status")];
        $this->inputs = [
            'first_name' => ['title' => 'الاسم الأول'],
            'last_name' => ['title' => 'الاسم الأخير'],
            'email' => ['title' => 'البريد الإلكترونى' , 'type' => 'email', 'empty' => 1],
            'mobile' => ['title' => 'رقم الهاتف'],
            'password' => ['title' => 'كلمة المرور', 'type' => 'password', 'empty' => 1],
            'wallet' => ['title' => 'رصيد المحفظة' , 'type' => 'number'],
            // 'image'  =>  ['title'    =>  'الصورة', 'type' => 'image'],
        ];

        $this->links[] = [
            'title' => 'Orders',
            'type' => 'primary',
            'key' => 'user_id',
            'url' => 'admin.orders.index',
            'icon' => 'fa-th-list',
        ];

        $this->links[] = [
            'title' => 'Addresses',
            'type' => 'success',
            'key' => 'user_id',
            'url' => 'admin.user_addresses',
            'icon' => 'fa-map-marker',
        ];
        $this->links[] = [
            'title' => 'Favourites',
            'type' => 'warning',
            'key' => 'user_id',
            'url' => 'admin.likes_products',
            'icon' => 'fa-heart',
        ];

        $this->switches['status'] = ['url' => route("admin.users.status")];
        // $this->can_add = false;
    }

    public function store(Request $request)
    {
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'unique:users',
            'mobile' => 'required|unique:users',
            'password' => 'required|min:6',
        ];
        if (request('email')) {
            $rules['email'] = 'unique:users,email';
        }
        $this->validate($request, $rules);

        User::create($request->all());
        return response()->json(['url' => route('admin.users.index'), 'message' => __("User added successfully")]);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'mobile' => 'required|unique:users,mobile,' . $user->id,
        ];
        if (request('email')) {
            $rules['email'] = 'unique:users,email,' . $user->id;
        }
        if (request('password')) {
            $rules['password'] = 'min:6';
        }
        $this->validate($request, $rules);

        if (request('credits') != $user->credits && $user->device) {
            $token = $user->device->device_token;
            $platform = $user->device->device_type;
            $message = "تم تحديث رصيد المحفظة";
            // $message = __("Your order #:num status changed to {$order->status}", ['num' => $order->id]);
            send_fcm($token, $platform, $message, null, null, request('credits'));
        }
        $user->update($request->all());
        return response()->json(['url' => route('admin.users.index'), 'message' => __("Info saved successfully")]);
    }

    public function status()
    {
        $user = User::findOrFail(request('id'));
        $status = $user->status ? 0 : 1;
        $user->update(['status' => $status]);
        return 'success';
    }

    public function likes(){
        $user = User::find(request('user_id'));
        $rows = $user->likes()->latest()->paginate(20);
        $title = "Favourites";
        $can_add = $can_delete = false;
        $paginate = true;
        $name = 'products';
        $list = [
            'name' => 'الاسم',
            'category_name' => 'النوع'
        ];
        return view("Common::admin.list" , get_defined_vars());
    }

    public function addresses()
    {
        $user = User::findOrFail(request('user_id'));
        if($id = request('address_id')){
            $row = $info = $user->addresses()->find($id);
            if(request('action') == 'edit'){
                if(request()->isMethod('post')){
                    $row->update(request()->all());
                    return response()->json([
                        'url' => route('admin.user_addresses' , ['user_id' => request('user_id')]), 
                        'message' => __("Info saved successfully")
                    ]);
                }else{
                    $areas = Area::get();
                    $title = __('Edit Address');
                    return view('User::admin.edit_address' , get_defined_vars());
                }
            }else{
                if ($row) {
                    $row->delete();
                }
            }
        }
        return view('User::admin.addresses', ['rows' => $user->addresses, 'title' => 'Addresses']);
    }

    public function add_admin_actions()
    {
        $user = auth()->user();
        $title = request('title');
        $url = request('url');
        $name = request('name', '');
        $method = request('method');
        $action = null;
        if (strpos($url, 'create')) {
            $action = ":admin enter page of create :title";
        } elseif (strpos($url, 'edit')) {
            $action = ":admin enter page of edit :title (:name)";
        } elseif ($method == 'store') {
            $action = ":admin added new :title (:name)";
        } elseif ($method == 'update') {
            $action = ":admin edit :title (:name)";
            $url .= '/edit';
        } else {
            // $action = ":admin enter page of :title";
        }
        if ($action) {
            // dd(get_defined_vars());
            $user->actions()->create([
                'action' => $action,
                'url' => $url,
                'title' => $title,
                'name' => $name,
            ]);
        }
    }

    public function admin_actions()
    {
        $title = "Admin archive";
        $actions = AdminAction::when(request('keyword'), function ($query) {
            return $query->whereHas('admin', function ($q) {
                return $q->where('username_ar', 'like', '%' . request('keyword') . '%')
                    ->orWhere('username_ar', 'like', '%' . request('keyword') . '%');
            })
                ->orWhere('title', 'like', request('keyword'))
                ->orWhere('name', 'like', request('keyword'));
        })
            ->latest()
            ->paginate(30);
        return view("User::admin.actions", get_defined_vars());
    }
}
