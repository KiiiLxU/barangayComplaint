<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        // Allow only users with role 'kapitan'
        if (Auth::check() && Auth::user()->role === 'kapitan') {
            return $next($request);
        }

        // If user is not kapitan, redirect
        return redirect('/dashboard')->with('error', 'Access denied.');
    }
}
