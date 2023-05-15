@extends('user.layouts.master')

@section('title', 'Online Shop')
@section('content')

    <!-- Cart Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-8 offset-lg-2 table-responsive mb-5">
                <table class="table table-responsive-sm table-light table-borderless table-hover text-center mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th>Date</th>
                            <th>Order Code</th>
                            <th>Total Price</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle" id="dataTable">
                        @foreach ($orders as $order)
                            <tr>
                                <td class="align-middle">{{ $order->created_at->diffForHumans() }}</td>
                                <td class="align-middle">{{ $order->order_code }}</td>
                                <td class="align-middle">{{ $order->total_price }}</td>
                                <td class="align-middle">
                                    @if ($order->status == 0)
                                        <strong class="text-warning"> <i class="fa-regular fa-clock me-2"></i>Pending...</strong>
                                    @elseif ($order->status == 1)
                                        <strong class="text-success" disabled> <i class="fa-solid fa-check me-2"></i>Success</strong>
                                    @elseif ($order->status == 2)
                                        <strong class="text-danger" disabled> <i class="fa-solid fa-triangle-exclamation me-2"></i>Reject</strong>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
                <div class="mt-3">{{ $orders->links() }}</div>
            </div>
        </div>
    </div>
    <!-- Cart End -->

@endsection
