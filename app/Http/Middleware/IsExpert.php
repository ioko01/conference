<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsExpert
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
        if (auth()->user()->position_id == 4 || auth()->user()->is_admin == 2 || auth()->user()->is_admin == 3) {
            return $next($request);
        }
        abort(401);
    }
}
