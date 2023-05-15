@extends('user.layouts.master')

@section('title', 'Online Shop')
@section('content')

    <!-- Cart Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                <table class="table table-light table-borderless table-hover text-center mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th></th>
                            <th>Products</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle" id="dataTable">
                        @foreach ($cartList as $cart)
                            <tr>
                                {{-- <input type="hidden" value="{{ $cart->pizza_price }}" id="pizzaPrice"> --}}
                                <td class="align-middle"><img src="{{ asset('storage/' . $cart->pizza_image) }}"
                                        alt="pizza image" class="img-thumbnail shadow-sm" style="width: 100px;"></td>
                                <td class="align-middle">
                                    {{ $cart->pizza_name }}
                                    <input type="hidden" value="{{ $cart->id }}" class="orderId">
                                    <input type="hidden" value="{{ $cart->user_id }}" class="userId">
                                    <input type="hidden" value="{{ $cart->product_id }}" class="productId">
                                </td>
                                <td class="align-middle" id="pizzaPrice">{{ $cart->pizza_price }} kyats</td>
                                <td class="align-middle">
                                    <div class="input-group quantity mx-auto" style="width: 100px;">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-primary btn-minus">
                                                <i class="fa fa-minus text-white"></i>
                                            </button>
                                        </div>
                                        <input type="text" class="form-control form-control-sm border-0 text-center"
                                            value="{{ $cart->qty }}" id="qty">

                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-primary btn-plus">
                                                <i class="fa fa-plus text-white"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle" id="total">{{ $cart->pizza_price * $cart->qty }} kyats</td>
                                <td class="align-middle"><button class="btn btn-sm btn-danger btnRemove"><i
                                            class="fa fa-times"></i></button></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-lg-4">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="pr-3">Cart
                        Summary</span></h5>
                <div class="bg-light p-30 mb-5">
                    <div class="border-bottom pb-2">
                        <div class="d-flex justify-content-between mb-3">
                            <h6>Subtotal</h6>
                            <h6 id="subTotalPrice">{{ $totalPrice }} kyats</h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Delivery</h6>
                            <h6 class="font-weight-medium">3000 kyats</h6>
                        </div>
                    </div>
                    <div class="pt-2">
                        <div class="d-flex justify-content-between mt-2">
                            <h5>Total</h5>
                            <h5 id="finalPrice">{{ $totalPrice + 3000 }} kyats</h5>
                        </div>
                        <button class="btn btn-block btn-primary text-white font-weight-bold my-3 py-3" id="orderBtn">
                            <span class="text-white">Proceed To Checkout</span>
                        </button>
                        <button class="btn btn-block btn-danger text-white font-weight-bold my-3 py-3" id="clearBtn">
                            <span class="text-white">Clear Cart</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->

@endsection

@section('scriptSource')
    <script>
        {{-- For Click '+, -, cross' and calculate total --}}
        $(document).ready(function() {
            {{-- when click + button  --}}
            $('.btn-plus').click(function() {
                $parentNode = $(this).parents("tr");
                $price = Number($parentNode.find('#pizzaPrice').text().replace('kyats', ''));
                $qty = Number($parentNode.find('#qty').val());
                $total = $price * $qty;
                $parentNode.find('#total').html($total + ' kyats');

                summaryCalculation();
            })

            {{-- when click - button --}}
            $('.btn-minus').click(function() {
                $parentNode = $(this).parents("tr");
                $price = Number($parentNode.find('#pizzaPrice').text().replace('kyats', ''));
                $qty = Number($parentNode.find('#qty').val());
                $total = $price * $qty;
                $parentNode.find('#total').html($total + ' kyats');

                summaryCalculation();
            })

            {{-- when click cross button --}}
            $('.btnRemove').click(function() {
                $parentNode = $(this).parents('tr');
                $productId = $parentNode.find('.productId').val();
                $orderId = $parentNode.find('.orderId').val();

                $.ajax({
                    type: 'get',
                    url: '/users/ajax/clear-current-product',
                    data: {
                        'product_id': $productId,
                        'order_id': $orderId
                    },
                    dataType: 'json',
                })

                $parentNode.remove();

                summaryCalculation();
            })

            {{-- to calculate final price --}}

            function summaryCalculation() {
                $totalPrice = 0;
                {{-- to get rows | looping with .each() --}}
                $("#dataTable tr").each(function(index, row) {
                    $totalPrice += Number($(row).find('#total').text().replace('kyats', ''));
                });
                $('#subTotalPrice').html(`${$totalPrice} kyats`);

                $('#finalPrice').html(`${$totalPrice + 3000} kyats`);
            }
        })

        {{-- For finally proceed order button --}}
        $(document).ready(function() {
            $('#orderBtn').click(function() {

                $orderList = [];

                $random = Math.floor(Math.random() * 10000000000);

                $("#dataTable tr").each(function(index, row) {
                    $orderList.push({
                        'user_id': $(row).find('.userId').val(),
                        'product_id': $(row).find('.productId').val(),
                        'qty': $(row).find('#qty').val(),
                        'total': $(row).find('#total').text().replace('kyats', '') * 1,
                        'order_code': 'pos' + $random,
                    })
                });

                $.ajax({
                    type: 'get',
                    url: '/users/ajax/order',
                    data: Object.assign({}, $orderList),
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 'true') {
                            window.location.href = "/users/home";
                        }
                    }
                })
            })

            {{-- For click clear button --}}
            $('#clearBtn').click(function() {
                $('#dataTable tr').remove();
                $('#subTotalPrice').html('0 kyats');
                $('#finalPrice').html('3000 kyats');

                $.ajax({
                    type: 'get',
                    url: '/users/ajax/clear-cart',
                    dataType: 'json',
                })
            })
        })
    </script>
@endsection
