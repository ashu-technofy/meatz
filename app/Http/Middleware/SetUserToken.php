<?php

namespace App\Http\Middleware;

use Closure;
use Modules\User\Models\Device;

class SetUserToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = auth('api')->user();
        if ($user && $lang = request()->header('Lang')) {
            $user->update(['lang' => $lang]);
        }
        
        $token = request()->header('FbToken');
        // dd($user , $token);
        if ($user && $token) {
            $platform = request()->header('Platform') ?? 'android';
            $device = $user->device()->firstOrCreate(['device_token' => $token, 'device_type' => $platform]);
            $user->device()->where('id', '!=', $device->id)->delete();
            Device::where('user_id', '!=', $user->id)->where(['device_token' => $token, 'device_type' => $platform])->delete();
        }
        return $next($request);
    }
}
