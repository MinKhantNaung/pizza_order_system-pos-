@extends('admin.layouts.master')

@section('title', 'Orders List Page')
@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <form action="{{ route('orders.status') }}" method="GET" class="col-md-5">

                        @csrf
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-database me-2"></i>
                            {{ $orders->count() }}</span>
                            <select name="status" class="form-select" id="inputGroupSelect04"
                                aria-label="Example select with button addon">
                                <option value="">All</option>
                                <option value="0" class="text-warning"
                                    @if (request()->status == '0') selected @endif>
                                    Pending</option>
                                <option value="1" class="text-success"
                                    @if (request()->status == '1') selected @endif>
                                    Accept</option>
                                <option value="2" class="text-danger"
                                    @if (request()->status == '2') selected @endif>
                                    Reject</option>
                            </select>
                            <button type="submit" class="btn btn-sm btn-dark"><i class="fa-solid fa-magnifying-glass me-2"></i>Search</button>
                        </div>
                    </form>

                    <div class="table-responsive table-responsive-data2">
                        <table class="table table-data2">
                            <thead>
                                <tr class="text-uppercase">
                                    <th>Order ID</th>
                                    <th>User Name</th>
                                    <th>Order Date</th>
                                    <th>Order Code</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="dataList">
                                @foreach ($orders as $order)
                                    <tr class="tr-shadow">
                                        <td>{{ $order->id }}
                                            <input type="hidden" class="orderId" value="{{ $order->id }}">
                                        </td>
                                        <td>{{ $order->user_name }}</td>
                                        <td>{{ $order->created_at->format('F-j-Y') }}</td>
                                        <td>
                                            <a href="{{ route('orders.listInfo', $order->order_code) }}">{{ $order->order_code }}</a>
                                        </td>
                                        <td class="amount">{{ $order->total_price }} kyats</td>
                                        <td>
                                            <select name="status" class="form-select statusChange">
                                                <option value="0" class="text-warning"
                                                    @if ($order->status == 0) selected @endif>Pending</option>
                                                <option value="1" class="text-success"
                                                    @if ($order->status == 1) selected @endif>Accept</option>
                                                <option value="2" class="text-danger"
                                                    @if ($order->status == 2) selected @endif>Reject</option>
                                            </select>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // when change order status
            $('.statusChange').change(function() {
                $currentStatus = $(this).val();

                $parentNode = $(this).parents('tr');
                $orderId = $parentNode.find('.orderId').val();

                $data = {
                    'status': $currentStatus,
                    'orderId': $orderId,
                };

                $.ajax({
                    type: 'get',
                    url: '/orders/ajax/change-status',
                    data: $data,
                    dataType: 'json',
                })
            })
        })
    </script>
@endsection
