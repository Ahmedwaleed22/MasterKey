<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class is_admin
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
        if (auth()->user()->is_admin) {
            return $next($request);
        } else {
            return response()->json([
                "error" => "You don't have permission to access this route"
            ], 403);
        }
    }
}
