<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()->role == 'admin') {
            return route('categories.list');
        } else {
            return route('users.home');
        }
        // return $next($request);
    }
}
