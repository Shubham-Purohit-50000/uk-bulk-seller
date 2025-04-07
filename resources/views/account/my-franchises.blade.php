@extends('layout.app')
@section('title','My Franchises')
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
            <!-- nav -->
            @include('account.side-nav')
            <!-- nav end -->
            <!-- my order list -->
            <div class="my-account-content">
                <div class="account-orders">
                    <div class="wrap-account-order">
                    @if($franchises->isEmpty())
                        <p>No Franchises found.</p>
                    @else
                        <table>
                            <thead>
                                <tr>
                                    <th class="fw-6">ID</th>
                                    <th class="fw-6">Image</th>
                                    <th class="fw-6">Name</th>
                                    <th class="fw-6">Email</th>
                                    <th class="fw-6">Phone</th>
                                    <th class="fw-6">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($franchises as $franchise)
                                <tr class="tf-order-item">
                                    <td>
                                        #{{$franchise->id}}
                                    </td>
                                    <td>
                                    @if(!empty($franchise->images))
                                        @php
                                            $images = json_decode($franchise->images, true);
                                        @endphp
                                        @if($images[0])
                                            <img src="{{ asset('storage/' . $images[0]) }}" alt="Franchise Image" class="img-fluid" width="200">
                                        @endif
                                    @endif
                                    </td>
                                    <td>
                                        {{$franchise->name}}
                                    </td>
                                    <td>
                                        {{$franchise->email}}
                                    </td>
                                    <td>
                                        {{$franchise->phone}}
                                    </td>
                                    <td>
                                        <a href="{{url('franchise-details', $franchise->id)}}" class="tf-btn btn-fill radius-4">
                                            <span class="text">View</span>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                    </div>
                </div>
            </div>
             <!-- my order list end -->
        </div>
    </div>
</section>
<!-- /my-account -->
@endsection