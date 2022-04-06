<?php

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Modules\Addresses\Models\Address;
use Modules\Common\Models\Notification;
use Modules\Orders\Models\Cart;
use Modules\Orders\Models\Order;
use Modules\Stores\Models\StoreProduct;
use Modules\User\Models\AdminAction;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    // use SoftDeletes;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'first_name',
        'last_name',
        'email',
        'mobile',
        'password',
        'image',
        'status',
        'role_id',
        'status',
        'last_copon',
        'lang',
        'social_id',
        'social_type',
        'points',
        'wallet',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setUsernameAttribute($name)
    {
        if (!$name) {
            $this->attributes['username'] = request('first_name') . ' ' . request('$this->last_name');
        } else {
            $this->attributes['username'] = $name;
        }
    }
    public function getUsernameAttribute($name)
    {
        return $name ?? $this->first_name . ' ' . $this->last_name;
    }
    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function setImageAttribute($image)
    {
        $this->attributes['image'] = $image->store("uploads/users");
    }

    public function getImageAttribute($image)
    {
        return $image ? url($image) : url('placeholders/user.png');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function favourites()
    {
        return $this->hasMany(Favourite::class);
    }

    public function rates()
    {
        return $this->hasMany(Rate::class);
    }

    public function token()
    {
        return $this->hasOne(Token::class, 'user_id');
    }

    public function device()
    {
        return $this->hasOne(Device::class)->latest();
    }

    // public function addresses()
    // {
    //     return $this->hasMany(Address::class)->orderBy('status', 'desc');
    // }

    // public function getFullAddressAttribute()
    // {
    //     return $this->addresses()->first()->full_address ?? '';
    // }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function getOrdersCountAttribute()
    {
        return $this->orders()->count() ?? 0;
    }

    public function getCreatedAtAttribute($created_at)
    {
        return date('Y-m-d', strtotime($created_at));
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function getRoleNameAttribute()
    {
        return $this->role->name ?? '#';
    }

    public function likes()
    {
        return $this->belongsToMany(StoreProduct::class, 'user_likes', 'user_id', 'product_id');
    }

    public function boxes()
    {
        return $this->hasMany(Box::class);
    }

    public function getMywalletAttribute()
    {
        if (request()->wantsJson()) {
            return number_format($this->wallet, 3);
        }
        return $this->wallet ?? 0;
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getSocialAttribute()
    {
        return ['id' => $this->social_id, 'type' => $this->social_type];
    }

    public function actions()
    {
        return $this->hasMany(AdminAction::class, 'admin_id');
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function cart()
    {
        return $this->hasMany(Cart::class, 'user_id');
    }
}
