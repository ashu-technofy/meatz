<?php

namespace Modules\User\Controllers;

use Modules\User\Models\User;
use Illuminate\Http\Request;
use Modules\Common\Controllers\HelperController;
use Modules\User\Models\Role;

class ModeratorsController extends HelperController
{
    public function __construct()
    {
        $this->model = new User;
        $this->rows = User::whereHas('role');
        $this->title = "Moderators";
        $this->name =  'moderators';
        $this->list = ['username' => 'الاسم', 'role_name' => 'الصلاحية', 'created_at' => 'تاريخ الإشتراك'];
        $roles = Role::pluck('name', 'id');
        $this->inputs = [
            'role_id'  =>  ['title'    =>  'الصلاحية', 'type' => 'select', 'values' => $roles],
            'username'  =>  ['title'    =>  'الاسم '],
            'email'  =>  ['title'    =>  'البريد الإلكترونى'],
            'mobile'  =>  ['title'    =>  'رقم الجوال'],
            'password'  =>  ['title'    =>  'كلمة المرور', 'type' => 'password'],
            'image'  =>  ['title'    =>  'الصورة', 'type' => 'image', 'empty' => 1],
        ];
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'role_id'   =>  'required',
            'username'    =>  'required',
            'email'   =>  'required|email|unique:users',
            'mobile' =>  'required|unique:users',
            'password'  =>  'required|min:6'
        ]);
        User::create($request->all());
        return response()->json(['url' => route('admin.moderators.index'), 'message' => 'تم اضافة الموظف بنجاح']);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $this->validate($request, [
            'role_id'   =>  'required',
            'username'    =>  'required',
            'email'   =>  'required|email|unique:users,email,' . $user->id,
            'mobile' =>  'required|unique:users,mobile,' . $user->id,
        ]);
        if (request('password')) {
            $this->validate($request, ['password'  =>  'min:6']);
        }
        $user->update($request->all());
        return response()->json(['url' => route('admin.moderators.index'), 'message' => __("Info saved successfully")]);
    }
}
