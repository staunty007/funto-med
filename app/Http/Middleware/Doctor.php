<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Doctor
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
        if (Auth::check() && Auth::user()->user_type == '2') {
            return $next($request);
        }
        elseif (Auth::check() && Auth::user()->user_type == '3') {
            return redirect('/staff/dashboard');
        }
        else {
            return redirect('/admin/dashboard');
        }
    }
}
