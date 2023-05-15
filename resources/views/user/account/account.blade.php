@extends('user.layouts.master')

@section('title', 'Online Shop')
@section('content')

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
                                <h3 class="text-center title-2">Account Profile</h3>
                            </div>

                            @if (session('updateSuccess'))
                                <div class="col-md-4 offset-md-8 alert alert-success alert-dismissible fade show" role="alert">
                                    <strong><i class="fa-solid fa-thumbs-up me-1"></i>{{ session('updateSuccess') }}</strong>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            <hr>
                            {{-- Account edit form --}}
                            <form action="{{ route('user.accountChange', Auth::user()->id) }}" enctype="multipart/form-data"
                                method="POST">

                                @csrf
                                <div class="row">
                                    <div class="col-4 offset-1">
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
                                        <input type="file" name="image"
                                            class="form-control mt-3 @error('image') is-invalid @enderror">

                                        @error('image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror

                                        <div class="mt-3">
                                            <button type="submit" class="btn btn-dark col-12">
                                                <i class="fa-solid fa-circle-arrow-right me-1"></i>Update
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row col-6">
                                        <div class="form-group">
                                            <label for="name" class="control-label mb-1">Name</label>
                                            <input id="name" value="{{ old('name', Auth::user()->name) }}"
                                                name="name" type="text"
                                                class="form-control @error('name') is-invalid @enderror"
                                                placeholder="Enter Name">
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="email" class="control-label mb-1">Email</label>
                                            <input id="email" value="{{ old('email', Auth::user()->email) }}"
                                                name="email" type="email"
                                                class="form-control @error('email') is-invalid @enderror"
                                                placeholder="Enter Email">
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="phone" class="control-label mb-1">Phone</label>
                                            <input id="phone" value="{{ old('phone', Auth::user()->phone) }}"
                                                name="phone" type="text"
                                                class="form-control @error('phone') is-invalid @enderror"
                                                placeholder="Enter Phone">
                                            @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="gender" class="control-label mb-1">Gender</label>
                                            <select name="gender" value="{{ old('gender') }}" id="gender"
                                                class="form-select @error('gender') is-invalid @enderror">
                                                <option value="">Choose gender...</option>
                                                <option value="male" @if (Auth::user()->gender == 'male') selected @endif>
                                                    Male</option>
                                                <option value="female" @if (Auth::user()->gender == 'female') selected @endif>
                                                    Female</option>
                                            </select>
                                            @error('gender')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="address" class="control-label mb-1">Address</label>
                                            <textarea name="address" id="address" rows="3" class="form-control @error('address') is-invalid @enderror"
                                                placeholder="Enter Address"> {{ old('address', Auth::user()->address) }}</textarea>
                                            @error('address')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="role" class="control-label mb-1">Role</label>
                                            <input id="role" value="{{ Auth::user()->role }}" name="role"
                                                type="text" class="form-control" disabled>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
