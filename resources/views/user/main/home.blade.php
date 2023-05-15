@extends('user.layouts.master')

@section('title', 'Online Shop')
@section('content')

    <!-- Shop Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <!-- Shop Sidebar Start -->
            <div class="col-lg-3 col-md-4">
                <!-- Price Start -->
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="pe-3">Filter by
                        categories</span></h5>
                <div class="bg-light p-4 mb-30">
                    <form>
                        <div class="d-flex align-items-center justify-content-between mb-3 bg-dark text-white px-3 pt-1">
                            {{-- <input type="checkbox" class="input" checked id="price-all"> --}}
                            <label class="mt-2" for="price-all">Categories</label>
                            <span class="badge bg-warning rounded-pill text-dark">{{ $categories->count() }}</span>
                        </div>
                        <hr>
                        <div class="custom-checkbox d-flex align-items-center justify-content-between pt-1">
                            <a href="{{ route('users.home') }}" class="text-black"><label class=""
                                    for="price-5">All</label></a>
                        </div>
                        @foreach ($categories as $category)
                            <div class="custom-checkbox d-flex align-items-center justify-content-between pt-1">
                                <a href="{{ route('users.filter', $category->id) }}" class="text-black"><label
                                        class="" for="price-5">{{ $category->name }}</label></a>
                            </div>
                        @endforeach
                    </form>
                </div>
                <!-- Price End -->

                <div class="">
                    <button class="btn btn btn-warning w-100">Order</button>
                </div>

            </div>
            <!-- Shop Sidebar End -->


            <!-- Shop Product Start -->
            <div class="col-lg-9 col-md-8">
                <div class="row pb-3">
                    <div class="col-12 pb-1">
                        <div class="d-flex align-items-center justify-content-between my-4">
                            <div>
                                <a href="{{ route('user.cartList') }}">
                                    <button type="button" class="btn btn-dark position-relative">
                                        <i class="fa-solid fa-cart-plus"></i>
                                        <span
                                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                            {{ $carts->count() }}
                                        </span>
                                    </button>
                                </a>
                                <a href="{{ route('user.history') }}" class="ms-3">
                                    <button type="button" class="btn btn-dark position-relative">
                                        <i class="fa-solid fa-clock-rotate-left"></i>
                                        <span
                                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                            {{ $history->count() }}
                                        </span>
                                    </button>
                                </a>
                            </div>
                            <div class="ml-2">
                                <div class="btn-group">
                                    <select name="" id="sortingOption" class="form-select">
                                        <option value="">Choose option...</option>
                                        <option value="asc">Ascending</option>
                                        <option value="desc">Descending</option>
                                    </select>
                                </div>
                                {{-- <div class="btn-group ml-2">
                                    <button type="button" class="btn btn-sm btn-light dropdown-toggle"
                                        data-toggle="dropdown">Showing</button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#">10</a>
                                        <a class="dropdown-item" href="#">20</a>
                                        <a class="dropdown-item" href="#">30</a>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>

                    <div class="row" id="datalist">
                        @if ($pizzas->count() != 0)
                            @foreach ($pizzas as $pizza)
                                <div class="col-lg-4 col-md-6 col-sm-6 col-12 pb-1">
                                    <div class="product-item bg-light mb-4" id="myForm">
                                        <div class="product-img position-relative overflow-hidden">
                                            <img class="img-fluid w-100 object-fit-cover"
                                                src="{{ asset('storage/' . $pizza->image) }}" alt="pizza image"
                                                style="height: 200px">
                                            <div class="product-action">
                                                <a class="btn btn-outline-dark btn-square"
                                                    href="{{ route('users.pizzaDetails', $pizza->id) }}"><i
                                                        class="fa-solid fa-circle-info"></i></a>
                                            </div>
                                        </div>
                                        <div class="text-center py-4">
                                            <span class="h6 text-decoration-none text-truncate text-primary"
                                                href="">{{ $pizza->name }}</span>
                                            <div class="d-flex align-items-center justify-content-center mt-2">
                                                <h5>{{ $pizza->price }} Ks</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="col-6 offset-3 shadow text-black text-center fs-1 py-5">There is no pizzas<i
                                    class="fa-solid fa-pizza-slice ms-3"></i></p>
                        @endif
                    </div>

                </div>
            </div>
            <!-- Shop Product End -->
        </div>
    </div>
    <!-- Shop End -->

@endsection

@section('scriptSource')
    <script>
        $(document).ready(function() {

            $('#sortingOption').change(function() {
                $eventOption = $('#sortingOption').val();

                if ($eventOption == 'asc') {
                    $.ajax({
                        type: 'get',
                        url: '/users/ajax/pizza/list',
                        data: {
                            'status': 'asc'
                        },
                        dataType: 'json',
                        success: function(response) {
                            $list = '';
                            for ($i = 0; $i < response.length; $i++) {
                                $list += ` <div class="col-lg-4 col-md-6 col-sm-6 col-12 pb-1">
        <div class="product-item bg-light mb-4" id="myForm">
            <div class="product-img position-relative overflow-hidden">
                <img class="img-fluid w-100 object-fit-cover" src="{{ asset('storage/${response[$i].image}') }}"
                    alt="pizza image" style="height: 200px">
                <div class="product-action">
                    <a class="btn btn-outline-dark btn-square" href=""><i class="fa-solid fa-circle-info"></i></a>
                </div>
            </div>
            <div class="text-center py-4">
                <span class="h6 text-decoration-none text-truncate text-primary">${response[$i].name}</span>
                <div class="d-flex align-items-center justify-content-center mt-2">
                    <h5>${response[$i].price} Ks</h5>
                </div>
            </div>
        </div>
        </div>
        `;

                                $('#datalist').html($list);
                            }
                        }
                    })
                } else if ($eventOption == 'desc') {
                    $.ajax({
                        type: 'get',
                        url: '/users/ajax/pizza/list',
                        data: {
                            'status': 'desc'
                        },
                        dataType: 'json',
                        success: function(response) {
                            $list = '';
                            for ($i = 0; $i < response.length; $i++) {
                                $list += ` <div class="col-lg-4 col-md-6 col-sm-6 col-12 pb-1">
            <div class="product-item bg-light mb-4" id="myForm">
                <div class="product-img position-relative overflow-hidden">
                    <img class="img-fluid w-100 object-fit-cover" src="{{ asset('storage/${response[$i].image}') }}" alt="pizza image"
                        style="height: 200px">
                    <div class="product-action">
                        <a class="btn btn-outline-dark btn-square" href=""><i
                                class="fa-solid fa-circle-info"></i></a>
                    </div>
                </div>
                <div class="text-center py-4">
                    <span class="h6 text-decoration-none text-truncate text-primary">${response[$i].name}</span>
                    <div class="d-flex align-items-center justify-content-center mt-2">
                        <h5>${response[$i].price} Ks</h5>
                    </div>
                </div>
            </div>
            </div>
            `;

                                $('#datalist').html($list);
                            }
                        }
                    })
                }
            })
        })
    </script>
@endsection
