<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class studentMiddleware
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
        if(auth()->check() && auth()->user()->role == 0) {
        return $next($request);
        }

        // abort(403, 'Unauthorized action.');
        return redirect('/login')->with("error" , "Unauthorized action. OR Session Expired!");
    }
}
