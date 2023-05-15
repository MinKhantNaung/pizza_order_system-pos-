@extends('admin.layouts.master')

@section('title', 'Accout Passsword Change')
@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-3 offset-8">
                        {{-- <a href="{{ route('categories.list') }}"><button class="btn bg-dark text-white my-3">List</button></a> --}}
                    </div>
                </div>
                <div class="col-lg-6 offset-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center title-2">Change Password</h3>
                            </div>

                            @if (session('notMatch'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>{{ session('notMatch') }}</strong>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            <hr>
                            <form action="{{ route('admin.changePassword') }}" method="POST" novalidate="novalidate">

                                @csrf
                                <div class="form-group">
                                    <label for="oldPwd" class="control-label mb-1">Old Password</label>
                                    <input id="oldPwd" name="oldPassword" type="password"
                                        class="form-control @error('oldPassword')
                                                is-invalid
                                            @enderror @if (session('notMatch')) is-invalid @endif"
                                        aria-required="true" aria-invalid="false" placeholder="Enter Old Password">
                                    @error('oldPassword')
                                        <strong class="invalid-feedback">{{ $message }}</strong>
                                    @enderror

                                </div>

                                <div class="form-group">
                                    <label for="newPwd" class="control-label mb-1">New Password</label>
                                    <input id="newPwd" name="newPassword" type="password"
                                        class="form-control @error('newPassword')
                                                is-invalid
                                            @enderror"
                                        aria-required="true" aria-invalid="false" placeholder="Enter New Password">
                                    @error('newPassword')
                                        <strong class="invalid-feedback">{{ $message }}</strong>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="confirmPwd" class="control-label mb-1">Confirm Password</label>
                                    <input id="confirmPwd" name="confirmPassword" type="password"
                                        class="form-control @error('confirmPassword')
                                                is-invalid
                                            @enderror"
                                        aria-required="true" aria-invalid="false" placeholder="Enter Confirm Password">
                                    @error('confirmPassword')
                                        <strong class="invalid-feedback">{{ $message }}</strong>
                                    @enderror
                                </div>

                                <div>
                                    <button id="payment-button" type="submit"
                                        class="btn btn-lg btn-info btn-block text-white">
                                        <i class="fa-solid fa-key"></i>
                                        <span id="payment-button-amount">Change Password</span>
                                        {{-- <span id="payment-button-sending" style="display:none;">Sending…</span> --}}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
