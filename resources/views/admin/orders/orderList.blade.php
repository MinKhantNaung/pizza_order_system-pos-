@extends('admin.layouts.master')

@section('title', 'Orders List Page')
@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <div class="table-responsive table-responsive-data2">
                        <a href="{{ route('orders.list') }}" class="btn btn-secondary btn-sm"><i
                                class="fa-solid fa-arrow-left-long mx-2"></i> back</a>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="card mt-4">
                                    <div class="card-body">
                                        <h3 class="card-title py-3 mb-3 border-bottom border-dark"><i class="fa-solid fa-clipboard me-3"></i>Order Info <br>
                                            <small class="text-warning fs-6"><i class="fa-solid fa-triangle-exclamation me-3"></i>Include Delivery Charges</small>
                                        </h3>
                                        <div class="row mb-2">
                                            <div class="col"><i class="fa-solid fa-user me-3"></i>Name</div>
                                            <div class="col"> {{ strtoupper($orders[0]->user_name) }}</div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col"><i class="fa-solid fa-barcode me-3"></i> Order Code</div>
                                            <div class="col"> {{ $orders[0]->order_code }}</div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col"><i class="fa-regular fa-clock me-3"></i> Order Date</div>
                                            <div class="col">{{ $orders[0]->created_at->format('F-j-Y') }}</div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col"><i class="fa-solid fa-money-bill-wave me-3"></i> Total</div>
                                            <div class="col">{{ $order->total_price }} kyats</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <table class="table table-data2">
                            <thead>
                                <tr class="text-uppercase">
                                    <th></th>
                                    <th>Order ID</th>
                                    <th>Product Image</th>
                                    <th>Product Name</th>
                                    <th>Order Date</th>
                                    <th>Qty</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody id="dataList">
                                @foreach ($orders as $order)
                                    <tr class="tr-shadow">
                                        <td></td>
                                        <td>{{ $order->id }}</td>
                                        <td class="col-2">
                                            <img src="{{ asset("storage/$order->product_image") }}" alt="image"
                                                class="img-thumbnail img-fluid object-fit-cover">
                                        </td>
                                        <td>{{ $order->product_name }}</td>
                                        <td>{{ $order->created_at->format('F-j-Y') }}</td>
                                        <td>{{ $order->qty }}</td>
                                        <td>{{ $order->total }}</td>
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
