<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $lang = config('app.locale');
        if ($request->expectsJson())
            $lang = $request->header('Accept-Language',$lang);
        else
            if (Cookie::get('user-language') !== null)
                $lang = Cookie::get('user-language')??$lang;
        setLanguage($lang);
        return $next($request);
    }
}
