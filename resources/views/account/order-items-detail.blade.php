@extends('layout.app')
@section('title','My Account')
@section('content')
<!-- page-title -->
<div class="page-title" style="background-image: url(frontend/images/section/page-title.jpg);">
    <div class="container-full">
        <div class="row">
            <div class="col-12">
                <h3 class="heading text-center">My Account</h3>
                <ul class="breadcrumbs d-flex align-items-center justify-content-center">
                    <li>
                        <a class="link" href="index.html">Homepage</a>
                    </li>
                    <li>
                        <i class="icon-arrRight"></i>
                    </li>
                    <li>
                        <a class="link" href="#">Pages</a>
                    </li>
                    <li>
                        <i class="icon-arrRight"></i>
                    </li>
                    <li>
                        My Account
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- /page-title -->

<div class="btn-sidebar-account">
    <button data-bs-toggle="offcanvas" data-bs-target="#mbAccount"><i class="icon icon-squares-four"></i></button>
</div>

<!-- my-account -->
<section class="flat-spacing">
    <div class="container">
        <div class="my-account-wrap">
            <!-- nav bar -->
            <div class="wrap-sidebar-account">
                <div class="sidebar-account">
                    <div class="account-avatar">
                        <div class="image">
                            <img src="{{asset('frontend/images/avatar/user-account.jpg')}}" alt="">
                        </div>
                        <h6 class="mb_4">{{auth()->user()->name}}</h6>
                        <div class="body-text-1">{{auth()->user()->email}}</div>
                    </div>
                    <ul class="my-account-nav">
                        <li>
                            <span class="my-account-nav-item">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M20 21V19C20 17.9391 19.5786 16.9217 18.8284 16.1716C18.0783 15.4214 17.0609 15 16 15H8C6.93913 15 5.92172 15.4214 5.17157 16.1716C4.42143 16.9217 4 17.9391 4 19V21" stroke="#181818" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M12 11C14.2091 11 16 9.20914 16 7C16 4.79086 14.2091 3 12 3C9.79086 3 8 4.79086 8 7C8 9.20914 9.79086 11 12 11Z" stroke="#181818" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                Account Details
                            </span>
                        </li>
                        <li>
                            <a href="my-account-orders.html" class="my-account-nav-item active">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M16.5078 10.8734V6.36686C16.5078 5.17166 16.033 4.02541 15.1879 3.18028C14.3428 2.33514 13.1965 1.86035 12.0013 1.86035C10.8061 1.86035 9.65985 2.33514 8.81472 3.18028C7.96958 4.02541 7.49479 5.17166 7.49479 6.36686V10.8734M4.11491 8.62012H19.8877L21.0143 22.1396H2.98828L4.11491 8.62012Z" stroke="#181818" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                My Orders
                            </a>
                        </li>
                        <li>
                            <a href="my-account-address.html" class="my-account-nav-item">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M21 10C21 17 12 23 12 23C12 23 3 17 3 10C3 7.61305 3.94821 5.32387 5.63604 3.63604C7.32387 1.94821 9.61305 1 12 1C14.3869 1 16.6761 1.94821 18.364 3.63604C20.0518 5.32387 21 7.61305 21 10Z" stroke="#181818" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M12 13C13.6569 13 15 11.6569 15 10C15 8.34315 13.6569 7 12 7C10.3431 7 9 8.34315 9 10C9 11.6569 10.3431 13 12 13Z" stroke="#181818" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                My Address
                            </a>
                        </li>
                        <li>
                            <a href="{{url('logout')}}" class="my-account-nav-item">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9 21H5C4.46957 21 3.96086 20.7893 3.58579 20.4142C3.21071 20.0391 3 19.5304 3 19V5C3 4.46957 3.21071 3.96086 3.58579 3.58579C3.96086 3.21071 4.46957 3 5 3H9" stroke="#181818" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M16 17L21 12L16 7" stroke="#181818" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M21 12H9" stroke="#181818" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- end nav bar -->
            <!-- my order list -->
            <div class="my-account-content">
                <div class="account-order-details">
                    <div class="wd-form-order">
                        <div class="order-head">
                            <div class="content">
                                <div class="badge">In Progress</div>
                                <h6 class="mt-8 fw-5">Order #{{$order->id}}</h6>
                            </div>
                        </div>
                        <div class="tf-grid-layout md-col-2 gap-15">
                            @if (!auth()->user()->hasRole('complete-franchise'))
                            <div class="item">
                                <div class="text-2 text_black-2">Total Amount</div>
                                <div class="text-2 mt_4 fw-6">{{$order->total_amount}}</div>
                            </div>
                            @endif
                            <div class="item">
                                <div class="text-2 text_black-2">Order Time</div>
                                <div class="text-2 mt_4 fw-6">{{formatDateTime($order->created_at)}}</div>
                            </div>
                            <div class="item">
                                <div class="text-2 text_black-2">Address</div>
                                <div class="text-2 mt_4 fw-6">1234 Fashion Street, Suite 567, New York</div>
                            </div>
                        </div>
                        <div class="widget-tabs style-3 widget-order-tab">
                            <ul class="widget-menu-tab">
                                <li class="item-title active">
                                    <span class="inner">Item Details</span>
                                </li>
                                <li class="item-title">
                                    <span class="inner">Order History</span>
                                </li>
                                <li class="item-title">
                                    <span class="inner">Courier</span>
                                </li>
                                <li class="item-title">
                                    <span class="inner">Receiver</span>
                                </li>
                            </ul>
                            <div class="widget-content-tab">
                                <div class="widget-content-inner active">
                                    @foreach ($order->orderItems as $item)
                                    <div class="order-item">
                                        <div class="text-2 fw-6">{{$item->product->name}}</div>
                                        <div class="order-head">
                                            
                                            <figure class="img-product">
                                                <img src="{{asset('storage/' . $item->product->image[0])}}" alt="product">
                                            </figure>
                                            <div class="content">
                                                @if (!auth()->user()->hasRole('complete-franchise'))
                                                <div class="mt_4"><span class="fw-6">Price :</span> ${{$item->price}}</div>
                                                <div class="mt_4"><span class="fw-6">Quantity :</span> {{$item->quantity}}</div>
                                                <div class="mt_4"><span class="fw-6">Total :</span> ${{$item->total}}</div>
                                                @else
                                                <div class="mt_4"><span class="fw-6">Quantity :</span> {{$item->quantity}}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="widget-content-inner">
                                    <div class="widget-timeline">
                                        <ul class="timeline">
                                            <li>
                                                <div class="timeline-badge success"></div>
                                                <div class="timeline-box">
                                                    <a class="timeline-panel" href="javascript:void(0);">
                                                        <div class="text-2 fw-6">Product Shipped</div>
                                                        <span>10/07/2024 4:30pm</span>
                                                    </a>
                                                    <p><strong>Courier Service : </strong>FedEx World Service Center</p>
                                                    <p><strong>Estimated Delivery Date : </strong>12/07/2024</p>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="timeline-badge success"></div>
                                                <div class="timeline-box">
                                                    <a class="timeline-panel" href="javascript:void(0);">
                                                        <div class="text-2 fw-6">Product Shipped</div>
                                                        <span>10/07/2024 4:30pm</span>
                                                    </a>
                                                    <p><strong>Tracking Number : </strong>2307-3215-6759</p>
                                                    <p><strong>Warehouse : </strong>T-Shirt 10b</p>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="timeline-badge"></div>
                                                <div class="timeline-box">
                                                    <a class="timeline-panel" href="javascript:void(0);">
                                                        <div class="text-2 fw-6">Product Packaging</div>
                                                        <span>12/07/2024 4:34pm</span>
                                                    </a>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="timeline-badge"></div>
                                                <div class="timeline-box">
                                                    <a class="timeline-panel" href="javascript:void(0);">
                                                        <div class="text-2 fw-6">Order Placed</div>
                                                        <span>11/07/2024 2:36pm</span>
                                                    </a>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="widget-content-inner">
                                    <p>Our courier service is dedicated to providing fast, reliable, and secure delivery solutions tailored to meet your needs. Whether you're sending documents, parcels, or larger shipments, our team ensures that your items are handled with the utmost care and delivered on time. With a commitment to customer satisfaction, real-time tracking, and a wide network of routes, we make it easy for you to send and receive packages both locally and internationally. Choose our service for a seamless and efficient delivery experience.</p>
                                </div>
                                <div class="widget-content-inner">
                                    <p class="text-2 text-success">Thank you Your order has been received</p>
                                    <ul class="mt_20">
                                        <li>Order Number : <span class="fw-7">#17493</span></li>
                                        <li>Date : <span class="fw-7"> 17/07/2024, 02:34pm</span></li>
                                        <li>Total : <span class="fw-7">$18.95</span></li>
                                        <li>Payment Methods : <span class="fw-7">Cash on Delivery</span></li>

                                    </ul>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
             <!-- my order list end -->
        </div>
    </div>
</section>
<!-- /my-account -->
@endsection