@extends('layouts.master')

@section('title', 'login')

@section('content')
    <div class="login-form">
        @error('terms')
            <p class="text-danger">{{ $message }}</p>
        @enderror

        @if (session('changeSuccess'))
            <div class="alert alert-success" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i>
                <strong>{{ session('changeSuccess') }}</strong>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">

            @csrf
            <div class="form-group">
                <label>Email Address</label>
                <input class="au-input au-input--full" type="email" name="email" placeholder="Email">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input class="au-input au-input--full" type="password" name="password" placeholder="Password">
            </div>

            <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit">Login</button>
        </form>
        <div class="register-link">
            <p>
                Don't you have account?
                <a href="{{ route('auth.register') }}">Sign Up Here</a>
            </p>
        </div>
    </div>
@endsection
