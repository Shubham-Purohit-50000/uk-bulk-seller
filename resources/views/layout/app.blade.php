<!DOCTYPE html>

<!--[if IE 8 ]><html class="ie" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<!--<![endif]-->

<head>
    <meta charset="utf-8">
    <title>@yield('title') | {{ env('APP_NAME') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="{{env('APP_NAME')}}, Multipurpose eCommerce store">

   <!-- font -->
   <link rel="stylesheet" href="{{asset('frontend/fonts/fonts.css')}}">
   <link rel="stylesheet" href="{{asset('frontend/fonts/font-icons.css')}}">
   <link rel="stylesheet" href="{{asset('frontend/css/bootstrap.min.css')}}">
   <link rel="stylesheet" href="{{asset('frontend/css/swiper-bundle.min.css')}}">
   <link rel="stylesheet" href="{{asset('frontend/css/animate.css')}}">
   <link rel="stylesheet" type="text/css" href="{{asset('frontend/css/styles.css')}}"/>
   <link rel="stylesheet" href="{{asset('frontend/css/custom-css.css')}}">

   @yield('css')

   @if (auth()->user() and auth()->user()->hasRole('complete-franchise'))
       <style>
        #shoppingCart .tf-mini-cart-items .tf-mini-cart-info .cart-price{
            display: none;
        }
       </style>
   @endif

    <!-- Favicon and Touch Icons  -->
    <link rel="shortcut icon" href="{{asset('frontend/images/logo/favicon.png')}}">
    <link rel="apple-touch-icon-precomposed" href="{{asset('frontend/images/logo/favicon.png')}}">
    <!-- toaster css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

</head>

<body class="preload-wrapper">
    
    <!-- Scroll Top -->
    <button id="scroll-top">
        <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g clip-path="url(#clip0_15741_24194)">
            <path d="M3 11.9175L12 2.91748L21 11.9175H16.5V20.1675C16.5 20.3664 16.421 20.5572 16.2803 20.6978C16.1397 20.8385 15.9489 20.9175 15.75 20.9175H8.25C8.05109 20.9175 7.86032 20.8385 7.71967 20.6978C7.57902 20.5572 7.5 20.3664 7.5 20.1675V11.9175H3Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </g>
            <defs>
            <clipPath id="clip0_15741_24194">
            <rect width="24" height="24" fill="white" transform="translate(0 0.66748)"/>
            </clipPath>
            </defs>
        </svg> 
    </button>

    <!-- preload -->
    <div class="preload preload-container">
        <div class="preload-logo">
            <div class="spinner"></div>
        </div>
    </div>
    <!-- /preload -->

    <!-- preload -->
    <div class="custom-preload preload-container" style="display:none;">
        <div class="preload-logo">
            <div class="spinner"></div>
        </div>
    </div>
    <!-- /preload -->

    <div id="wrapper">
        <!-- Top Bar -->
        <div class="tf-topbar has-line-bot bg-purple">
            <div class="container">
                <div class="tf-topbar_wrap d-flex align-items-center justify-content-center justify-content-xl-between">
                    <ul class="topbar-left">
                        <li><i class="icon-phone text-white align-middle"></i> <a class="text-caption-1 text-white" href="tel:315-666-6688">000-000-0000</a></li>
                        <li><i class="icon-mail text-white align-middle"></i> <a class="text-caption-1 text-white" href="#">pusupport@gmail.com</a></li>
                    </ul>
                    <!-- <div class="topbar-right d-none d-xl-block">
                        <div class="tf-cur justify-content-end align-items-center gap-24">
                            <p class="text-caption-1 text-white">Order Tracking</p>
                            <div class="tf-currencies">
                                <select class="image-select center style-default type-currencies color-white">
                                    <option selected data-thumbnail="{{asset('frontend/images/country/us.svg')}}">USD</option>
                                    <option data-thumbnail="{{asset('frontend/images/country/vn.svg')}}">VND</option>
                                </select>
                            </div>
                            <div class="tf-languages">
                                <select class="image-select center style-default type-languages color-white">
                                    <option>English</option>
                                    <option>Vietnam</option>
                                </select>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
        <!-- /Top Bar -->

       <!-- Select Business-Customer Modal -->
        <div class="modal fade modal-search" id="near_by_store">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5>Select Store</h5>
                        <span class="icon-close icon-close-popup" data-bs-dismiss="modal"></span>
                    </div>
                    <div class="container">
                        <input type="text" id="search_store" class="form-control" placeholder="Type to search store...">
                        <ul id="store_suggestions" class="list-group mt-2" style="display: none; position: absolute; z-index: 1000; width: 90%;"></ul>
                    </div>
                    <hr>
                    <div class="container-fluid">
                        <form class="form-select-business" method="post" action="{{ url('select-store') }}">
                            @csrf
                            <div id="storeContainer" class="d-flex flex-wrap justify-content-center gap-3 p-3">
                                <!-- Nearby stores will be inserted here -->
                                <span class="text-danger">Wait for auto seach</span>
                            </div>
                            <input type="hidden" name="selected_store" id="selected_store">
                            <div class="view-more-button text-center mt-4">
                                <button type="submit" class="tf-loading btn-loadmore tf-btn btn-reset submit">
                                    <span class="text text-btn text-btn-uppercase">Submit</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal end here -->

        <!-- Header -->
        <header id="header" class="header-default header-style-2 bg-purple header-white">
            <div class="container">
                <div class="row wrapper-header align-items-center">
                    <div class="col-md-4 col-3 d-xl-none">
                        <a href="#mobileMenu" class="mobile-menu" data-bs-toggle="offcanvas" aria-controls="mobileMenu">
                            <i class="icon text-white icon-categories"></i>
                        </a>
                    </div>
                    <div class="col-xxl-5 col-xl-5 d-none d-xl-block">
                        <nav class="box-navigation text-center">
                            <ul class="box-nav-ul d-flex align-items-center">
                                <li class="menu-item active">
                                    <a href="{{url('/')}}" class="item-link">Home</a>
                                </li>
                                <li class="menu-item">
                                    <a href="#shopCategories" class="item-link" data-bs-toggle="offcanvas" aria-controls="shopCategories">Categories</a>
                                </li>
                                <li class="menu-item">
                                    <a href="{{url('shop')}}" class="item-link">Shop</a>
                                </li>
                                <li class="menu-item">
                                    <a href="#" class="item-link">About us</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <div class="col-xl-3 col-md-4 col-6">
                        <a href="{{url('/')}}" class="logo-header">
                            <img src="{{asset('frontend/images/logo/logo-white.png')}}" alt="logo" class="logo">
                        </a>
                    </div>
                    <div class="col-xxl-4 col-xl-4 col-md-4 col-3">
                        <div class="wrapper-header-right">
                            <div class="d-none d-xl-flex box-support">
                                <span class="text-white icon icon-lifebuoy"></span>
                                <div>
                                    <div class="text-title text-white">Hotline: +01 1234 8888</div>
                                    <div class="text-white text-caption-2">24/7 Support Center</div>
                                </div>
                            </div>
                            <ul class="nav-icon d-flex justify-content-end align-items-center">
                                <li class="nav-search d-inline-flex d-xl-nonen"><a href="#search" data-bs-toggle="modal" class="nav-icon-item">
                                    <svg class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M11 19C15.4183 19 19 15.4183 19 11C19 6.58172 15.4183 3 11 3C6.58172 3 3 6.58172 3 11C3 15.4183 6.58172 19 11 19Z" stroke="#181818" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M21.35 21.0004L17 16.6504" stroke="#181818" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                        
                                </a></li>
                                <li class="nav-account">
                                    <a href="#" class="nav-icon-item">
                                        <svg class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M20 21V19C20 17.9391 19.5786 16.9217 18.8284 16.1716C18.0783 15.4214 17.0609 15 16 15H8C6.93913 15 5.92172 15.4214 5.17157 16.1716C4.42143 16.9217 4 17.9391 4 19V21" stroke="#181818" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M12 11C14.2091 11 16 9.20914 16 7C16 4.79086 14.2091 3 12 3C9.79086 3 8 4.79086 8 7C8 9.20914 9.79086 11 12 11Z" stroke="#181818" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </a>
                                    @auth
                                    <div class="dropdown-account dropdown-login">
                                        <div class="sub-bot">
                                            <span class="body-text-">Welcome '{{auth()->user()->name}}'</span>
                                        </div>
                                        <div class="sub-top">
                                            @if (auth()->user() and auth()->user()->hasRole('relational-manager'))
                                                @php
                                                    $attendence = auth()->user()->attendence;
                                                @endphp
                                                @if ($attendence)
                                                    @if ($attendence->check_out == null)
                                                    <!-- Check-out button visible if the user has checked in but not checked out -->
                                                    <a href="{{ url('rm/check-out') }}" class="tf-btn btn-reset">Check-out</a>
                                                    <a href="#near_by_store" data-bs-toggle="modal" class="tf-btn btn-reset">Near Stores</a>
                                                    <!-- <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
                                                    <script>
                                                        // Initialize Pusher
                                                        Pusher.logToConsole = true;
                                                        var pusher = new Pusher("{{env('PUSHER_APP_KEY')}}", {
                                                            cluster: "{{env('PUSHER_APP_CLUSTER')}}",
                                                            encrypted: true,
                                                            authEndpoint: "/broadcasting/auth",
                                                            auth: {
                                                                headers: {
                                                                    Authorization: "Bearer " + localStorage.getItem("auth_token"),
                                                                },
                                                            },
                                                        });

                                                        // Subscribe to the salesman's private channel
                                                        var userId = "{{ auth()->id() }}"; // Get logged-in user ID
                                                        var channel = pusher.subscribe("rm-tracking_" + userId);

                                                        channel.bind("RMLocationUpdated", function (data) {
                                                            console.log("shubham Location Updated:", data);
                                                            
                                                            // Update map or UI
                                                            document.getElementById("latitude").innerText = data.latitude;
                                                            document.getElementById("longitude").innerText = data.longitude;
                                                        });
                                                    </script> -->
                                                    @else
                                                        <button class="tf-btn btn-reset">Day Completed</button>
                                                    @endif
                                                    
                                                @elseif(!$attendence)
                                                    <!-- Display Check-in button if no attendance record exists -->
                                                    <div class="d-flex justify-content-between" style="text-align:center;">
                                                        <a href="{{ url('rm/check-in') }}" class="tf-btn btn-reset d-block" style="padding:12px 20px; width:48%;">Check-in</a>
                                                        <a href="#" class="tf-btn btn-reset d-block" style="padding:12px 20px; width:48%;">Leave</a>
                                                    </div>
                                                @endif
                                            @endif
                                            <a href="{{url('account')}}" class="tf-btn btn-reset">Account</a>
                                            <a href="{{url('my-orders')}}" class="tf-btn btn-reset">Orders</a>
                                            <a href="{{url('logout')}}" class="tf-btn btn-reset">Logout</a>
                                        </div>
                                    </div>
                                    @else
                                    <div class="dropdown-account dropdown-login">
                                        <div class="sub-top">
                                            <a href="{{url('login')}}" class="tf-btn btn-reset">Login</a>
                                            <p class="text-center text-secondary-2">Don’t have an account? <a href="register.html">Register</a></p>
                                        </div>
                                        <div class="sub-bot">
                                            <span class="body-text-">Support</span>
                                        </div>
                                    </div>
                                    @endauth
                                </li>
                                @auth
                                <li class="nav-wishlist"><a href="wish-list.html" class="nav-icon-item">
                                    <svg class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M20.8401 4.60987C20.3294 4.09888 19.7229 3.69352 19.0555 3.41696C18.388 3.14039 17.6726 2.99805 16.9501 2.99805C16.2276 2.99805 15.5122 3.14039 14.8448 3.41696C14.1773 3.69352 13.5709 4.09888 13.0601 4.60987L12.0001 5.66987L10.9401 4.60987C9.90843 3.57818 8.50915 2.99858 7.05012 2.99858C5.59109 2.99858 4.19181 3.57818 3.16012 4.60987C2.12843 5.64156 1.54883 7.04084 1.54883 8.49987C1.54883 9.95891 2.12843 11.3582 3.16012 12.3899L4.22012 13.4499L12.0001 21.2299L19.7801 13.4499L20.8401 12.3899C21.3511 11.8791 21.7565 11.2727 22.033 10.6052C22.3096 9.93777 22.4519 9.22236 22.4519 8.49987C22.4519 7.77738 22.3096 7.06198 22.033 6.39452C21.7565 5.72706 21.3511 5.12063 20.8401 4.60987V4.60987Z" stroke="#181818" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>  
                                    </a>
                                </li>
                                <li class="nav-cart"><a href="#shoppingCart" data-bs-toggle="modal" class="nav-icon-item">
                                    <svg class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M16.5078 10.8734V6.36686C16.5078 5.17166 16.033 4.02541 15.1879 3.18028C14.3428 2.33514 13.1965 1.86035 12.0013 1.86035C10.8061 1.86035 9.65985 2.33514 8.81472 3.18028C7.96958 4.02541 7.49479 5.17166 7.49479 6.36686V10.8734M4.11491 8.62012H19.8877L21.0143 22.1396H2.98828L4.11491 8.62012Z" stroke="#181818" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>  
                                    <span class="count-box">0</span></a>
                                </li>
                                @endauth
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- /Header -->

        <!-- Benefit -->
        <div class="wg-benefit">
            <div class="container">
                <div dir="ltr" class="swiper tf-sw-iconbox" data-preview="4" data-tablet="3" data-mobile-sm="2" data-mobile="1" data-space-lg="60" data-space-md="30" data-space="15" data-pagination="1" data-pagination-sm="2" data-pagination-md="3" data-pagination-lg="4">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="benefit-item">
                                <div class="icon-box"><span class="icon icon-return"></span></div>
                                <p class="text-caption-1">Risk-free shopping with easy returns.</p>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="benefit-item">
                                <div class="icon-box"><span class="icon icon-shipping"></span></div>
                                <p class="text-caption-1">Risk-free shopping with easy returns.</p>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="benefit-item">
                                <div class="icon-box"><span class="icon icon-headset"></span></div>
                                <p class="text-caption-1">24/7 support, always here just for you</p>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="benefit-item">
                                <div class="icon-box"><span class="icon icon-sealCheck"></span></div>
                                <p class="text-caption-1">Risk-free shopping with easy returns.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Benefit -->

        @yield('content')
        
        <!-- Footer -->
        <footer id="footer" class="footer bg-main">
            <div class="footer-wrap">
                <div class="footer-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="footer-infor">
                                    <div class="footer-logo">
                                        <a href="index.html">
                                            <img src="{{asset('frontend/images/logo/logo-white.png')}}" alt="">
                                        </a>
                                    </div>
                                    <div class="footer-address">
                                        <p>549 Oak St.Crystal Lake, IL 60014</p>
                                        <a href="contact.html" class="tf-btn-default style-white fw-6">GET DIRECTION<i class="icon-arrowUpRight"></i></a>
                                    </div>
                                    <ul class="footer-info">
                                        <li>
                                            <i class="icon-mail"></i>
                                            <p>themesflat@gmail.com</p>
                                        </li>
                                        <li>
                                            <i class="icon-phone"></i>
                                            <p>315-666-6688</p>
                                        </li>
                                    </ul>
                                    <ul class="tf-social-icon style-white">
                                        <li><a href="#" class="social-facebook"><i class="icon icon-fb"></i></a></li>
                                        <li><a href="#" class="social-twiter"><i class="icon icon-x"></i></a></li>
                                        <li><a href="#" class="social-instagram"><i class="icon icon-instagram"></i></a></li>
                                        <li><a href="#" class="social-tiktok"><i class="icon icon-tiktok"></i></a></li>
                                        <li><a href="#" class="social-amazon"><i class="icon icon-amazon"></i></a></li>
                                        <li><a href="#" class="social-pinterest"><i class="icon icon-pinterest"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="footer-menu">
                                    <div class="footer-col-block">
                                        <div class="footer-heading text-button footer-heading-mobile">
                                            Infomation
                                        </div>
                                        <div class="tf-collapse-content">
                                            <ul class="footer-menu-list">
                                                <li class="text-caption-1">
                                                    <a href="about-us.html" class="footer-menu_item">About Us</a>
                                                </li>
                                                <li class="text-caption-1">
                                                    <a href="#" class="footer-menu_item">Our Stories</a>
                                                </li>
                                                <li class="text-caption-1">
                                                    <a href="#" class="footer-menu_item">Size Guide</a>
                                                </li>
                                                <li class="text-caption-1">
                                                    <a href="contact.html" class="footer-menu_item">Contact us</a>
                                                </li>
                                                <li class="text-caption-1">
                                                    <a href="#" class="footer-menu_item">Career</a>
                                                </li>
                                                <li class="text-caption-1">
                                                    <a href="my-account.html" class="footer-menu_item">My Account</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="footer-col-block">
                                        <div class="footer-heading text-button footer-heading-mobile">
                                            Customer Services
                                        </div>
                                        <div class="tf-collapse-content">
                                            <ul class="footer-menu-list">
                                                <li class="text-caption-1">
                                                    <a href="#" class="footer-menu_item">Shipping</a>
                                                </li>
                                                <li class="text-caption-1">
                                                    <a href="#" class="footer-menu_item">Return & Refund</a>
                                                </li>
                                                <li class="text-caption-1">
                                                    <a href="#" class="footer-menu_item">Privacy Policy</a>
                                                </li>
                                                <li class="text-caption-1">
                                                    <a href="term-of-use.html" class="footer-menu_item">Terms & Conditions</a>
                                                </li>
                                                <li class="text-caption-1">
                                                    <a href="FAQs.html" class="footer-menu_item">Orders FAQs</a>
                                                </li>
                                                <li class="text-caption-1">
                                                    <a href="wish-list.html" class="footer-menu_item">My Wishlist</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="footer-col-block">
                                    <div class="footer-heading text-button footer-heading-mobile">
                                        Newletter
                                    </div>
                                    <div class="tf-collapse-content">
                                        <div class="footer-newsletter">
                                            <p class="text-caption-1">Sign up for our newsletter and get 10% off your first purchase</p>
                                            <div class="sib-form">
                                                <div id="sib-form-container" class="sib-form-container">
                                                    <div id="error-message" class="sib-form-message-panel">
                                                        <div class="sib-form-message-panel__text sib-form-message-panel__text--center">
                                                            <span class="sib-form-message-panel__inner-text">
                                                                Your subscription could not be saved. Please try again.
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div id="success-message" class="sib-form-message-panel">
                                                        <div class="sib-form-message-panel__text sib-form-message-panel__text--center">
                                                            <span class="sib-form-message-panel__inner-text">
                                                                Your subscription has been successful.
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div id="sib-container" class="sib-container--large sib-container--vertical">
                                                        <form id="sib-form" method="POST" class="form-newsletter style-black"
                                                            action="https://3c02c1a1.sibforms.com/serve/MUIFAOAhSCDRnPhdPWLTpLBkaFR0CvSbJ_okYrjCbXQRLkZZU67Hn2jdn18hTWJuGupI4VUfB4deuJIyP5yRoHWVb9pIrENAMcal9Jtz8q_qN4dpHNMIG454DwSVNVmnLXuePoOCvDqN_Vvs0ga_kzg7ouD63HjCaukRz3LGCQsfnQJBN4-KS2D3DVitqvFsDHSqevjjqLk2xFO4"
                                                            data-type="subscription">
                                                            <div>
                                                                <div class="sib-form-block">
                                                                    <p></p>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <div class="sib-form-block">
                                                                    <div class="sib-text-form-block">
                                                                        <p></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <div class="sib-input sib-form-block">
                                                                    <div class="form__entry entry_block">
                                                                        <div class="form__label-row ">
                                                                            <label class="entry__label" for="EMAIL">
                                                                            </label>
                                                                            <div class="entry__field">
                                                                                <input class="input radius-60" type="text" id="EMAIL" name="EMAIL" autocomplete="off"
                                                                                    placeholder="Enter your e-mail..." data-required="true" required />
                                                                            </div>
                                                                        </div>
                                                                        <label class="entry__error entry__error--primary"></label>
                                                                        <label class="entry__specification">
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <div class="sib-optin sib-form-block">
                                                                    <div class="form__entry entry_mcq">
                                                                        <div class="form__label-row ">
                                                                            <div class="entry__choice">
                                                                                <label>
                                                                                    <input type="checkbox" class="input_replaced" value="1" id="OPT_IN"
                                                                                        name="OPT_IN" />
                                                                                    <span class="checkbox checkbox_tick_positive"></span>
                                                                                    <span>
                                                                                        <p></p>
                                                                                    </span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        <label class="entry__error entry__error--primary">
                                                                        </label>
                                                                        <label class="entry__specification">
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <div class="sib-form-block">
                                                                    <button
                                                                        class="sib-form-block__button sib-form-block__button-with-loader subscribe-button radius-60"
                                                                        form="sib-form" type="submit">
                                                                        <svg class="icon clickable__icon progress-indicator__icon sib-hide-loader-icon"
                                                                            viewBox="0 0 512 512">
                                                                            <path
                                                                                d="M460.116 373.846l-20.823-12.022c-5.541-3.199-7.54-10.159-4.663-15.874 30.137-59.886 28.343-131.652-5.386-189.946-33.641-58.394-94.896-95.833-161.827-99.676C261.028 55.961 256 50.751 256 44.352V20.309c0-6.904 5.808-12.337 12.703-11.982 83.556 4.306 160.163 50.864 202.11 123.677 42.063 72.696 44.079 162.316 6.031 236.832-3.14 6.148-10.75 8.461-16.728 5.01z" />
                                                                        </svg>
                                                                        <i class="icon icon-arrowUpRight"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <input type="text" name="email_address_check" value="" class="input--hidden">
                                                            <input type="hidden" name="locale" value="en">
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tf-cart-checkbox">
                                                <div class="tf-checkbox-wrapp">
                                                    <input class="" type="checkbox" id="footer-Form_agree" name="agree_checkbox">
                                                    <div>
                                                        <i class="icon-check"></i>
                                                    </div>
                                                </div>
                                                <label class="text-caption-1" for="footer-Form_agree">
                                                    By clicking subcribe, you agree to the <a class="fw-6 link" href="term-of-use.html">Terms of Service</a> and <a class="fw-6 link" href="#">Privacy Policy</a>.
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="footer-bottom">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <div class="footer-bottom-wrap">
                                    <div class="left">
                                        <p class="text-caption-1">©2024 Modave. All Rights Reserved.</p>
                                        <div class="tf-cur justify-content-end">
                                            <div class="tf-currencies">
                                                <select class="image-select center style-default type-currencies color-secondary-2">
                                                    <option selected data-thumbnail="{{asset('frontend/images/country/us.svg')}}">USD</option>
                                                    <option data-thumbnail="{{asset('frontend/images/country/vn.svg')}}">VND</option>
                                                    <option data-thumbnail="{{asset('frontend/images/country/fr.svg')}}">EUR</option>
                                                </select>
                                            </div>
                                            <div class="tf-languages">
                                                <select class="image-select center style-default type-languages color-secondary-2">
                                                    <option>English</option>
                                                    <option>Vietnam</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tf-payment">
                                        <p class="text-caption-1">Payment:</p>
                                        <ul>
                                            <li>
                                                <img src="{{asset('frontend/images/payment/img-1.png')}}" alt="">
                                            </li>
                                            <li>
                                                <img src="{{asset('frontend/images/payment/img-2.png')}}" alt="">
                                            </li>
                                            <li>
                                                <img src="{{asset('frontend/images/payment/img-3.png')}}" alt="">
                                            </li>
                                            <li>
                                                <img src="{{asset('frontend/images/payment/img-4.png')}}" alt="">
                                            </li>
                                            <li>
                                                <img src="{{asset('frontend/images/payment/img-5.png')}}" alt="">
                                            </li>
                                            <li>
                                                <img src="{{asset('frontend/images/payment/img-6.png')}}" alt="">
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- /Footer -->
        <!-- toolbar-bottom -->
        <div class="tf-toolbar-bottom">
            <div class="toolbar-item">
                <a href="shop-default-grid.html">
                    <div class="toolbar-icon">
                        <svg class="icon" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8.125 3.125H4.375C4.04348 3.125 3.72554 3.2567 3.49112 3.49112C3.2567 3.72554 3.125 4.04348 3.125 4.375V8.125C3.125 8.45652 3.2567 8.77446 3.49112 9.00888C3.72554 9.2433 4.04348 9.375 4.375 9.375H8.125C8.45652 9.375 8.77446 9.2433 9.00888 9.00888C9.2433 8.77446 9.375 8.45652 9.375 8.125V4.375C9.375 4.04348 9.2433 3.72554 9.00888 3.49112C8.77446 3.2567 8.45652 3.125 8.125 3.125ZM8.125 8.125H4.375V4.375H8.125V8.125ZM15.625 3.125H11.875C11.5435 3.125 11.2255 3.2567 10.9911 3.49112C10.7567 3.72554 10.625 4.04348 10.625 4.375V8.125C10.625 8.45652 10.7567 8.77446 10.9911 9.00888C11.2255 9.2433 11.5435 9.375 11.875 9.375H15.625C15.9565 9.375 16.2745 9.2433 16.5089 9.00888C16.7433 8.77446 16.875 8.45652 16.875 8.125V4.375C16.875 4.04348 16.7433 3.72554 16.5089 3.49112C16.2745 3.2567 15.9565 3.125 15.625 3.125ZM15.625 8.125H11.875V4.375H15.625V8.125ZM8.125 10.625H4.375C4.04348 10.625 3.72554 10.7567 3.49112 10.9911C3.2567 11.2255 3.125 11.5435 3.125 11.875V15.625C3.125 15.9565 3.2567 16.2745 3.49112 16.5089C3.72554 16.7433 4.04348 16.875 4.375 16.875H8.125C8.45652 16.875 8.77446 16.7433 9.00888 16.5089C9.2433 16.2745 9.375 15.9565 9.375 15.625V11.875C9.375 11.5435 9.2433 11.2255 9.00888 10.9911C8.77446 10.7567 8.45652 10.625 8.125 10.625ZM8.125 15.625H4.375V11.875H8.125V15.625ZM15.625 10.625H11.875C11.5435 10.625 11.2255 10.7567 10.9911 10.9911C10.7567 11.2255 10.625 11.5435 10.625 11.875V15.625C10.625 15.9565 10.7567 16.2745 10.9911 16.5089C11.2255 16.7433 11.5435 16.875 11.875 16.875H15.625C15.9565 16.875 16.2745 16.7433 16.5089 16.5089C16.7433 16.2745 16.875 15.9565 16.875 15.625V11.875C16.875 11.5435 16.7433 11.2255 16.5089 10.9911C16.2745 10.7567 15.9565 10.625 15.625 10.625ZM15.625 15.625H11.875V11.875H15.625V15.625Z" fill="#4D4E4F"/>
                        </svg>    
                    </div>
                    <div class="toolbar-label">Shop</div>
                </a>
            </div>
            <div class="toolbar-item">
                <a href="#shopCategories" data-bs-toggle="offcanvas" aria-controls="shopCategories">
                    <div class="toolbar-icon">
                        <svg class="icon" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.5 10C17.5 10.1658 17.4342 10.3247 17.3169 10.4419C17.1997 10.5592 17.0408 10.625 16.875 10.625H3.125C2.95924 10.625 2.80027 10.5592 2.68306 10.4419C2.56585 10.3247 2.5 10.1658 2.5 10C2.5 9.83424 2.56585 9.67527 2.68306 9.55806C2.80027 9.44085 2.95924 9.375 3.125 9.375H16.875C17.0408 9.375 17.1997 9.44085 17.3169 9.55806C17.4342 9.67527 17.5 9.83424 17.5 10ZM3.125 5.625H16.875C17.0408 5.625 17.1997 5.55915 17.3169 5.44194C17.4342 5.32473 17.5 5.16576 17.5 5C17.5 4.83424 17.4342 4.67527 17.3169 4.55806C17.1997 4.44085 17.0408 4.375 16.875 4.375H3.125C2.95924 4.375 2.80027 4.44085 2.68306 4.55806C2.56585 4.67527 2.5 4.83424 2.5 5C2.5 5.16576 2.56585 5.32473 2.68306 5.44194C2.80027 5.55915 2.95924 5.625 3.125 5.625ZM16.875 14.375H3.125C2.95924 14.375 2.80027 14.4408 2.68306 14.5581C2.56585 14.6753 2.5 14.8342 2.5 15C2.5 15.1658 2.56585 15.3247 2.68306 15.4419C2.80027 15.5592 2.95924 15.625 3.125 15.625H16.875C17.0408 15.625 17.1997 15.5592 17.3169 15.4419C17.4342 15.3247 17.5 15.1658 17.5 15C17.5 14.8342 17.4342 14.6753 17.3169 14.5581C17.1997 14.4408 17.0408 14.375 16.875 14.375Z" fill="#4D4E4F"/>
                        </svg>  
                    </div>
                    <div class="toolbar-label">Categories</div>
                </a>
            </div>
            <div class="toolbar-item">
                <a href="#search" data-bs-toggle="modal">
                    <div class="toolbar-icon">
                        <svg class="icon" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.9419 17.058L14.0302 13.1471C15.1639 11.7859 15.7293 10.04 15.6086 8.27263C15.488 6.50524 14.6906 4.85241 13.3823 3.65797C12.074 2.46353 10.3557 1.81944 8.58462 1.85969C6.81357 1.89994 5.12622 2.62143 3.87358 3.87407C2.62094 5.12671 1.89945 6.81406 1.8592 8.5851C1.81895 10.3561 2.46304 12.0745 3.65748 13.3828C4.85192 14.691 6.50475 15.4884 8.27214 15.6091C10.0395 15.7298 11.7854 15.1644 13.1466 14.0306L17.0575 17.9424C17.1156 18.0004 17.1845 18.0465 17.2604 18.0779C17.3363 18.1094 17.4176 18.1255 17.4997 18.1255C17.5818 18.1255 17.6631 18.1094 17.739 18.0779C17.8149 18.0465 17.8838 18.0004 17.9419 17.9424C17.9999 17.8843 18.046 17.8154 18.0774 17.7395C18.1089 17.6636 18.125 17.5823 18.125 17.5002C18.125 17.4181 18.1089 17.3367 18.0774 17.2609C18.046 17.185 17.9999 17.1161 17.9419 17.058ZM3.12469 8.75018C3.12469 7.63766 3.45459 6.55012 4.07267 5.6251C4.69076 4.70007 5.56926 3.9791 6.5971 3.55336C7.62493 3.12761 8.75593 3.01622 9.84707 3.23326C10.9382 3.4503 11.9405 3.98603 12.7272 4.7727C13.5138 5.55937 14.0496 6.56165 14.2666 7.6528C14.4837 8.74394 14.3723 9.87494 13.9465 10.9028C13.5208 11.9306 12.7998 12.8091 11.8748 13.4272C10.9497 14.0453 9.86221 14.3752 8.74969 14.3752C7.25836 14.3735 5.82858 13.7804 4.77404 12.7258C3.71951 11.6713 3.12634 10.2415 3.12469 8.75018Z" fill="#4D4E4F"/>
                        </svg>                            
                    </div>
                    <div class="toolbar-label">Search</div>
                </a>
            </div>
            <div class="toolbar-item">
                <a href="#shoppingCart" data-bs-toggle="modal">
                    <div class="toolbar-icon">
                        <svg class="icon" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M13.75 8.23389V4.48389C13.75 3.48932 13.3549 2.5355 12.6517 1.83224C11.9484 1.12897 10.9946 0.733887 10 0.733887C9.00544 0.733887 8.05161 1.12897 7.34835 1.83224C6.64509 2.5355 6.25 3.48932 6.25 4.48389V8.23389M3.4375 6.35889H16.5625L17.5 17.6089H2.5L3.4375 6.35889Z" stroke="#4D4E4F" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>  
                    </div>
                    <div class="toolbar-label">Cart</div>
                </a>
            </div>
        </div>
        <!-- /toolbar-bottom -->
        
    </div>
    
    <!-- search -->
    <div class="modal fade modal-search" id="search">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="d-flex justify-content-between align-items-center">
                    <h5>Search</h5>
                    <span class="icon-close icon-close-popup" data-bs-dismiss="modal"></span>
                </div>
                <form class="form-search">
                    <fieldset class="text">
                        <input type="text" id="productSearchInput"  placeholder="Searching..." class="" name="text" tabindex="0" value="" aria-required="true" required="">
                    </fieldset>
                    <button class="" type="submit">
                        <svg class="icon" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M11 19C15.4183 19 19 15.4183 19 11C19 6.58172 15.4183 3 11 3C6.58172 3 3 6.58172 3 11C3 15.4183 6.58172 19 11 19Z" stroke="#181818" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M21.35 21.0004L17 16.6504" stroke="#181818" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </button>
                </form>
                <div>
                    <h6 class="mb_16">Search Result</h6>
                    <div id="productSearchResults" class="tf-grid-layout tf-col-2 lg-col-3 xl-col-4 loadmore-item" data-display="4" data-count="4">
                        <!-- search result will display here -->
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- /search -->
      
    <!-- mobile menu -->
    <div class="offcanvas offcanvas-start canvas-mb" id="mobileMenu">
        <span class="icon-close icon-close-popup" data-bs-dismiss="offcanvas" aria-label="Close"></span>
        <div class="mb-canvas-content">
            <div class="mb-body">
                <div class="mb-content-top">
                    <ul class="nav-ul-mb" id="wrapper-menu-navigation">
                        <li class="nav-mb-item active">
                            <a href="{{url('/')}}" class="mb-menu-link">Home</a>
                        </li>
                        <li class="nav-mb-item">
                            <a href="#shopCategories" class="mb-menu-link" data-bs-toggle="offcanvas" aria-controls="shopCategories">Categories</a>
                        </li>
                        <li class="nav-mb-item">
                            <a href="{{url('/shop')}}" class="mb-menu-link">shop</a>
                        </li>
                        <li class="nav-mb-item">
                            <a href="#" class="mb-menu-link">About us</a>
                        </li>
                        @auth
                        <li class="nav-mb-item">
                            <a href="#dropdown-menu-four" class="mb-menu-link collapsed" data-bs-toggle="collapse" aria-expanded="false" aria-controls="dropdown-menu-four">
                                <span>My Account</span>
                                <span class="btn-open-sub"></span>
                            </a>
                            <div id="dropdown-menu-four" class="collapse" style="">
                                <ul class="sub-nav-menu">
                                    @if (auth()->user() and auth()->user()->hasRole('relational-manager'))
                                        @php
                                            $attendence = auth()->user()->attendence;
                                        @endphp
                                        @if ($attendence)
                                            @if ($attendence->check_out == null)
                                                <li><a href="{{ url('rm/check-out') }}" class="sub-nav-link">Check-out</a></li>
                                                <li><a href="#near_by_store" class="sub-nav-link" data-bs-toggle="modal" class="tf-btn btn-reset">Near Stores</a></li>
                                            @else
                                                <li><button class="tf-btn btn-reset">Day Completed</button></li>
                                            @endif
                                        @elseif(!$attendence)
                                            <li><a href="{{ url('rm/check-in') }}" class="sub-nav-link">Check-in</a></li>
                                            <li><a href="#" class="sub-nav-link">Leave</a></li>
                                        @endif
                                    @endif
                                        <li><a href="{{url('account')}}" class="sub-nav-link">Account</a></li>
                                        <li><a href="{{url('my-orders')}}" class="sub-nav-link">Order</a></li>
                                </ul>
                            </div>
                        </li>
                        @endauth
                    </ul>
                </div>
                <div class="mb-other-content">
                    <div class="group-icon">

                        @if (auth()->user())
                        <a href="{{url('logout')}}" class="site-nav-icon">
                            <svg class="icon" width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M20 21V19C20 17.9391 19.5786 16.9217 18.8284 16.1716C18.0783 15.4214 17.0609 15 16 15H8C6.93913 15 5.92172 15.4214 5.17157 16.1716C4.42143 16.9217 4 17.9391 4 19V21" stroke="#181818" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M12 11C14.2091 11 16 9.20914 16 7C16 4.79086 14.2091 3 12 3C9.79086 3 8 4.79086 8 7C8 9.20914 9.79086 11 12 11Z" stroke="#181818" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>  
                            Logout
                        </a>
                        @else
                        <a href="{{url('login')}}" class="site-nav-icon">
                            <svg class="icon" width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M20 21V19C20 17.9391 19.5786 16.9217 18.8284 16.1716C18.0783 15.4214 17.0609 15 16 15H8C6.93913 15 5.92172 15.4214 5.17157 16.1716C4.42143 16.9217 4 17.9391 4 19V21" stroke="#181818" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M12 11C14.2091 11 16 9.20914 16 7C16 4.79086 14.2091 3 12 3C9.79086 3 8 4.79086 8 7C8 9.20914 9.79086 11 12 11Z" stroke="#181818" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>  
                            Login
                        </a>
                        @endif

                    </div>
                    <div class="mb-notice">
                        <a href="contact.html" class="text-need">Need Help?</a>
                    </div>
                    <div class="mb-contact">
                        <p class="text-caption-1">549 Oak St.Crystal Lake, IL 60014</p>
                        <a href="contact.html" class="tf-btn-default text-btn-uppercase">GET DIRECTION<i class="icon-arrowUpRight"></i></a>
                    </div>
                    <ul class="mb-info">
                        <li>
                            <i class="icon icon-mail"></i>
                            <p>themesflat@gmail.com</p>
                        </li>
                        <li>
                            <i class="icon icon-phone"></i>
                            <p>315-666-6688</p>
                        </li>
                    </ul>
                </div>
            </div>
            
        </div>       
    </div>
    <!-- /mobile menu -->

    <!-- Categories -->
    <div class="offcanvas offcanvas-start canvas-filter canvas-categories" id="shopCategories">
        <div class="canvas-wrapper">
            <div class="canvas-header">
                <span class="icon-left icon-filter"></span>
                <h5>Categories</h5>
                <span class="icon-close icon-close-popup" data-bs-dismiss="offcanvas" aria-label="Close"></span>
            </div>

            @php
                $categories = \App\Models\Category::all();
            @endphp

            <div class="canvas-body">
                <div id="parentCategories" class="wd-facet-categories">
                    @forelse ($categories as $category)
                        @if (!$category->parent_id)
                            @php $collapseId = 'collapse-' . $category->id; @endphp
                            <div class="facet-category">
                                <!-- Parent Category -->
                                <div role="dialog" class="facet-title collapsed" data-bs-toggle="collapse" data-bs-target="#{{ $collapseId }}" aria-expanded="false" aria-controls="{{ $collapseId }}">
                                    <img class="avt" src="{{ $category->image ? asset('storage/' . $category->image) : asset('frontend/images/avatar/default.jpg') }}" alt="avt">
                                    <span class="title">{{ $category->name }}</span>
                                    @if ($category->subcategories->isNotEmpty())
                                        <span class="icon icon-arrow-down"></span>
                                    @endif
                                </div>

                                <!-- Subcategories -->
                                @if ($category->subcategories->isNotEmpty())
                                    <div id="{{ $collapseId }}" class="collapse" data-bs-parent="#parentCategories">
                                        {!! \App\Http\Controllers\FrontEndController::renderCategoriesSide($category->subcategories, $collapseId) !!}
                                    </div>
                                @endif
                            </div>
                        @endif
                    @empty
                        <p>No categories available.</p>
                    @endforelse
                </div>
            </div>


        </div>
    </div> 
    <!-- /Categories -->

    <!-- shoppingCart -->
    @auth
    <div class="modal fullRight fade modal-shopping-cart" id="shoppingCart">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="d-flex flex-column flex-grow-1 h-100">
                    <div class="header">
                        <h5 class="title">Shopping Cart</h5>
                        <span class="icon-close icon-close-popup" data-bs-dismiss="modal"></span>
                    </div>
                    <div class="wrap">
                        <div class="tf-mini-cart-wrap">
                            <div class="tf-mini-cart-main">
                                <div class="tf-mini-cart-sroll">
                                    <div class="tf-mini-cart-items">
                                        <!-- data populated with cart -->
                                    </div>
                                </div>
                            </div>
                            <div class="tf-mini-cart-bottom">
                                @if (!auth()->user()->hasAnyRole(['complete-franchise', 'partial-franchise']))
                                <div class="tf-mini-cart-tool">
                                    <div class="tf-mini-cart-tool-btn btn-add-note">
                                        <svg width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g clip-path="url(#clip0_6133_36620)">
                                            <path d="M10 3.33325H4.16667C3.72464 3.33325 3.30072 3.50885 2.98816 3.82141C2.67559 4.13397 2.5 4.55789 2.5 4.99992V16.6666C2.5 17.1086 2.67559 17.5325 2.98816 17.8451C3.30072 18.1577 3.72464 18.3333 4.16667 18.3333H15.8333C16.2754 18.3333 16.6993 18.1577 17.0118 17.8451C17.3244 17.5325 17.5 17.1086 17.5 16.6666V10.8333" stroke="#181818" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M16.25 2.0832C16.5815 1.75168 17.0312 1.56543 17.5 1.56543C17.9688 1.56543 18.4185 1.75168 18.75 2.0832C19.0815 2.41472 19.2678 2.86436 19.2678 3.3332C19.2678 3.80204 19.0815 4.25168 18.75 4.5832L10.8333 12.4999L7.5 13.3332L8.33333 9.99986L16.25 2.0832Z" stroke="#181818" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            </g>
                                            <defs>
                                            <clipPath id="clip0_6133_36620">
                                            <rect width="20" height="20" fill="white" transform="translate(0.833008)"/>
                                            </clipPath>
                                            </defs>
                                        </svg>
                                        <div class="text-caption-1">Note</div>
                                    </div>
                                </div>
                                @endif
                                <div class="tf-mini-cart-bottom-wrap">
                                    @if (!auth()->user()->hasRole('complete-franchise'))
                                    <div class="tf-cart-totals-discounts">
                                        <h5>Subtotal</h5>
                                        <h5 class="tf-totals-total-value">$0</h5>
                                    </div>
                                    @endif
                                    <div class="tf-mini-cart-view-checkout">
                                        @if (!auth()->user()->hasRole('complete-franchise'))
                                        <a href="{{url('checkout')}}" class="tf-btn w-50 btn-white radius-4 has-border"><span class="text">View cart</span></a>
                                        @else
                                        <form action="{{url('order')}}" method="post">
                                            @csrf
                                            <input type="hidden" name="cart_id" value="@if(auth()->user()->cart !== null) {{auth()->user()->cart->id}} @endif">
                                            <input type="hidden" name="action" value="cart">
                                            <button type="submit" class="tf-btn w-100 btn-fill radius-4"><span class="text">Check Out</span></button>
                                        </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="tf-mini-cart-tool-openable add-note">
                                <div class="tf-mini-cart-tool-content">
                                    <label for="Cart-note" class="tf-mini-cart-tool-text">
                                        <span class="icon">
                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <g clip-path="url(#clip0_6766_32777)">
                                                <path d="M9.16699 3.33325H3.33366C2.89163 3.33325 2.46771 3.50885 2.15515 3.82141C1.84259 4.13397 1.66699 4.55789 1.66699 4.99992V16.6666C1.66699 17.1086 1.84259 17.5325 2.15515 17.8451C2.46771 18.1577 2.89163 18.3333 3.33366 18.3333H15.0003C15.4424 18.3333 15.8663 18.1577 16.1788 17.8451C16.4914 17.5325 16.667 17.1086 16.667 16.6666V10.8333" stroke="#181818" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M15.417 2.0832C15.7485 1.75168 16.1981 1.56543 16.667 1.56543C17.1358 1.56543 17.5855 1.75168 17.917 2.0832C18.2485 2.41472 18.4348 2.86436 18.4348 3.3332C18.4348 3.80204 18.2485 4.25168 17.917 4.5832L10.0003 12.4999L6.66699 13.3332L7.50033 9.99986L15.417 2.0832Z" stroke="#181818" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                </g>
                                                <defs>
                                                <clipPath id="clip0_6766_32777">
                                                <rect width="20" height="20" fill="white"/>
                                                </clipPath>
                                                </defs>
                                            </svg>
                                        </span>
                                        <span class="text-title">Note</span>
                                    </label>
                                    <form action="{{ url('update/cart/note') }}" method="post" class="form-add-note tf-mini-cart-tool-wrap" id="form-add-note" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" id="cart_id" name="cart_id" value="">

                                        <div id="proof-container">
                                            <!--Proof image -->
                                        </div>

                                        <fieldset>
                                            <!-- Preview Section -->
                                            <div id="proofPreview" style="display: flex; gap: 10px; margin-top: 10px;"></div>
                                        </fieldset>
                                        
                                        <div class="form-group mb-2">
                                            <label for="proof"><small class="text-danger">Add Price Proof (optional)</small></label>
                                            <input type="file" name="proof[]" multiple class="form-control" id="proof" accept="image/*,application/pdf">
                                        </div>

                                        <fieldset class="d-flex">
                                            <textarea name="note" id="Cart-note" placeholder="Add special instructions for your order..."></textarea>
                                        </fieldset>

                                        <div class="tf-cart-tool-btns">
                                            <button type="submit" class="btn-style-2 w-100"><span class="text text-btn-uppercase">Save</span></button>
                                            <div class="text-center w-100 text-btn-uppercase tf-mini-cart-tool-close">Cancel</div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('proof').addEventListener('change', function(event) {
            let preview = document.getElementById('proofPreview');
            preview.innerHTML = ''; // Clear previous previews

            Array.from(event.target.files).forEach(file => {
                let reader = new FileReader();
                let fileType = file.type.split('/')[0]; // Get the file type (image, application, etc.)

                reader.onload = function(e) {
                    let container = document.createElement('div');
                    container.style.border = "1px solid #ddd";
                    container.style.padding = "10px";
                    container.style.background = "#fff";
                    container.style.marginRight = "10px";
                    container.style.textAlign = "center";

                    if (fileType === 'image') {
                        container.innerHTML = `<img src="${e.target.result}" width="100" height="100" style="display:block;"><br>`;
                    } else if (fileType === 'application' && file.type === 'application/pdf') {
                        container.innerHTML = `<a href="${e.target.result}" target="_blank" style="display:block; text-decoration:none; color:#007bff;">📄 ${file.name}</a><br>`;
                    } else {
                        container.innerHTML = `<p>Unsupported file: ${file.name}</p>`;
                    }

                    preview.appendChild(container);
                };

                reader.readAsDataURL(file);
            });
        });
    </script>
    @endauth
    <!-- /shoppingCart -->

    <!-- quickAdd -->
    <div class="modal fade modal-quick-add" id="quickAdd">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="header">
                    <span class="icon-close icon-close-popup" data-bs-dismiss="modal"></span>
                </div>
                <div>
                    <div class="tf-product-info-list">
                        <div class="tf-product-info-item">
                            <div class="image">
                                <img src="{{asset('frontend/images/products/womens/women-1.jpg')}}" alt="">
                            </div>
                            <div class="content">
                                <a href="product-detail.html">Ribbed Tank Top</a>
                                <div class="tf-product-info-price">
                                    <h5 class="price-on-sale font-2">$79.99</h5>
                                    <div class="compare-at-price font-2">$98.99</div>
                                    <div class="badges-on-sale text-btn-uppercase">
                                        -25%
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tf-product-info-choose-option">
                            <div class="variant-picker-item">
                                <div class="variant-picker-label mb_12">
                                    Colors:<span class="text-title variant-picker-label-value">Beige</span>
                                </div>
                                <div class="variant-picker-values type-click">
                                    <input id="values-beige2" type="radio" name="color3" checked>
                                    <label class="hover-tooltip tooltip-bot radius-60" for="values-beige2" data-value="Beige">
                                        <span class="btn-checkbox bg-color-beige1"></span>
                                        <span class="tooltip">Beige</span>
                                    </label>
                                    <input id="values-gray2" type="radio" name="color3">
                                    <label class="hover-tooltip tooltip-bot radius-60" for="values-gray2" data-value="Gray">
                                        <span class="btn-checkbox bg-color-gray"></span>
                                        <span class="tooltip">Gray</span>
                                    </label>
                                    <input id="values-grey3" type="radio" name="color3">
                                    <label class="hover-tooltip tooltip-bot radius-60" for="values-grey3" data-value="Grey">
                                        <span class="btn-checkbox bg-color-grey"></span>
                                        <span class="tooltip">Grey</span>
                                    </label>
                                </div>
                            </div>
                            <div class="variant-picker-item">
                                <div class="variant-picker-label">
                                    Size:<span class="text-title variant-picker-label-value">L</span>
                                </div>
                                <div class="variant-picker-values gap12">
                                    <input type="radio" name="size3" id="values-s2">
                                    <label class="style-text size-btn" for="values-s2" data-value="S">
                                        <span class="text-title">S</span>
                                    </label>
                                    <input type="radio" name="size3" id="values-m2">
                                    <label class="style-text size-btn" for="values-m2" data-value="M">
                                        <span class="text-title">M</span>
                                    </label>
                                    <input type="radio" name="size3" id="values-l2" checked>
                                    <label class="style-text size-btn" for="values-l2" data-value="L">
                                        <span class="text-title">L</span>
                                    </label>
                                    <input type="radio" name="size3" id="values-xl2">
                                    <label class="style-text size-btn" for="values-xl2" data-value="XL">
                                        <span class="text-title">XL</span>
                                    </label>
                                </div>
                            </div>
                            <div class="tf-product-info-quantity">
                                <div class="title mb_12">Quantity:</div>
                                <div class="wg-quantity">
                                    <span class="btn-quantity btn-decrease">-</span>
                                    <input class="quantity-product" type="text" name="number" value="1">
                                    <span class="btn-quantity btn-increase">+</span>
                                </div>
                            </div>
                            <div>
                                <div class="tf-product-info-by-btn mb_10">
                                    <a class="btn-style-2 flex-grow-1 text-btn-uppercase fw-6 show-shopping-cart"><span>Add to cart -&nbsp;</span><span class="tf-qty-price total-price">$79.99</span></a>
                                    <a href="#compare" data-bs-toggle="offcanvas" aria-controls="compare" class="box-icon hover-tooltip compare btn-icon-action show-compare">
                                        <span class="icon icon-gitDiff"></span>
                                        <span class="tooltip text-caption-2">Compare</span>
                                    </a>
                                    <a href="javascript:void(0);" class="box-icon hover-tooltip text-caption-2 wishlist btn-icon-action">
                                        <span class="icon icon-heart"></span>
                                        <span class="tooltip text-caption-2">Wishlist</span>
                                    </a>
                                </div>
                                <a href="#" class="btn-style-3 text-btn-uppercase">Buy it now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /quickAdd -->

    <!-- Javascript -->
    <script type="text/javascript" src="{{asset('frontend/js/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('frontend/js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('frontend/js/swiper-bundle.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('frontend/js/carousel.js')}}"></script>
    <script type="text/javascript" src="{{asset('frontend/js/bootstrap-select.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('frontend/js/lazysize.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('frontend/js/count-down.js')}}"></script>
    <script type="text/javascript" src="{{asset('frontend/js/wow.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('frontend/js/multiple-modal.js')}}"></script>
    <script type="text/javascript" src="{{asset('frontend/js/main.js')}}"></script>
    <script type="text/javascript" src="{{asset('frontend/js/common.js')}}"></script>
    @auth
    <script type="text/javascript" src="{{asset('frontend/js/custom.js')}}"></script>
    @endauth
    @if (auth()->user() and auth()->user()->hasRole('relational-manager'))
        @php
            $attendence = auth()->user()->attendence;
        @endphp
        @if ($attendence && $attendence->check_out == null)
            <script>
                var storeNotSelected = @json(!session()->has('store'));
            </script>
            <!-- Select2 CSS -->
            <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
            <!-- Select2 JS -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
            <script type="text/javascript" src="{{asset('frontend/js/location.js')}}"></script> 
        @endif
    @endif
    <!-- <script>$(document).ready(function () {
        $(".facet-title").on("click", function () {
            let icon = $(this).find("span.icon");

            // Toggle icon based on collapse state
            if ($(this).hasClass("collapsed")) {
                icon.removeClass("icon-arrow-down").addClass("icon-arrRight"); // Expanded state
            } else {
                icon.removeClass("icon-arrRight").addClass("icon-arrow-down"); // Collapsed state
            }
        });
    });
    </script> -->
    @yield('script')
        
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        @if(session('success'))
            toastr.success("{{ session('success') }}");
        @endif

        @if(session('error'))
            toastr.error("{{ session('error') }}");
        @endif

        @if($errors->any())
            @foreach($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach
        @endif
    </script>
    
</body>

</html>