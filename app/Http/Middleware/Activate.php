<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Activate
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
        // return $next($request);
        if ($request->age <= 200) {
            // return redirect('activate');
        }

        return $next($request);
    }
}
