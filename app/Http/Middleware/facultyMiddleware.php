<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Faculty;
use Illuminate\Support\Facades\Auth;

class facultyMiddleware
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

        if (auth()->check() && auth()->user()->role == 2) {
            $faculty = Faculty::where('username', auth()->user()->username)->first();
            if (!$faculty->status) {
                Auth::logout();
                return redirect('/login')->with("error", "Inactive User.");
            }
            return $next($request);
        }

        // abort(403, 'Unauthorized action.');
        return redirect('/login')->with("error", "Unauthorized action.");
        // return $next($request);

    }
}