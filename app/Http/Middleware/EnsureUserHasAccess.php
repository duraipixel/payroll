<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserHasAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $access_menu = null)
    {
        if( auth()->user()->id ) {
            if( auth()->user()->is_super_admin ) {

            } else {
                
                if( !access()->check_access($access_menu) ) {
                    abort(403);
                }
            }            
        }
        return $next($request);
    }
}
