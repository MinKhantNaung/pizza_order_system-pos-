@extends('admin.layouts.master')

@section('title', 'Users List Page')
@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">

                    @if (session('successMsg'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>{{ session('successMsg') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive table-responsive-data2">
                        <table class="table table-data2">
                            <h3>Total - {{ $users->total() }}</h3>
                            <thead>
                                <tr class="text-uppercase">
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Gender</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Role</th>
                                </tr>
                            </thead>
                            <tbody id="dataList">
                                @foreach ($users as $user)
                                    <tr>
                                        <td class="col-2">
                                            @if ($user->image == null)
                                                @if ($user->gender == 'male')
                                                    <img src="{{ asset('image/default_male.jpg') }}" alt="default image"
                                                        class="img-thumbnail w-100 shadow-sm">
                                                @else
                                                    <img src="{{ asset('image/default_female.jpg') }}" alt="default image"
                                                        class="img-thumbnail w-100 shadow-sm">
                                                @endif
                                            @else
                                                <img src="{{ asset('storage/' . $user->image) }}" alt="User name"
                                                    class="img-thumbnail shadow-sm w-100" />
                                            @endif
                                        </td>
                                        <td>{{ $user->name }}
                                            <input type="hidden" id="userId" value="{{ $user->id }}">
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->gender }}</td>
                                        <td>{{ $user->phone }}</td>
                                        <td>{{ $user->address }}</td>
                                        <td>
                                            <div class="table-data-feature">
                                                <select name="" class="me-2 badge bg-secondary statusChange">
                                                    <option value="user"
                                                        @if ($user->role == 'user') selected @endif>
                                                        User</option>
                                                    <option value="admin"
                                                        @if ($user->role == 'admin') selected @endif>
                                                        Admin</option>
                                                </select>
                                                <a href="{{ route('admin.userDelete', $user->id) }}">
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
                        <div>
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            {{-- when click statusChange to change role --}}
            $('.statusChange').change(function() {
                $currentStatus = $(this).val();
                $parentNode = $(this).parents('tr');
                $userId = $parentNode.find('#userId').val();

                $data = {
                    'userId': $userId,
                };

                $.ajax({
                    type: "get",
                    url: "/users/ajax/change-role",
                    data: $data,
                    dataType: "json",
                });

                location.reload();
            })
        })
    </script>

@endsection
