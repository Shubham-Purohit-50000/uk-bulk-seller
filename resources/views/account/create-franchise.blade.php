@extends('layout.app')
@section('title','Create Franchise')
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
                    <form action="{{url('store-franchise')}}" method="POST" enctype="multipart/form-data" class="form-account-details form-has-password">
                        @csrf
                        <div class="account-info">
                            <h5 class="title">Information</h5>
                            <div class="cols mb_20">
                                <fieldset class="">
                                    <input class="" type="text" placeholder="Name*" name="name" tabindex="2" aria-required="true" required="">
                                </fieldset>
                                <fieldset class="">
                                    <input class="" type="email" placeholder="Email address*" name="email" tabindex="2" aria-required="true" required="">
                                </fieldset>
                            </div>
                            <div class="cols mb_20">
                                <fieldset class="">
                                    <input class="" type="text" placeholder="Phone*" name="phone" tabindex="2" aria-required="true" required="">
                                </fieldset>
                                <fieldset class="">
                                    <input class="" type="password" placeholder="Enter Password" name="password" tabindex="2" aria-required="true" required="">
                                </fieldset>
                            </div>
                            <div class="cols mb_20">
                                <fieldset class="">
                                    <input class="" type="text" placeholder="Latitude*" name="latitude" tabindex="2" aria-required="true" required="">
                                </fieldset>
                                <fieldset class="">
                                    <input class="" type="text" placeholder="Longitude" name="longitude" tabindex="2" aria-required="true" required="">
                                </fieldset>
                            </div>
                            <div class="tf-select mb_20">
                                <select class="text-title" name="type" data-default="">
                                    <option value="complete-franchise">Complete Franchise</option>
                                    <option value="partial-franchise">Partial Franchise</option>
                                </select>
                            </div>
                            <div class="cols mb_20">
                                <fieldset>
                                    <textarea name="address" placeholder="Enter Complete Address..." required=""></textarea>
                                </fieldset>
                            </div>
                        </div>

                        <div class="account-info">
                            <h5 class="title">Store Images</h5>
                            <div class="cols mb_20">
                                <fieldset>
                                    <!-- Preview Section -->
                                    <div id="imagePreview" style="display: flex; gap: 10px; margin-top: 10px;"></div>
                                </fieldset>
                            </div>
                            <div class="cols mb_20">
                                <fieldset>
                                    <input class="form-control" type="file" name="images[]" id="imageUpload" multiple placeholder="Upload Multiple Images" tabindex="2" aria-required="true" required="">
                                </fieldset>
                            </div>
                        </div>

                        <div class="button-submit">
                            <button class="tf-btn btn-fill" type="submit">
                                <span class="text text-button">Submit</span>
                            </button>
                        </div>

                    </form>
                </div>
        
            </div>
            <!-- end my account form -->
        </div>
    </div>
</section>
<!-- /my-account -->
<script>
document.getElementById('imageUpload').addEventListener('change', function(event) {
    let preview = document.getElementById('imagePreview');
    preview.innerHTML = ''; // Clear previous previews
    Array.from(event.target.files).forEach(file => {
        let reader = new FileReader();
        reader.onload = function(e) {
            let imgContainer = document.createElement('div');
            imgContainer.style.border = "1px solid #ddd";
            imgContainer.style.padding = "10px";
            imgContainer.style.background = "#fff";
            imgContainer.innerHTML = `<img src="${e.target.result}" width="100" height="100" style="display:block;"><br>`;
            preview.appendChild(imgContainer);
        };
        reader.readAsDataURL(file);
    });
});
</script>
@endsection