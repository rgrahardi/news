<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CekSuperadmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->role != 'superadmin' || !auth()->user()) {
            return abort(401);
        }

        return $next($request);
    }
}
