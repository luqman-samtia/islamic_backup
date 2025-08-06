<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class EnsureStudentIsAuthenticated
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
        // Check if the user is authenticated and has the 'student' role or a specific condition
        if (Auth::check() && (Auth::user()->type === 'student' || Auth::user()->type === 'admin' || Auth::user()->type === 'scholar') ) {
            return $next($request);
        }
         
        // return redirect()->route('site')->with('error', 'You must be logged in as a student to access this page.');
        return redirect()->route('site')->with('showLogin', true);
    
    }
}
