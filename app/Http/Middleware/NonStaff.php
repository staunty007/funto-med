<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class NonStaff
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
        if (Auth::check() && Auth::user()->user_type == '3') {
            return $next($request);
        }
        elseif (Auth::check() && Auth::user()->user_type == '1') {
            return redirect('/admin/dashboard');
        }
        else {
            return redirect('/doctor/dashboard');
        }
    }
}
