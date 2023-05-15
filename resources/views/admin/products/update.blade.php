@extends('admin.layouts.master')

@section('title', 'Product Update Page')
@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
            </div>
            <div class="col-md-10 offset-md-1">
                <div class="card">
                    <div class="card-body">
                        <button type="button" onclick="history.back()" class="btn btn-dark btn-sm">
                            <i class="fa-solid fa-left-long"></i>
                        </button>
                        <div class="card-title">
                            <h3 class="text-center title-2">Update Pizza</h3>
                        </div>

                        <hr>
                        {{--  Pizza Update form --}}
                        <form action="{{ route('products.update', $pizza->id) }}" enctype="multipart/form-data"
                            method="POST">

                            @csrf
                            <div class="row">
                                <div class="col-4 offset-1">
                                    <img src="{{ asset('storage/' . $pizza->image) }}" alt="User name"
                                        class="img-thumbnail shadow-sm w-100" />
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
                                        <input id="name" value="{{ old('name', $pizza->name) }}" name="name"
                                            type="text" class="form-control @error('name') is-invalid @enderror"
                                            placeholder="Enter Name">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="description" class="control-label mb-1">Description</label>
                                        <textarea name="description" id="description" rows="6"
                                            class="form-control @error('description') is-invalid @enderror" placeholder="Enter description..."> {{ old('description', $pizza->description) }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="category_id" class="control-label mb-1">Category</label>
                                        <select name="category_id" value="{{ old('category_id') }}" id="category_id"
                                            class="form-select @error('category_id') is-invalid @enderror">
                                            <option value="">Choose Category...</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    @if ($category->id == $pizza->category_id) selected @endif>{{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="price" class="control-label mb-1">Price</label>
                                        <input id="price" value="{{ old('price', $pizza->price) }}" name="price"
                                            type="number" class="form-control @error('price') is-invalid @enderror"
                                            placeholder="Enter price...">
                                        @error('price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="waiting_time" class="control-label mb-1">Waiting Time</label>
                                        <input id="waiting_time" value="{{ old('waiting_time', $pizza->waiting_time) }}"
                                            name="waiting_time" type="number"
                                            class="form-control @error('waiting_time') is-invalid @enderror"
                                            placeholder="Waiting Time...">
                                        @error('waiting_time')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="view_count" class="control-label mb-1">View Count</label>
                                        <input id="view_count" value="{{ $pizza->view_count }}" name="view_count"
                                            type="text" class="form-control" disabled>
                                    </div>

                                    <div class="form-group">
                                        <label for="created_at" class="control-label mb-1">Created Date</label>
                                        <input id="created_at" value="{{ $pizza->created_at->format('j-F-Y') }}"
                                            name="created_at" type="text" class="form-control" disabled>
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
