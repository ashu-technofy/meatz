<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Route;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        $modules = glob(base_path("Modules/*"));
        foreach ($modules as $module) {
            $module = array_reverse(explode('/', $module))[0];
            if (strpos($module, '.php') === false) {
                $roles[] = $module;
            }
        }
        $user = auth()->user();
        if(!$user){
            auth()->attempt(['email' => session('admin_mail') , 'password' => session('admin_pass')]);
        }
        if (auth('stores')->check() && in_array($role, ['Orders', 'Products', 'Stores', 'Common'])) {
            return $next($request);
        } elseif (auth()->check() && auth()->user()->role) {
            $route_name = Route::currentRouteName();
            if (in_array($route_name, ['admin.home', 'admin.load'])) return $next($request);
            $user = auth()->user();
            if ($user && $user->role_id && in_array($role, $user->role->roles)) {
                return $next($request);
            }
        }
        auth()->logout();
        return redirect()->to('login')->with('error', 'ليس لديك تصريح للدخول لهذة الصفحة');
    }
}
