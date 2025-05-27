@extends('admin.layouts.master')

@section('title', 'Products Create Page')
@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                        <div class="row">
                            <div class="col-3 offset-8">
                                <a href="{{ route('products.list') }}"><button class="btn bg-dark text-white my-3">List</button></a>
                            </div>
                        </div>
                        <div class="col-lg-6 offset-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title">
                                        <h3 class="text-center title-2">Create Pizza</h3>
                                    </div>
                                    <hr>
                                    <form action="{{ route('products.create') }}" method="POST" enctype="multipart/form-data" novalidate="novalidate">

                                        @csrf
                                        <div class="form-group">
                                            <label for="name" class="control-label mb-1">Name</label>
                                            <input id="name" name="name" type="text" class="form-control @error('name')
                                                is-invalid
                                            @enderror" value="{{ old('name') }}" aria-required="true" aria-invalid="false" placeholder="Enter Pizza Name...">
                                            @error('name')
                                                <strong class="invalid-feedback">{{ $message }}</strong>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="category" class="control-label mb-1">Category</label>
                                            <select name="category_id" id="category" value="{{ old('category_id') }}" class="form-select @error('category_id') is-invalid @enderror">
                                                <option value="">Choose Category...</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                                <strong class="invalid-feedback">{{ $message }}</strong>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="description" class="control-label mb-1">Description</label>
                                            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" placeholder="Enter Description...">{{ old('description') }}</textarea>
                                            @error('description')
                                                <strong class="invalid-feedback">{{ $message }}</strong>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="image" class="control-label mb-1">Image</label>
                                            <input id="image" name="image" type="file" class="form-control @error('image') is-invalid @enderror" aria-required="true" aria-invalid="false">
                                            @error('image')
                                                <strong class="invalid-feedback">{{ $message }}</strong>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="price" class="control-label mb-1">Price</label>
                                            <input id="price" name="price" type="text" value="{{ old('price') }}" placeholder="Enter Price..." class="form-control @error('price') is-invalid @enderror" aria-required="true" aria-invalid="false">
                                            @error('price')
                                                <strong class="invalid-feedback">{{ $message }}</strong>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="waiting_time" class="control-label mb-1">Waiting Time</label>
                                            <input id="waiting_time" name="waiting_time" type="text" value="{{ old('waiting_time') }}" placeholder="Enter Waiting Time..." class="form-control @error('waiting_time') is-invalid @enderror" aria-required="true" aria-invalid="false">
                                            @error('waiting_time')
                                                <strong class="invalid-feedback">{{ $message }}</strong>
                                            @enderror
                                        </div>

                                        <div>
                                            <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block text-white">
                                                <span id="payment-button-amount">Create</span>
                                                {{-- <span id="payment-button-sending" style="display:none;">Sending…</span> --}}
                                                <i class="fa-solid fa-circle-right"></i>
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
