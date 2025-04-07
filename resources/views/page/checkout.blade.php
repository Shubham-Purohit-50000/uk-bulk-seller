@extends('layout.app')
@section('title','Checkout')
@section('content')
<!-- page-title -->
<div class="page-title" style="background-image: url(images/section/page-title.jpg);">
    <div class="container">
        <h3 class="heading text-center">Checkout Page</h3>
        <ul class="breadcrumbs d-flex align-items-center justify-content-center">
            <li><a class="link" href="index.html">Homepage</a></li>
            <li><i class="icon-arrRight"></i></li>
            <li><a class="link" href="shop-default-grid.html">Shop</a></li>
            <li><i class="icon-arrRight"></i></li>
            <li>Shopping Cart</li>
        </ul>
    </div>
</div>
<!-- /page-title -->

<!-- Section cart -->
<section class="flat-spacing">
    <div class="container">
        <div class="row">
            <div class="col-xl-8">
                @php
                    $store = session('store');
                    $total_price = 0;
                @endphp
                @if($store)
                <div class="tf-cart-sold">
                    <div class="notification-sold bg-surface">
                        <img class="icon" src="{{asset('frontend/images/logo/icon-fire.png')}}" alt="img">
                        <div class="count-text my-capitalize">
                            <h5>Checkout for : {{ $store->name }}</h5>
                        </div>  
                    </div>
                    <div class="notification-progress">
                        <div class="text">Buy <span class="fw-semibold text-primary">$70.00</span> more to get <span class="fw-semibold">Freeship</span></div>
                        <div class="progress-cart">
                            <div class="value" style="width: 0%;" data-progress="50">
                                <span class="round"></span>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                <form action="{{url('order')}}" method="post" id="checkout_product_list_form">
                    @csrf
                    <table class="tf-table-page-cart">
                        <thead>
                            <tr>
                                <th>Products</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total Price</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        @if(isset($cart))
                        @php
                            $cart_items = $cart->cartItems;
                        @endphp
                        @foreach ($cart_items as $item)
                            @php
                                $price =  $item->price;
                                $total_price += $price * $item->quantity;
                            @endphp
                            <input type="hidden" name="action" value="cart">
                            <input type="hidden" name="cart_id" value="{{$cart->id}}">
                            <tr class="tf-cart-item file-delete">
                                <td class="tf-cart-item_product">
                                    <a href="#" class="img-box">
                                        <img src="{{asset('storage/' . $item->product->image[0])}}" alt="product">
                                    </a>
                                    <p>{{$item->product->name}}</p>
                                </td>
                                
                                <td data-cart-title="Price" class="tf-cart-item_price text-center">
                                    <div class="cart-price text-button price-on-sale">${{$price}}</div>
                                    @if(auth()->user()->hasRole('relational-manager'))
                                    <div class="d-flex align-items-center gap-2" style="justify-content: center;">
                                        <input type="number" class="form-control" data-item-id="{{$item->id}}" name="new_price" style="width: 40%; padding:0 0 0 10px;">
                                        <button class="btn btn-sm btn-success check_price">Apply</button>
                                    </div>
                                    @endif
                                </td>
                                <td data-cart-title="Quantity" class="tf-cart-item_quantity text-center">
                                    <div class="cart-total text-button">{{$item->quantity}}</div>
                                    <input type="hidden" class="quantity-product" name="quantity" value="{{$item->quantity}}">
                                </td>
                                <td data-cart-title="Total" class="tf-cart-item_total text-center">
                                    <div class="cart-total text-button total-price">${{$price * $item->quantity}}</div>
                                    <span class="d-none item_total_p">{{$price * $item->quantity}}</span>
                                </td>
                                <td data-cart-title="Remove" class="remove-cart">
                                    <span class="remove icon icon-close" data-cart_id="{{$item->id}}"></span>
                                </td>
                            </tr>
                            @endforeach
                            @elseif (isset($product))
                            @php
                                $price =  App\Http\Controllers\UserController::getProductPriceForUser($product->id);
                                $total_price = $price;
                            @endphp
                            <input type="hidden" name="action" value="direct">
                            <input type="hidden" name="product_id" value="{{$product->id}}">
                            <tr class="tf-cart-item file-delete">
                                <td class="tf-cart-item_product">
                                    <a href="product-detail.html" class="img-box">
                                        <img src="{{asset('storage/' . $product->image[0])}}" alt="product">
                                    </a>
                                </td>
                                <td data-cart-title="Price" class="tf-cart-item_price text-center">
                                    <div class="cart-price text-button price-on-sale">${{$price}}</div>
                                </td>
                                <td data-cart-title="Quantity" class="tf-cart-item_quantity">
                                    <div class="wg-quantity mx-md-auto">
                                        <span class="btn-quantity btn-decrease">-</span>
                                        <input type="text" class="quantity-product" name="quantity" value="1">
                                        <span class="btn-quantity btn-increase">+</span>
                                    </div>
                                </td>
                                <td data-cart-title="Total" class="tf-cart-item_total text-center">
                                    <div class="cart-total text-button total-price">${{$price}}</div>
                                    <span class="d-none item_total_p">{{$price}}</span>
                                </td>
                                <td data-cart-title="Remove" class="remove-cart"><span class="remove icon icon-close"></span></td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </form>
            </div>
            <div class="col-xl-4">
                <div class="fl-sidebar-cart">
                    <div class="box-order bg-surface">
                        <h5 class="title">Order Summary</h5>
                        <div class="subtotal text-button d-flex justify-content-between align-items-center">
                            <span>Subtotal</span>
                            <span class="total">{{$total_price}}</span>
                        </div>
                        <div class="discount text-button d-flex justify-content-between align-items-center">
                            <span>Discounts</span>
                            <span class="total">-$80.00</span>
                        </div>
                        <div class="ship">
                            <span class="text-button">Shipping</span>
                            <div class="flex-grow-1">
                                <fieldset class="ship-item">
                                    <input type="radio" name="ship-check" class="tf-check-rounded" id="free" checked>
                                    <label for="free">
                                        <span>Free Shipping</span>
                                        <span class="price">$0.00</span>
                                    </label>
                                </fieldset>
                                <fieldset class="ship-item">
                                    <input type="radio" name="ship-check" class="tf-check-rounded" id="local">
                                    <label for="local">
                                        <span>Local:</span>
                                        <span class="price">$35.00</span>
                                    </label>
                                </fieldset>
                                <fieldset class="ship-item">
                                    <input type="radio" name="ship-check" class="tf-check-rounded" id="rate">
                                    <label for="rate">
                                        <span>Flat Rate:</span>
                                        <span class="price">$35.00</span>
                                    </label>
                                </fieldset>
                            </div>
                        </div>
                        <h5 class="total-order d-flex justify-content-between align-items-center">
                            <span>Total</span>
                            <span class="total gross">{{$total_price}}</span>
                        </h5>
                        <div class="box-progress-checkout">
                            <fieldset class="check-agree">
                                <input type="checkbox" id="check-agree" class="tf-check-rounded">
                                <label for="check-agree">
                                    I agree with the <a href="term-of-use.html">terms and conditions</a>
                                </label>
                            </fieldset>
                            <button class="tf-btn btn-reset" id="checkout_product_list_form_submit_btn">Process To Checkout</button>
                            <p class="text-button text-center">Or continue shopping</p>
                        </div>  
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /Section cart -->
    @section('script')
    <script>
    $(document).ready(function () {
        $("#checkout_product_list_form_submit_btn").on("click", function (e) {
            e.preventDefault(); // Prevent default button action (if necessary)
            $("#checkout_product_list_form").submit(); // Submit the form manually
        });
    });
    </script>
    @endsection
@endsection