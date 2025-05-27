<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // If user is authenticated
        if (!empty($user)) {

            if ($request->routeIs('auth.login') || $request->routeIs('auth.register')) {
                return $this->redirectToRoleHome($user);
            }

            if ($user->role === 'user') {
                return redirect()->route('users.home');
            }

            return $next($request);
        }

        return $next($request);
    }

    protected function redirectToRoleHome($user)
    {
        if ($user->role === 'user') {
            return redirect()->route('users.home');
        }

        return redirect()->route('dashboard');
    }
}
