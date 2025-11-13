<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        // Allow users with role 'kagawad' or 'kapitan'
        if (Auth::check() && (Auth::user()->role === 'kagawad' || Auth::user()->role === 'kapitan')) {
            return $next($request);
        }

        // If user is not admin, redirect
        return redirect('/dashboard')->with('error', 'Access denied.');
    }
}
