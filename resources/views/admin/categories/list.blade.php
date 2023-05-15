@extends('admin.layouts.master')

@section('title', 'Category List Page')
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
                                <h2 class="title-1">Category List</h2>

                            </div>
                        </div>
                        <div class="table-data__tool-right">
                            <a href="{{ route('categories.createPage') }}">
                                <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                    <i class="zmdi zmdi-plus"></i>Add Category
                                </button>
                            </a>
                        </div>
                    </div>

                    {{-- Alert for create success --}}
                    @if (session('createMsg'))
                        <div class="col-4 offset-8 alert alert-success alert-dismissible fade show" role="alert">
                            <strong>
                                <i class="fa-solid fa-check"></i>
                                {{ session('createMsg') }}
                            </strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- Alert for delete success --}}
                    @if (session('deleteMsg'))
                        <div class="col-4 offset-8 alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>
                                <i class="fa-solid fa-check"></i>
                                {{ session('deleteMsg') }}
                            </strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-8">
                            <h5>Search Key: <span class="text-danger">{{ request('key') }}</span></h5>
                        </div>
                        <div class="col-4">
                            <form action="{{ route('categories.list') }}" method="GET">
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

                    <div class="row mt-2">
                        <h4 class="col-1 offset-10 bg-white p-2 text-center shadow-sm">
                            <i class="fa-solid fa-database"></i> {{ $categories->total() }}
                        </h4>
                    </div>

                    @if (count($categories) != '0')
                        <div class="table-responsive table-responsive-data2">
                            <table class="table table-data2">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Category Name</th>
                                        <th>Created Date</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $category)
                                        <tr class="tr-shadow">
                                            <td>{{ $category->id }}</td>
                                            <td>{{ $category->name }}</td>
                                            <td>{{ $category->created_at->format('j-F-Y') }}</td>
                                            <td>
                                                <div class="table-data-feature">
                                                    <a href="{{ route('categories.edit', $category->id) }}">
                                                        <button class="item me-1" data-toggle="tooltip" data-placement="top"
                                                            title="Edit">
                                                            <i class="zmdi zmdi-edit"></i>
                                                        </button>
                                                    </a>
                                                    {{-- Delete button  --}}
                                                    <a href="{{ route('categories.delete', $category->id) }}">
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
                                </tbody>
                            </table>
                        </div>
                    @else
                        <h3 class="text-secondary text-center mt-5">There is no categorry here...</h3>
                    @endif

                    <div class="mt-3">
                        {{-- {{ $categories->appends(request()->query())->links() }} --}}
                        {{ $categories->links() }}
                    </div>
                    <!-- END DATA TABLE -->
                </div>
            </div>
        </div>
    </div>
@endsection
