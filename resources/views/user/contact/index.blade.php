@extends('user.layouts.master')

@section('title', 'Online Shop')
@section('content')

    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-3 offset-8">

                    </div>
                </div>
                <div class="col-md-6 col-12 offset-md-3">
                    <div class="card">
                        @if (session('successMsg'))
                            <div class="alert alert-info alert-dismissible fade show" role="alert">
                                <strong>{{ session('successMsg') }}</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center title-2">Contact Us</h3>
                            </div>

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <hr>
                            <form action="{{ route('user.contact') }}" method="POST">

                                @csrf
                                <div class="mb-3">
                                    <label for="name">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name"
                                        class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                        required>
                                </div>

                                <div class="mb-3">
                                    <label for="email">Email <span class="text-danger">*</span></label>
                                    <input type="text" name="email" id="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email') }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="message">Message <span class="text-danger">*</span></label>
                                    <textarea name="message" id="message" class="form-control @error('message') is-invalid @enderror" required>{{ old('message') }}</textarea>
                                </div>

                                <div>
                                    <button id="payment-button" type="submit"
                                        class="btn btn-lg btn-dark btn-block text-white">
                                        <i class="fa-solid fa-paper-plane"></i>
                                        Submit
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
