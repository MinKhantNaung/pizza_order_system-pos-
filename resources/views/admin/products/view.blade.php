@extends('admin.layouts.master')

@section('title', 'Pizza View Page')
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
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <button type="button" onclick="history.back()" class="btn btn-dark btn-sm">
                                <i class="fa-solid fa-left-long"></i>
                            </button>
                            <div class="card-title">
                                <h3 class="text-center title-2">Pizza Details</h3>
                            </div>

                            <hr>
                            <div class="row">
                                <div class="col-3 offset-2 pt-4">
                                    <img src="{{ asset('storage/' . $pizza->image) }}" alt="pizza image"
                                        class="img-thumbnail shadow-sm w-100" />
                                </div>
                                <div class="col-7">
                                    <span class="my-3 btn btn-danger fs-5"> {{ $pizza->name }}
                                    </span> <br>
                                    <span class="my-3 btn btn-dark btn-sm"><i
                                            class="fa-solid fs-5 fa-money-bill-wave me-2"></i>
                                        {{ $pizza->price }}</span>
                                    <span class="my-3 btn btn-dark btn-sm"><i
                                            class="fa-solid fs-5 fa-hourglass-start me-2"></i>
                                        {{ $pizza->waiting_time }}</span>
                                    <span class="my-3 btn btn-dark btn-sm"><i class="fa-solid fs-5 fa-eye me-2"></i>
                                        {{ $pizza->view_count }}</span>
                                    <span class="my-3 btn btn-dark btn-sm"><i class="fa-solid fa-clone me-2"></i>
                                        {{ $pizza->category_name }}</span>
                                    <span class="my-3 btn btn-dark btn-sm"><i class="fa-solid fs-5 fa-clock me-2"></i>
                                        {{ $pizza->created_at->format('j-F-Y') }}</span>
                                    <div class="my-3"><i class="fa-solid fs-5 fa-book me-2"></i> Details
                                    </div>
                                    <div>
                                        {{ $pizza->description }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
