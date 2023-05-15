@extends('admin.layouts.master')

@section('title', 'Account Detail')
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
                <div class="col-md-10 offset-md-1">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center title-2">Account Info</h3>
                            </div>

                            @if (session('successUpdate'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>{{ session('successUpdate') }}</strong>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            <hr>
                            <div class="row">
                                <div class="col-3 offset-2 pt-4">
                                    @if (Auth::user()->image == null)
                                        @if (Auth::user()->gender == 'male')
                                            <img src="{{ asset('image/default_male.jpg') }}" alt="default image"
                                                class="img-thumbnail w-100 shadow-sm">
                                        @else
                                            <img src="{{ asset('image/default_female.jpg') }}" alt="default image"
                                                class="img-thumbnail w-100 shadow-sm">
                                        @endif
                                    @else
                                        <img src="{{ asset('storage/' . Auth::user()->image) }}" alt="User name"
                                            class="img-thumbnail shadow-sm w-100" />
                                    @endif
                                </div>
                                <div class="col-5 offset-1">
                                    <h5 class="my-3"><i class="fa-solid fa-user-check me-2"></i> {{ Auth::user()->name }}
                                    </h5>
                                    <h5 class="my-3"><i class="fa-solid fa-envelope-circle-check me-2"></i>
                                        {{ Auth::user()->email }}</h5>
                                    <h5 class="my-3"><i class="fa-solid fa-phone me-2"></i> {{ Auth::user()->phone }}</h5>
                                    <h5 class="my-3"><i class="fa-solid fa-address-card me-2"></i>
                                        {{ Auth::user()->address }}</h5>
                                    <h5 class="my-3"><i class="fa-solid fa-mars-and-venus me-2"></i>
                                        {{ Auth::user()->gender }}</h5>
                                    <h5 class="my-3"><i class="fa-solid fa-user-clock me-2"></i>
                                        {{ Auth::user()->created_at->format('j-F-Y') }}</h5>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4 offset-3 my-3">
                                    <a href="{{ route('admin.edit') }}">
                                        <button class="btn btn-dark">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                            Edit Profile
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
