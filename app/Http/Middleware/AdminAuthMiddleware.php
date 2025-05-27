<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // dd(url()->current());
        // dd(route('auth.login'));

        if (!empty(Auth::user())) {
            // if we go to login or register page with logout
            if (url()->current() == route('auth.login') || url()->current() == route('auth.register')) {
                if (Auth::user()->role == 'user') {
                    return redirect()->route('users.home');
                }

                return redirect()->route('dashboard');
            }

            return $next($request);
        }

        return $next($request);
    }
}
