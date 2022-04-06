<?php

namespace Modules\User\Controllers;

use Modules\Common\Controllers\HelperController;
use Modules\User\Models\Role;
use Modules\User\Models\User;

class RolesController extends HelperController
{
    public function __construct()
    {
        $this->model = new Role;
        $this->title = "Roles";
        $this->name =  'roles';
        $this->list = ['name' => 'الاسم'];
        $this->inputs = [
            'name' => ['title' =>  'اسم الصلاحية '],
            'roles[]' =>  ['title' => 'الصلاحيات', 'type' => 'select', 'values' => admin_roles(), 'multiple' => 'multiple']
        ];
        // $this->links = [
        //     [
        //         'title' =>  'Moderators',
        //         'icon'  =>  'fa-users',
        //         'url'   =>  'admin.moderators',
        //         'key'   =>  'role_id',
        //         'type'  =>  'success'
        //     ]
        // ];
    }

    public function destroy($id)
    {
        $this->model->findOrFail($id)->delete();
        User::where('role_id', $id)->update(['role_id' => null]);
        return response()->json(['url' => route('admin.' . $this->name . '.index'), 'message' => __("Deleted successfully")]);
    }

    public function moderators()
    {
        if (!request('role_id')) abort(404);
        if (request()->isMethod('get')) {
            $users = User::where('role_id', request('role_id'))->orWhere('role_id', null)->get();
            $role = Role::find(request('role_id'));
            $title = "Moderators";
            return view('User::admin.moderators', get_defined_vars());
        }
        // dd(request('users'));
        $users = User::whereIn('id', request('users'))->update(['role_id' => request('role_id')]);
        return response()->json(['url' => route('admin.roles.index'), 'message' => __("Info saved successfully")]);
    }
}
