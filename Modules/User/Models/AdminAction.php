<?php

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Models\User;

class AdminAction extends Model
{
    protected $table = "admin_actions";

    protected $fillable = ['name', 'title', 'action', 'url', 'admin_id'];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function getActionAttribute($action)
    {
        return __($action, ['admin' => $this->admin->username, 'title' => __($this->title), 'name' => $this->name]);
    }
}
