@extends('admin.layouts.master')

@section('title', 'Admin List Page')
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
                                <h2 class="title-1">Admin List</h2>

                            </div>
                        </div>
                        <div class="table-data__tool-right">
                            <a href="{{ route('categories.createPage') }}">
                                <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                    <i class="zmdi zmdi-plus"></i>Add Category
                                </button>
                            </a>
                            <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                CSV download
                            </button>
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
                            <form action="{{ route('admin.list') }}" method="GET">
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
                            <i class="fa-solid fa-database"></i> {{ $admins->total() }}
                        </h4>
                    </div>

                    {{-- @if (count($categories) != '0') --}}
                    <div class="table-responsive table-responsive-data2">
                        <table class="table table-data2">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Gender</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($admins as $admin)
                                    <tr class="tr-shadow">
                                        <td class="col-2">
                                            @if ($admin->image == null)
                                                @if ($admin->gender == 'male')
                                                    <img src="{{ asset('image/default_male.jpg') }}" alt="default image"
                                                        class="img-thumbnail w-100">
                                                @else
                                                    <img src="{{ asset('image/default_female.jpg') }}" alt="default image"
                                                        class="img-thumbnail w-100">
                                                @endif
                                            @else
                                                <img src="{{ asset("storage/$admin->image") }}" alt="admin image"
                                                    class="img-thumbnail w-100">
                                            @endif
                                        </td>
                                        <td>{{ $admin->name }}
                                            <input type="hidden" value="{{ $admin->id }}" id="userId">
                                        </td>
                                        <td>{{ $admin->email }}</td>
                                        <td>{{ $admin->gender }}</td>
                                        <td>{{ $admin->phone }}</td>
                                        <td>{{ $admin->address }}</td>
                                        <td>
                                            <div class="table-data-feature">
                                                @if (Auth::user()->id == $admin->id)
                                                @else

                                                    <select class="badge bg-secondary me-2 changeRole">
                                                        <option value="admin" @selected($admin->role == 'admin')>Admin</option>
                                                        <option value="user" @selected($admin->role == 'user')>User</option>
                                                    </select>

                                                    <a href="{{ route('admin.delete', $admin->id) }}">
                                                        <button class="item" data-toggle="tooltip" data-placement="top"
                                                            title="Delete"
                                                            onclick="return confirm('Are you sure you want to delete?')">
                                                            <i class="zmdi zmdi-delete"></i>
                                                        </button>
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{-- @else
                        <h3 class="text-secondary text-center mt-5">There is no categorry here...</h3>
                    @endif --}}

                    <div class="mt-3">
                        {{ $admins->links() }}
                    </div>
                    <!-- END DATA TABLE -->
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('.changeRole').change(function() {
                $parentNode = $(this).parents('tr');
                $userId = $parentNode.find('#userId').val();

                $.ajax({
                    type: "get",
                    url: "/admin/change-role",
                    data: {'userId': $userId},
                    dataType: "json",
                });

                location.reload();
            })
        })
    </script>
@endsection
