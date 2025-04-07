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
            <!-- my account form  -->
            <div class="my-account-content">
                <div class="account-details">
                    <form action="#" class="form-account-details form-has-password">
                        <div class="account-info">
                            <h5 class="title">Information</h5>
                            <div class="cols mb_20">
                                <fieldset>
                                    <input type="text" tabindex="2" value="{{auth()->user()->name}}" readonly>
                                </fieldset>
                                <fieldset>
                                    <input type="text" tabindex="2" value="{{auth()->user()->email}}" readonly>
                                </fieldset>
                            </div>
                            <div class="cols mb_20">
                                <fieldset>
                                    <input type="text" tabindex="2" value="{{auth()->user()->phone}}" readonly>
                                </fieldset>
                            </div>
                            <div class="cols mb_20">
                                <fieldset>
                                    <textarea readonly>{{auth()->user()->address}}</textarea>
                                </fieldset>
                            </div>
                        </div>

                        <div class="account-info">
                            <h5 class="title">Level & Type</h5>
                            <div class="cols mb_20">
                                @if (auth()->user()->level !== null)
                                <fieldset>
                                    <input type="text" tabindex="2" value="{{auth()->user()->level->name}}" readonly>
                                </fieldset>
                                @endif
                                <fieldset>
                                    <input type="text" tabindex="2" value="{{ auth()->user()->roles->first()->name ?? 'No Role Assigned' }}" readonly>
                                </fieldset>
                            </div>
                        </div>

                        @if (auth()->user()->hasRole('complete-franchise'))
                        <div class="account-info">
                            <h5 class="title">Parent Company</h5>
                            <div class="cols mb_20">
                                <fieldset>
                                    <input type="text" value="{{ auth()->user()->parentCompany->name }}" readonly>
                                </fieldset>
                            </div>
                        </div>
                        @endif

                        @if (auth()->user()->hasRole('company') or auth()->user()->hasRole('business'))
                        <div class="account-info">
                            <h5 class="title">Relational Manager</h5>
                            <div class="cols mb_20">
                                <fieldset>
                                    <input type="text" value="{{ auth()->user()->rm->name }}" readonly>
                                </fieldset>
                            </div>
                        </div>
                        @endif

                        @if (auth()->user()->hasRole('relational-manager'))
                        <div class="account-info">
                            <h5 class="title">Commission Rate</h5>
                            <div class="cols mb_20">
                                <fieldset>
                                    <input type="text" value="{{ auth()->user()->commission }} %" readonly>
                                </fieldset>
                            </div>
                        </div>
                        @endif

                    </form>
                </div>
        
            </div>
            <!-- end my account form -->
        </div>
    </div>
</section>
<!-- /my-account -->
@endsection