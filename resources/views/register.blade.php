@extends('layouts.master')

@section('title', 'register')

@section('content')
    <div class="login-form">
        <form action="{{ url('/register') }}" method="post">

            @csrf

            @error('terms')
                <strong class="text-danger">{{ $message }}</strong>
            @enderror
            <div class="form-group">
                <label>Username</label>
                <input class="au-input au-input--full" type="text" name="name" placeholder="Username">
            </div>
            @error('name')
                <strong class="text-danger">{{ $message }}</strong>
            @enderror

            <div class="form-group">
                <label>Email Address</label>
                <input class="au-input au-input--full" type="email" name="email" placeholder="Email">
            </div>
            @error('email')
                <strong class="text-danger">{{ $message }}</strong>
            @enderror

            <div class="form-group">
                <label>Phone</label>
                <input class="au-input au-input--full" type="number" name="phone" placeholder="xxxxxxxxx">
            </div>
            @error('phone')
                <strong class="text-danger">{{ $message }}</strong>
            @enderror

            <div class="form-group">
                <label>Address</label>
                <input class="au-input au-input--full" type="text" name="address" placeholder="Address">
            </div>
            @error('address')
                <strong class="text-danger">{{ $message }}</strong>
            @enderror

            <div class="form-group">
                <label for="gender">Gender</label>
                <select name="gender" id="gender" class="au-input au-input--full" value="{{ old('gender') }}">
                    <option value="">Choose gender...</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div>
            @error('gender')
                <strong class="text-danger">{{ $message }}</strong>
            @enderror

            <div class="form-group">
                <label>Password</label>
                <input class="au-input au-input--full" type="password" name="password" placeholder="Password">
            </div>
            @error('password')
                <strong class="text-danger">{{ $message }}</strong>
            @enderror

            <div class="form-group">
                <label>Password</label>
                <input class="au-input au-input--full" type="password" name="password_confirmation"
                    placeholder="Confirm Password">
            </div>
            @error('password_confirmation')
                <strong class="text-danger">{{ $message }}</strong>
            @enderror

            <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit">register</button>

        </form>
        <div class="register-link">
            <p>
                Already have account?
                <a href="{{ route('auth.login') }}">Sign In</a>
            </p>
        </div>
    </div>
@endsection
