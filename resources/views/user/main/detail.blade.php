@extends('user.layouts.master')

@section('content')
    <!-- Shop Detail Start -->
    <div class="container-fluid pb-5">
        <div class="row px-xl-5">
            <div class="col-lg-5 mb-30">
                <button type="button" onclick="history.back()" class="btn btn-dark btn-sm">
                    <i class="fa-solid fa-left-long me-1"></i> back
                </button>
                <br><br>
                <div id="product-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner bg-light">
                        <div class="carousel-item active">
                            <img class="w-100 h-100" src="{{ asset('storage/' . $pizza->image) }}" alt="Image">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-7 h-auto mb-30">
                <div class="h-100 bg-light p-30">
                    <h3>{{ $pizza->name }}</h3>
                    <div class="d-flex mb-3">
                        {{-- <div class="text-primary mr-2">
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star-half-alt"></small>
                            <small class="far fa-star"></small>
                        </div> --}}
                        <small class="pt-1">{{ $pizza->view_count + 1 }}<i class="fa-regular fa-eye ms-1"></i></small>
                    </div>
                    <h3 class="font-weight-semi-bold mb-4">{{ $pizza->price }} kyats</h3>
                    <p class="mb-4">{{ $pizza->description }}</p>
                    <div class="d-flex align-items-center mb-4 pt-2">
                        <div class="input-group quantity mr-3" style="width: 130px;">
                            <div class="input-group-btn">
                                <button class="btn btn-primary text-white btn-minus">
                                    <i class="fa fa-minus text-white"></i>
                                </button>
                            </div>
                            <input id="orderCount" type="text" class="form-control border-0 text-center" value="1">
                            <div class="input-group-btn">
                                <button class="btn btn-primary text-white btn-plus">
                                    <i class="fa fa-plus text-white"></i>
                                </button>
                            </div>
                        </div>
                        <input type="hidden" value="{{ Auth::user()->id }}" id="userId">
                        <input type="hidden" value="{{ $pizza->id }}" id="pizzaId">
                        <button type="button" id="addCartBtn" class="btn btn-primary text-white px-3"><i
                                class="fa fa-shopping-cart mr-1 text-white"></i><span class="text-white">
                                Add To
                                Cart</span></button>
                    </div>
                    <div class="d-flex pt-2">
                        <strong class="text-dark mr-2">Share on:</strong>
                        <div class="d-inline-flex">
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-pinterest"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Shop Detail End -->


    <!-- Products Start -->
    <div class="container-fluid py-5">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary rounded p-1">You
                May
                Also Like</span></h2>
        <div class="row px-xl-5">
            <div class="col">
                <div class="owl-carousel related-carousel">
                    @foreach ($pizzaList as $pizzaItem)
                        <div class="product-item bg-light">
                            <div class="product-img position-relative overflow-hidden">
                                <img class="img-fluid object-fit-cover w-100" style="height: 200px"
                                    src="{{ asset('storage/' . $pizzaItem->image) }}" alt="image">
                                <div class="product-action">
                                    {{-- <a class="btn btn-outline-dark btn-square" href=""><i
                                            class="fa fa-shopping-cart"></i></a> --}}
                                    <a class="btn btn-outline-dark btn-square"
                                        href="{{ route('users.pizzaDetails', $pizzaItem->id) }}"><i
                                            class="fa-solid fa-circle-info"></i></a>
                                </div>
                            </div>
                            <div class="text-center py-4">
                                <a class="h6 text-decoration-none text-truncate" href="">{{ $pizzaItem->name }}</a>
                                <div class="d-flex align-items-center justify-content-center mt-2">
                                    <h5>{{ $pizzaItem->price }} kyats</h5>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- Products End -->
@endsection

@section('scriptSource')
    <script>
        $(document).ready(function() {

            {{-- increase view count --}}
            $.ajax({
                type: 'get',
                url: '/users/ajax/increase-view-count',
                data: {
                    'pizzaId': $('#pizzaId').val()
                },
                dataType: 'json'
            });

            {{-- add to cart button --}}
            $('#addCartBtn').click(function() {

                $source = {
                    'userId': $('#userId').val(),
                    'pizzaId': $('#pizzaId').val(),
                    'count': $('#orderCount').val(),
                };

                $.ajax({
                    type: 'get',
                    url: '/users/ajax/add-to-cart',
                    data: $source,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 'success') {
                            window.location.href = "/users/home";
                        }
                    }
                })
            })
        })
    </script>
@endsection
