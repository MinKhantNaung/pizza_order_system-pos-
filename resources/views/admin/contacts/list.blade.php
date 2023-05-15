@extends('admin.layouts.master')

@section('title', 'Users List Page')
@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <h3>Contacts - {{ $contacts->total() }}</h3>
                    <div>
                        {{ $contacts->links() }}
                    </div>
                    @if (count($contacts) > 0)
                        <div class="table-responsive table-responsive-data2">
                            <table class="table table-data2">
                                {{-- <h3>Total - {{ $users->total() }}</h3> --}}
                                <thead>
                                    <tr class="text-uppercase">
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Message</th>
                                    </tr>
                                </thead>
                                <tbody id="dataList">
                                    @foreach ($contacts as $contact)
                                        <tr>
                                            <td>{{ $contact->id }}</td>
                                            <td>{{ $contact->name }}</td>
                                            <td>{{ $contact->email }}</td>
                                            <td>{{ $contact->message }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div>
                                {{-- {{ $users->links() }} --}}
                            </div>
                        </div>
                    @else
                        <h3 class="text-center text-danger my-5">No Contacts Found...</h3>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
