<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->user_type == '1') {
            return $next($request);
        }
        elseif (Auth::check() && Auth::user()->user_type == '2') {
            return redirect('/doctor/dashboard');
        }
        else {
            return redirect('/staff/dashboard');
        }
    }

}
