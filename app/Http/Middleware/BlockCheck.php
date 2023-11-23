<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlockCheck
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
        if (Auth::check() && Auth::user()->block == 1) {
            // If the user is blocked, you can abort the request
            // You can also redirect the user to a specific route or return a custom response
            return abort(403, 'Your account is blocked.');
        }

        return $next($request);
    }
}