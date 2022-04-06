<?php

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = "user_roles";
    protected $fillable = ['name', 'roles'];
    protected $casts = ['roles' => 'array'];

    public function getUsersAttribute()
    {
        return User::where('role_id', $this->id)->pluck('id')->toArray();
    }
}
