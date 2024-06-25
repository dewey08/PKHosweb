<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
class TypeAdmin
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
        // if (auth()->user()->type == 'ADMIN' || auth()->user()->type == 'STAFF' ||auth()->user()->type == 'MANAGE' ||auth()->user()->type == 'USER' ||auth()->user()->type == 'CUSTOMER' ) {
        //     return $next($request);
        // }
        // return redirect('/')->with('error','คุณไม่มีสิทธิ์เข้าถึงข้อมูล');
        if(empty(Auth::user())){
            return redirect(route('login'));
        }
        return $next($request);
    }
}
