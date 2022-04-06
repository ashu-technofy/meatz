<?php

namespace App\Http\Middleware;

use Closure;

class Locale
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
        if ($request->wantsJson()) {
            if (in_array(request()->header('Lang'), ['ar', 'en'])) {
                app()->setLocale(request()->header('Lang'));
            } elseif (auth('api')->check()) {
                $lang = auth('api')->user()->lang ?? 'ar';
                app()->setLocale($lang);
            } else {
                app()->setLocale('ar');
            }
        } elseif ($lang = session('current_locale')) {
            app()->setLocale($lang);
        }
        return $next($request);
    }
}
