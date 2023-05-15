@extends('admin.layouts.master')

@section('title', 'Products List Page')
@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <div class="table-data__tool">
                        <div class="table-data__tool-left">
                            <div class="overview-wrap">
                                <h2 class="title-1">Products List</h2>

                            </div>
                        </div>
                        <div class="table-data__tool-right">
                            <a href="{{ route('products.createPage') }}">
                                <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                    <i class="zmdi zmdi-plus"></i>Add Pizza
                                </button>
                            </a>
                        </div>
                    </div>
                    <!-- END DATA TABLE -->

                    @if (session('success'))
                        <div class="col-4 offset-8 alert alert-success alert-dismissible fade show" role="alert">
                            <strong>{{ session('success') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-8">
                            <h5>Search Key: <span class="text-danger">{{ request('key') }}</span></h5>
                        </div>
                        <div class="col-4">
                            <form action="{{ route('products.list') }}" method="GET">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Search..." name="key"
                                        value="{{ request('key') }}">
                                    <button class="btn btn-secondary" type="submit">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    @if (count($pizzas) != 0)
                        <div class="table-responsive table-responsive-data2">
                            <table class="table table-data2">
                                <thead>
                                    <tr class="text-uppercase">
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Category</th>
                                        <th>View Count</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pizzas as $pizza)
                                        <tr class="tr-shadow">
                                            <td class="col-2"><img src="{{ asset('storage/' . $pizza->image) }}"
                                                    alt="pizza image"></td>
                                            <td class="col-2">{{ $pizza->name }}</td>
                                            <td class="col-2">{{ $pizza->price }}</td>
                                            <td class="col-2">{{ $pizza->category_name }}</td>
                                            <td><i class="fa-solid fa-eye"></i>{{ $pizza->view_count }}</td>
                                            <td>
                                                <div class="table-data-feature">
                                                    {{-- btn for view  --}}
                                                    <a href="{{ route('products.view', $pizza->id) }}">
                                                        <button class="item me-1" data-toggle="tooltip" data-placement="top"
                                                            title="View">
                                                            <i class="fa-solid fa-eye"></i>
                                                        </button>
                                                    </a>
                                                    <a href="{{ route('products.update', $pizza->id) }}">
                                                        <button class="item me-1" data-toggle="tooltip" data-placement="top"
                                                            title="Edit">
                                                            <i class="zmdi zmdi-edit"></i>
                                                        </button>
                                                    </a>
                                                    {{-- Delete button  --}}
                                                    <a href="{{ route('products.delete', $pizza->id) }}">
                                                        <button class="item" data-toggle="tooltip" data-placement="top"
                                                            title="Delete"
                                                            onclick="return confirm('Are you sure you want to delete?')">
                                                            <i class="zmdi zmdi-delete"></i>
                                                        </button>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach

                                    <div>
                                        {{ $pizzas->links() }}
                                    </div>

                                </tbody>
                            </table>
                        </div>
                    @else
                        <h3 class="text-secondary text-center mt-5">There is no pizza here...</h3>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
