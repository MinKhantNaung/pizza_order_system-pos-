<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // direct login page
    public function login()
    {
        return view('login');
    }

    // direct register page
    public function register()
    {
        return view('register');
    }

    // direct dashboard page
    public function dashboard()
    {
        if (Auth::user()->role == 'admin') {
            return redirect()->route('categories.list');
        }
        return redirect()->route('users.home');
    }
}
