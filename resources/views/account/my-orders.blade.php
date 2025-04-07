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
            <!-- nav -->
            @include('account.side-nav')
            <!-- nav end -->
            <!-- my order list -->
            <div class="my-account-content">
                <div class="account-orders">
                    <div class="wrap-account-order">
                    @if($orders->isEmpty())
                        <p>No orders found.</p>
                    @else
                        <table>
                            <thead>
                                <tr>
                                    <th class="fw-6">Order</th>
                                    <th class="fw-6">Date</th>
                                    <th class="fw-6">Status</th>
                                    @if (!auth()->user()->hasRole('complete-franchise'))
                                    <th class="fw-6">Total</th>
                                    @endif
                                    <th class="fw-6">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                <tr class="tf-order-item">
                                    <td>
                                        #{{$order->id}}
                                    </td>
                                    <td>
                                        {{ $order->created_at->format('d M Y') }}
                                    </td>
                                    <td>
                                        @if ($order->status == 'pending')
                                            <span class="btn btn-warning">Pending</span>
                                        @elseif ($order->status == 'in_transit')
                                            <span class="btn btn-basic">In Transit</span>
                                        @elseif ($order->status == 'delivered')
                                            <span class="btn btn-success">Delivered</span>
                                        @elseif ($order->status == 'canceled')
                                            <span class="btn btn-danger">Canceled</span>
                                        @endif
                                    </td>
                                    @if (!auth()->user()->hasRole('complete-franchise'))
                                    <td>
                                        ${{ number_format($order->total_amount, 2) }}
                                    </td>
                                    @endif
                                    <td>
                                        <a href="{{url('order-items', $order->id)}}" class="tf-btn btn-fill radius-4">
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