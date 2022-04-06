<?php

namespace Modules\Common\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $table = 'visitors';
    protected $fillable = ['ip_address'];
}
