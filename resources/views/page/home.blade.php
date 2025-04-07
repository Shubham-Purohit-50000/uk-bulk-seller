@extends('layout.app')
@section('title','Home')
@section('content')
<!-- Slider -->
<section class="flat-spacing-7">
   <div class="container">
      <div class="row">
         <div class="col-lg-3">
            <div class="tf-list-categories style-1">
               <a href="shop-collection.html" class="categories-title">
               <span class="icon-left icon-categories"></span> 
               <span class="text">Shop By</span> 
               </a>
               <div class="list-categories-inner">

               @php
               // Recursive function to display categories and subcategories
               function renderCategoriesHome($categories) {
                  foreach ($categories as $category) {
                     echo '<li class="sub-categories2 ' . ($category->subcategories->isNotEmpty() ? 'has-submenu' : '') . '">
                           <a href="' . url('shop/'.$category->slug) . '" class="categories-item">
                              <span class="inner-left text-title">
                                 <img src="' . ($category->image ? asset("storage/" . $category->image) : "placeholder.png") . '" 
                                 alt="Image" style="width: 32px; height: 32px;" />
                                 ' . $category->name . '
                              </span>';
                              
                              if ($category->subcategories->isNotEmpty()) {
                                 echo '<i class="icon icon-arrRight"></i>';
                              }
                              
                           echo '</a>';

                           // Render subcategories without adding an extra <ul>
                           if ($category->subcategories->isNotEmpty()) {
                              echo '<ul class="list-categories-inner">';
                              renderCategoriesHome($category->subcategories);
                              echo '</ul>';
                           }
                     echo '</li>';
                  }
               }
               @endphp

               <ul class="categories-list">
                  @forelse ($categories as $category)
                     @if (!$category->parent_id) 
                           <li class="sub-categories2 @if ($category->subcategories->isNotEmpty()) has-submenu @endif">
                              <a href="{{ url('shop/'.$category->slug) }}" class="categories-item">
                                 <span class="inner-left text-title">
                                       <img src="{{ $category->image ? asset('storage/' . $category->image) : 'placeholder.png' }}" 
                                          alt="Image" style="width: 32px; height: 32px;" />
                                       {{ $category->name }}
                                 </span>
                                 @if ($category->subcategories->isNotEmpty())
                                       <i class="icon icon-arrRight"></i>
                                 @endif
                              </a>

                              @if ($category->subcategories->isNotEmpty())
                                 <ul class="list-categories-inner sub-cat">
                                       @php renderCategoriesHome($category->subcategories); @endphp
                                 </ul>
                              @endif
                           </li>
                     @endif
                  @empty
                     <p>No categories available.</p>
                  @endforelse
               <!-- </ul>

               <ul> -->
                     <li class="sub-categories2">
                        <a href="shop-collection.html" class="categories-item">
                        <span class="inner-left text-title">
                        <i class="icon icon-cat"></i>
                        For Cats
                        </span>
                        <i class="icon icon-arrRight"></i>
                        </a>
                        <ul class="list-categories-inner">
                           <li>
                              <a href="shop-collection.html" class="categories-item">
                              <span class="inner-left text-title">
                              <i class="icon icon-cat"></i> 
                              For Cats
                              </span>
                              </a>
                           </li>
                           <li>
                              <a href="shop-collection.html" class="categories-item">
                              <span class="inner-left text-title">
                              <i class="icon icon-cat"></i> 
                              For Cats
                              </span>
                              </a>
                           </li>
                        </ul>
                     </li>
                     <li class="sub-categories2">
                        <a href="shop-collection.html" class="categories-item">
                        <span class="inner-left text-title">
                        <i class="icon icon-dog"></i>
                        For Dogs
                        </span>
                        <i class="icon icon-arrRight"></i>
                        </a>
                        <ul class="list-categories-inner">
                           <li>
                              <a href="shop-collection.html" class="categories-item">
                              <span class="inner-left text-title">
                              <i class="icon icon-dog"></i> 
                              For Dogs
                              </span>
                              </a>
                           </li>
                           <li>
                              <a href="shop-collection.html" class="categories-item">
                              <span class="inner-left text-title">
                              <i class="icon icon-dog"></i> 
                              For Dogs
                              </span>
                              </a>
                           </li>
                        </ul>
                     </li>
                     <li class="sub-categories2">
                        <a href="shop-collection.html" class="categories-item">
                        <span class="inner-left text-title">
                        <i class="icon icon-fish"></i>
                        For Fish
                        </span>
                        <i class="icon icon-arrRight"></i>
                        </a>
                        <ul class="list-categories-inner">
                           <li>
                              <a href="shop-collection.html" class="categories-item">
                              <span class="inner-left text-title">
                              <i class="icon icon-fish"></i> 
                              For Fish
                              </span>
                              </a>
                           </li>
                           <li>
                              <a href="shop-collection.html" class="categories-item">
                              <span class="inner-left text-title">
                              <i class="icon icon-fish"></i> 
                              For Fish
                              </span>
                              </a>
                           </li>
                        </ul>
                     </li>
                     <li class="sub-categories2">
                        <a href="shop-collection.html" class="categories-item">
                        <span class="inner-left text-title">
                        <i class="icon icon-bird"></i>
                        For Bird
                        </span>
                        <i class="icon icon-arrRight"></i>
                        </a>
                        <ul class="list-categories-inner">
                           <li>
                              <a href="shop-collection.html" class="categories-item">
                              <span class="inner-left text-title">
                              <i class="icon icon-bird"></i> 
                              For Bird
                              </span>
                              </a>
                           </li>
                           <li>
                              <a href="shop-collection.html" class="categories-item">
                              <span class="inner-left text-title">
                              <i class="icon icon-bird"></i> 
                              For Bird
                              </span>
                              </a>
                           </li>
                        </ul>
                     </li>
                     <li class="sub-categories2">
                        <a href="shop-collection.html" class="categories-item">
                        <span class="inner-left text-title">
                        <i class="icon icon-sm-pet"></i>
                        Small Pet
                        </span>
                        <i class="icon icon-arrRight"></i>
                        </a>
                        <ul class="list-categories-inner">
                           <li>
                              <a href="shop-collection.html" class="categories-item">
                              <span class="inner-left text-title">
                              <i class="icon icon-sm-pet"></i> 
                              Small Pet
                              </span>
                              </a>
                           </li>
                           <li>
                              <a href="shop-collection.html" class="categories-item">
                              <span class="inner-left text-title">
                              <i class="icon icon-sm-pet"></i> 
                              Small Pet
                              </span>
                              </a>
                           </li>
                        </ul>
                     </li>
                     <li><a href="shop-collection.html" class="categories-item"><span class="inner-left text-title"><i class="icon icon-cheese"></i>Food</span></a></li>
                     <li><a href="shop-collection.html" class="categories-item"><span class="inner-left text-title"><i class="icon icon-pharmacy"></i>Pharmacy</span></a></li>
                     <li><a href="shop-collection.html" class="categories-item"><span class="inner-left text-title"><i class="icon icon-bone"></i>Accessory</span></a></li>
                  </ul>
               </div>
            </div>
         </div>
         <div class="col-lg-9">
            <div class="tf-slideshow slider-style2 slider-pet-store slider-position slider-effect-fade">
               <div dir="ltr" class="swiper tf-sw-slideshow" data-effect="fade" data-preview="1" data-tablet="1" data-mobile="1" data-centered="false" data-space="0" data-space-mb="0" data-loop="true" data-auto-play="true">
                  <div class="swiper-wrapper">
                     <div class="swiper-slide">
                        <div class="wrap-slider">
                           <img src="{{asset('frontend/images/slider/slider-1.jpg')}}" alt="slideshow">
                           <div class="box-content">
                              <div class="content-slider">
                                 <div class="box-title-slider">
                                    <h2 class="fade-item fade-item-1 heading">Dog Food <br> Delights</h2>
                                    <p class="fade-item fade-item-2 body-text-1 subheading">Discover premium meals to keep <br> your dog happy and healthy.</p>
                                 </div>
                                 <div class="fade-item fade-item-3 box-btn-slider">
                                    <a href="shop-default-grid.html" class="tf-btn btn-fill"><span class="text">Shop Now</span><i class="icon icon-arrowUpRight"></i></a>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="swiper-slide">
                        <div class="wrap-slider">
                           <img src="{{asset('frontend/images/slider/slider-2.jpg')}}" alt="slideshow">
                           <div class="box-content">
                              <div class="content-slider">
                                 <div class="box-title-slider">
                                    <h2 class="fade-item fade-item-1 heading">Cozy Pet <br> Bedding</h2>
                                    <p class="fade-item fade-item-2 body-text-1 subheading">Discover premium meals to keep <br> your dog happy and healthy.</p>
                                 </div>
                                 <div class="fade-item fade-item-3 box-btn-slider">
                                    <a href="shop-default-grid.html" class="tf-btn btn-fill"><span class="text">Shop Now</span><i class="icon icon-arrowUpRight"></i></a>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="swiper-slide">
                        <div class="wrap-slider">
                           <img src="{{asset('frontend/images/slider/slider-3.jpg')}}" alt="slideshow">
                           <div class="box-content">
                              <div class="content-slider">
                                 <div class="box-title-slider">
                                    <h2 class="fade-item fade-item-1 heading">Cat Cuisine <br> Essentials</h2>
                                    <p class="fade-item fade-item-2 body-text-1 subheading">Discover premium meals to keep <br> your dog happy and healthy.</p>
                                 </div>
                                 <div class="fade-item fade-item-3 box-btn-slider">
                                    <a href="shop-default-grid.html" class="tf-btn btn-fill"><span class="text">Shop Now</span><i class="icon icon-arrowUpRight"></i></a>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="wrap-pagination d-block">
                  <div class="container">
                     <div class="sw-dots sw-pagination-slider type-square justify-content-center"></div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<!-- /Slider -->
<!-- Categories -->
<section class="flat-spacing section-pet-store">
   <div class="container">
      <div class="heading-section text-center wow fadeInUp">
         <h3 class="heading">Get Your Product With Easy Categories List</h3>
         <p class="subheading">Everything You Need for the Health and Happiness</p>
      </div>
      <div dir="ltr" class="swiper tf-sw-categories" data-preview="4" data-tablet="3" data-mobile-sm="2" data-mobile="1" data-space-lg="30" data-space-md="20" data-space="15" data-pagination="1" data-pagination-md="3" data-pagination-lg="4">
         <div class="row">
            <!-- shubham custom code for custom categories -->
            @php
                $categories = \App\Models\Category::all();
            @endphp

            <div class="canvas-body shubham-category">
                <div id="parentCategories" class="wd-facet-categories row">
                    @forelse ($categories as $category)
                        @if (!$category->parent_id)
                            @php $collapseId = 'collapse-' . $category->id; @endphp
                            <div class="facet-category col-md-3 my-col">
                                <!-- Parent Category -->
                                <div role="dialog" class="facet-title collapsed my-row row" data-bs-toggle="collapse" data-bs-target="#{{ $collapseId }}" aria-expanded="false" aria-controls="{{ $collapseId }}">
                                    <div class="col-10">
                                       <img class="avt" src="{{ $category->image ? asset('storage/' . $category->image) : asset('frontend/images/avatar/default.jpg') }}" alt="avt">
                                       <span class="title" style="margin-left: 10px;">{{ $category->name }}</span>
                                    </div>
                                    <div class="col-1" style="text-align:end;">
                                       @if ($category->subcategories->isNotEmpty())
                                          <span class="icon icon-arrow-down"></span>
                                       @endif
                                    </div>
                                </div>

                                <!-- Subcategories -->
                                @if ($category->subcategories->isNotEmpty())
                                    <div id="{{ $collapseId }}" class="collapse" data-bs-parent="#parentCategories">
                                        {!! \App\Http\Controllers\FrontEndController::renderCategoriesHome($category->subcategories, $collapseId) !!}
                                    </div>
                                @endif
                            </div>
                        @endif
                    @empty
                        <p>No categories available.</p>
                    @endforelse
                </div>
            </div>
            <!-- shubham custom code for custom categories -->
         </div>
      </div>
   </div>
</section>

<!-- /Categories -->
<!-- Top Picks -->
<section class="flat-spacing">
   <div class="container">
      <div class="heading-section text-center wow fadeInUp">
         <h3>Today's Top Picks</h3>
         <ul class="tab-product-v2 justify-content-sm-center" role="tablist">
            <li class="nav-tab-item" role="presentation">
               <a href="#ForCat" class="active" data-bs-toggle="tab">For Cat</a>
            </li>
            <li class="nav-tab-item" role="presentation">
               <a href="#ForDog" data-bs-toggle="tab">For Dog</a>
            </li>
            <li class="nav-tab-item" role="presentation">
               <a href="#SmallPet" data-bs-toggle="tab">Small Pet</a>
            </li>
            <li class="nav-tab-item" role="presentation">
               <a href="#Pharmacy" data-bs-toggle="tab">Pharmacy</a>
            </li>
            <li class="nav-tab-item" role="presentation">
               <a href="#Sale" data-bs-toggle="tab">Sale</a>
            </li>
         </ul>
      </div>
      <div class="flat-animate-tab">
         <div class="tab-content">
            <div class="tab-pane active show" id="ForCat" role="tabpanel">
               <div class="tf-grid-layout tf-col-2 lg-col-3 xl-col-5">
                  <div class="card-product style-swatch-img wow fadeInUp" data-wow-delay="0s">
                     <div class="card-product-wrapper">
                        <a href="product-detail.html" class="product-img">
                        <img class="lazyload img-product" data-src="{{asset('frontend/images/products/pet-store/pet-store-1.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-1.jpg')}}" alt="image-product">
                        <img class="lazyload img-hover" data-src="{{asset('frontend/images/products/pet-store/pet-store-2.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-2.jpg')}}" alt="image-product">
                        </a>
                        <div class="list-product-btn">
                           <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                           <span class="icon icon-heart"></span>
                           <span class="tooltip">Wishlist</span>
                           </a>
                           <a href="#compare" data-bs-toggle="offcanvas" aria-controls="compare" class="box-icon compare btn-icon-action">
                           <span class="icon icon-gitDiff"></span>
                           <span class="tooltip">Compare</span>
                           </a>
                           <a href="#quickView" data-bs-toggle="modal" class="box-icon quickview tf-btn-loading">
                           <span class="icon icon-eye"></span>
                           <span class="tooltip">Quick View</span>
                           </a>
                        </div>
                        <div class="list-btn-main">
                           <a href="#shoppingCart" data-bs-toggle="modal" class="btn-main-product">Add To cart</a>
                        </div>
                     </div>
                     <div class="card-product-info">
                        <a href="product-detail.html" class="title link">Beefy Chewin' Collagen Chews</a>
                        <span class="price"><span class="old-price">$98.00</span> $16.95</span>
                        <ul class="list-color-product">
                           <li class="list-color-item color-swatch active">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-1.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-1.jpg')}}" alt="image-product">
                           </li>
                           <li class="list-color-item color-swatch">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-2.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-2.jpg')}}" alt="image-product">
                           </li>
                        </ul>
                     </div>
                  </div>
                  <div class="card-product style-swatch-img wow fadeInUp" data-wow-delay="0.1s">
                     <div class="card-product-wrapper">
                        <a href="product-detail.html" class="product-img">
                        <img class="lazyload img-product" data-src="{{asset('frontend/images/products/pet-store/pet-store-3.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-3.jpg')}}" alt="image-product">
                        <img class="lazyload img-hover" data-src="{{asset('frontend/images/products/pet-store/pet-store-4.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-4.jpg')}}" alt="image-product">
                        </a>
                        <div class="on-sale-wrap"><span class="on-sale-item">-25%</span></div>
                        <div class="list-product-btn">
                           <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                           <span class="icon icon-heart"></span>
                           <span class="tooltip">Wishlist</span>
                           </a>
                           <a href="#compare" data-bs-toggle="offcanvas" aria-controls="compare" class="box-icon compare btn-icon-action">
                           <span class="icon icon-gitDiff"></span>
                           <span class="tooltip">Compare</span>
                           </a>
                           <a href="#quickView" data-bs-toggle="modal" class="box-icon quickview tf-btn-loading">
                           <span class="icon icon-eye"></span>
                           <span class="tooltip">Quick View</span>
                           </a>
                        </div>
                        <div class="list-btn-main">
                           <a href="#shoppingCart" data-bs-toggle="modal" class="btn-main-product">Add To cart</a>
                        </div>
                     </div>
                     <div class="card-product-info">
                        <a href="product-detail.html" class="title link">Adult Chicken & Brown Rice</a>
                        <span class="price"><span class="old-price">$98.00</span> $16.95</span>
                        <ul class="list-color-product">
                           <li class="list-color-item color-swatch active">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-3.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-3.jpg')}}" alt="image-product">
                           </li>
                           <li class="list-color-item color-swatch">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-4.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-4.jpg')}}" alt="image-product">
                           </li>
                           <li class="list-color-item color-swatch">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-5.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-5.jpg')}}" alt="image-product">
                           </li>
                        </ul>
                     </div>
                  </div>
                  <div class="card-product style-swatch-img wow fadeInUp" data-wow-delay="0.2s">
                     <div class="card-product-wrapper">
                        <a href="product-detail.html" class="product-img">
                        <img class="lazyload img-product" data-src="{{asset('frontend/images/products/pet-store/pet-store-6.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-6.jpg')}}" alt="image-product">
                        <img class="lazyload img-hover" data-src="{{asset('frontend/images/products/pet-store/pet-store-7.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-7.jpg')}}" alt="image-product">
                        </a>
                        <div class="on-sale-wrap"><span class="on-sale-item">-25%</span></div>
                        <div class="marquee-product bg-main">
                           <div class="marquee-wrapper">
                              <div class="initial-child-container">
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                              </div>
                           </div>
                           <div class="marquee-wrapper">
                              <div class="initial-child-container">
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="list-product-btn">
                           <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                           <span class="icon icon-heart"></span>
                           <span class="tooltip">Wishlist</span>
                           </a>
                           <a href="#compare" data-bs-toggle="offcanvas" aria-controls="compare" class="box-icon compare btn-icon-action">
                           <span class="icon icon-gitDiff"></span>
                           <span class="tooltip">Compare</span>
                           </a>
                           <a href="#quickView" data-bs-toggle="modal" class="box-icon quickview tf-btn-loading">
                           <span class="icon icon-eye"></span>
                           <span class="tooltip">Quick View</span>
                           </a>
                        </div>
                        <div class="list-btn-main">
                           <a href="#shoppingCart" data-bs-toggle="modal" class="btn-main-product">Add To cart</a>
                        </div>
                     </div>
                     <div class="card-product-info">
                        <a href="product-detail.html" class="title link">Mix-a-Meal Original Recip</a>
                        <span class="price"><span class="old-price">$98.00</span> $16.95</span>
                        <ul class="list-color-product">
                           <li class="list-color-item color-swatch active">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-6.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-6.jpg')}}" alt="image-product">
                           </li>
                           <li class="list-color-item color-swatch">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-7.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-7.jpg')}}" alt="image-product">
                           </li>
                        </ul>
                     </div>
                  </div>
                  <div class="card-product style-swatch-img wow fadeInUp" data-wow-delay="0.3s">
                     <div class="card-product-wrapper">
                        <a href="product-detail.html" class="product-img">
                        <img class="lazyload img-product" data-src="{{asset('frontend/images/products/pet-store/pet-store-8.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-8.jpg')}}" alt="image-product">
                        <img class="lazyload img-hover" data-src="{{asset('frontend/images/products/pet-store/pet-store-9.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-9.jpg')}}" alt="image-product">
                        </a>
                        <div class="on-sale-wrap"><span class="on-sale-item">-25%</span></div>
                        <div class="list-product-btn">
                           <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                           <span class="icon icon-heart"></span>
                           <span class="tooltip">Wishlist</span>
                           </a>
                           <a href="#compare" data-bs-toggle="offcanvas" aria-controls="compare" class="box-icon compare btn-icon-action">
                           <span class="icon icon-gitDiff"></span>
                           <span class="tooltip">Compare</span>
                           </a>
                           <a href="#quickView" data-bs-toggle="modal" class="box-icon quickview tf-btn-loading">
                           <span class="icon icon-eye"></span>
                           <span class="tooltip">Quick View</span>
                           </a>
                        </div>
                        <div class="list-btn-main">
                           <a href="#shoppingCart" data-bs-toggle="modal" class="btn-main-product">Add To cart</a>
                        </div>
                     </div>
                     <div class="card-product-info">
                        <a href="product-detail.html" class="title link">Beefy Toot Loops™ Crunchy</a>
                        <span class="price"><span class="old-price">$98.00</span> $16.95</span>
                        <ul class="list-color-product">
                           <li class="list-color-item color-swatch active">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-8.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-8.jpg')}}" alt="image-product">
                           </li>
                           <li class="list-color-item color-swatch">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-9.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-9.jpg')}}" alt="image-product">
                           </li>
                        </ul>
                     </div>
                  </div>
                  <div class="card-product style-swatch-img wow fadeInUp" data-wow-delay="0.4s">
                     <div class="card-product-wrapper">
                        <a href="product-detail.html" class="product-img">
                        <img class="lazyload img-product" data-src="{{asset('frontend/images/products/pet-store/pet-store-10.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-10.jpg')}}" alt="image-product">
                        <img class="lazyload img-hover" data-src="{{asset('frontend/images/products/pet-store/pet-store-11.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-11.jpg')}}" alt="image-product">
                        </a>
                        <div class="list-product-btn">
                           <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                           <span class="icon icon-heart"></span>
                           <span class="tooltip">Wishlist</span>
                           </a>
                           <a href="#compare" data-bs-toggle="offcanvas" aria-controls="compare" class="box-icon compare btn-icon-action">
                           <span class="icon icon-gitDiff"></span>
                           <span class="tooltip">Compare</span>
                           </a>
                           <a href="#quickView" data-bs-toggle="modal" class="box-icon quickview tf-btn-loading">
                           <span class="icon icon-eye"></span>
                           <span class="tooltip">Quick View</span>
                           </a>
                        </div>
                        <div class="list-btn-main">
                           <a href="#shoppingCart" data-bs-toggle="modal" class="btn-main-product">Add To cart</a>
                        </div>
                     </div>
                     <div class="card-product-info">
                        <a href="product-detail.html" class="title link">Beefy Chewin' Collagen Chews</a>
                        <span class="price"><span class="old-price">$98.00</span> $16.95</span>
                        <ul class="list-color-product">
                           <li class="list-color-item color-swatch active">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-10.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-10.jpg')}}" alt="image-product">
                           </li>
                           <li class="list-color-item color-swatch">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-11.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-11.jpg')}}" alt="image-product">
                           </li>
                        </ul>
                     </div>
                  </div>
                  <div class="card-product style-swatch-img wow fadeInUp" data-wow-delay="0s">
                     <div class="card-product-wrapper">
                        <a href="product-detail.html" class="product-img">
                        <img class="lazyload img-product" data-src="{{asset('frontend/images/products/pet-store/pet-store-12.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-12.jpg')}}" alt="image-product">
                        <img class="lazyload img-hover" data-src="{{asset('frontend/images/products/pet-store/pet-store-13.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-13.jpg')}}" alt="image-product">
                        </a>
                        <div class="list-product-btn">
                           <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                           <span class="icon icon-heart"></span>
                           <span class="tooltip">Wishlist</span>
                           </a>
                           <a href="#compare" data-bs-toggle="offcanvas" aria-controls="compare" class="box-icon compare btn-icon-action">
                           <span class="icon icon-gitDiff"></span>
                           <span class="tooltip">Compare</span>
                           </a>
                           <a href="#quickView" data-bs-toggle="modal" class="box-icon quickview tf-btn-loading">
                           <span class="icon icon-eye"></span>
                           <span class="tooltip">Quick View</span>
                           </a>
                        </div>
                        <div class="list-btn-main">
                           <a href="#shoppingCart" data-bs-toggle="modal" class="btn-main-product">Add To cart</a>
                        </div>
                     </div>
                     <div class="card-product-info">
                        <a href="product-detail.html" class="title link">Polarized sunglasses</a>
                        <span class="price"><span class="old-price">$98.00</span> $16.95</span>
                        <ul class="list-color-product">
                           <li class="list-color-item color-swatch active">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-12.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-12.jpg')}}" alt="image-product">
                           </li>
                           <li class="list-color-item color-swatch">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-13.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-13.jpg')}}" alt="image-product">
                           </li>
                           <li class="list-color-item color-swatch">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-14.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-14.jpg')}}" alt="image-product">
                           </li>
                        </ul>
                     </div>
                  </div>
                  <div class="card-product style-swatch-img wow fadeInUp" data-wow-delay="0.1s">
                     <div class="card-product-wrapper">
                        <a href="product-detail.html" class="product-img">
                        <img class="lazyload img-product" data-src="{{asset('frontend/images/products/pet-store/pet-store-15.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-15.jpg')}}" alt="image-product">
                        <img class="lazyload img-hover" data-src="{{asset('frontend/images/products/pet-store/pet-store-16.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-16.jpg')}}" alt="image-product">
                        </a>
                        <div class="on-sale-wrap"><span class="on-sale-item">-25%</span></div>
                        <div class="marquee-product bg-main">
                           <div class="marquee-wrapper">
                              <div class="initial-child-container">
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                              </div>
                           </div>
                           <div class="marquee-wrapper">
                              <div class="initial-child-container">
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="list-product-btn">
                           <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                           <span class="icon icon-heart"></span>
                           <span class="tooltip">Wishlist</span>
                           </a>
                           <a href="#compare" data-bs-toggle="offcanvas" aria-controls="compare" class="box-icon compare btn-icon-action">
                           <span class="icon icon-gitDiff"></span>
                           <span class="tooltip">Compare</span>
                           </a>
                           <a href="#quickView" data-bs-toggle="modal" class="box-icon quickview tf-btn-loading">
                           <span class="icon icon-eye"></span>
                           <span class="tooltip">Quick View</span>
                           </a>
                        </div>
                        <div class="list-btn-main">
                           <a href="#shoppingCart" data-bs-toggle="modal" class="btn-main-product">Add To cart</a>
                        </div>
                     </div>
                     <div class="card-product-info">
                        <a href="product-detail.html" class="title link">Dog Collars, Dog Leads</a>
                        <span class="price"><span class="old-price">$98.00</span> $16.95</span>
                        <ul class="list-color-product">
                           <li class="list-color-item color-swatch active">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-15.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-15.jpg')}}" alt="image-product">
                           </li>
                           <li class="list-color-item color-swatch">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-16.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-16.jpg')}}" alt="image-product">
                           </li>
                        </ul>
                     </div>
                  </div>
                  <div class="card-product style-swatch-img wow fadeInUp" data-wow-delay="0.2s">
                     <div class="card-product-wrapper">
                        <a href="product-detail.html" class="product-img">
                        <img class="lazyload img-product" data-src="{{asset('frontend/images/products/pet-store/pet-store-17.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-17.jpg')}}" alt="image-product">
                        <img class="lazyload img-hover" data-src="{{asset('frontend/images/products/pet-store/pet-store-18.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-18.jpg')}}" alt="image-product">
                        </a>
                        <div class="on-sale-wrap"><span class="on-sale-item">-25%</span></div>
                        <div class="list-product-btn">
                           <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                           <span class="icon icon-heart"></span>
                           <span class="tooltip">Wishlist</span>
                           </a>
                           <a href="#compare" data-bs-toggle="offcanvas" aria-controls="compare" class="box-icon compare btn-icon-action">
                           <span class="icon icon-gitDiff"></span>
                           <span class="tooltip">Compare</span>
                           </a>
                           <a href="#quickView" data-bs-toggle="modal" class="box-icon quickview tf-btn-loading">
                           <span class="icon icon-eye"></span>
                           <span class="tooltip">Quick View</span>
                           </a>
                        </div>
                        <div class="list-btn-main">
                           <a href="#shoppingCart" data-bs-toggle="modal" class="btn-main-product">Add To cart</a>
                        </div>
                     </div>
                     <div class="card-product-info">
                        <a href="product-detail.html" class="title link">Ramie shirt with pockets </a>
                        <span class="price"><span class="old-price">$98.00</span> $18.95</span>
                        <ul class="list-color-product">
                           <li class="list-color-item color-swatch active">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-17.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-17.jpg')}}" alt="image-product">
                           </li>
                           <li class="list-color-item color-swatch">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-18.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-18.jpg')}}" alt="image-product">
                           </li>
                        </ul>
                     </div>
                  </div>
                  <div class="card-product style-swatch-img wow fadeInUp" data-wow-delay="0.3s">
                     <div class="card-product-wrapper">
                        <a href="product-detail.html" class="product-img">
                        <img class="lazyload img-product" data-src="{{asset('frontend/images/products/pet-store/pet-store-19.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-19.jpg')}}" alt="image-product">
                        <img class="lazyload img-hover" data-src="{{asset('frontend/images/products/pet-store/pet-store-20.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-20.jpg')}}" alt="image-product">
                        </a>
                        <div class="list-product-btn">
                           <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                           <span class="icon icon-heart"></span>
                           <span class="tooltip">Wishlist</span>
                           </a>
                           <a href="#compare" data-bs-toggle="offcanvas" aria-controls="compare" class="box-icon compare btn-icon-action">
                           <span class="icon icon-gitDiff"></span>
                           <span class="tooltip">Compare</span>
                           </a>
                           <a href="#quickView" data-bs-toggle="modal" class="box-icon quickview tf-btn-loading">
                           <span class="icon icon-eye"></span>
                           <span class="tooltip">Quick View</span>
                           </a>
                        </div>
                        <div class="list-btn-main">
                           <a href="#shoppingCart" data-bs-toggle="modal" class="btn-main-product">Add To cart</a>
                        </div>
                     </div>
                     <div class="card-product-info">
                        <a href="product-detail.html" class="title link">Leather Dog Training Toy 2</a>
                        <span class="price"><span class="old-price">$98.00</span> $16.95</span>
                        <ul class="list-color-product">
                           <li class="list-color-item color-swatch active">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-19.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-19.jpg')}}" alt="image-product">
                           </li>
                           <li class="list-color-item color-swatch">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-20.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-20.jpg')}}" alt="image-product">
                           </li>
                           <li class="list-color-item color-swatch">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-21.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-21.jpg')}}" alt="image-product">
                           </li>
                        </ul>
                     </div>
                  </div>
                  <div class="card-product style-swatch-img wow fadeInUp" data-wow-delay="0.4s">
                     <div class="card-product-wrapper">
                        <a href="product-detail.html" class="product-img">
                        <img class="lazyload img-product" data-src="{{asset('frontend/images/products/pet-store/pet-store-1.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-1.jpg')}}" alt="image-product">
                        <img class="lazyload img-hover" data-src="{{asset('frontend/images/products/pet-store/pet-store-2.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-2.jpg')}}" alt="image-product">
                        </a>
                        <div class="list-product-btn">
                           <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                           <span class="icon icon-heart"></span>
                           <span class="tooltip">Wishlist</span>
                           </a>
                           <a href="#compare" data-bs-toggle="offcanvas" aria-controls="compare" class="box-icon compare btn-icon-action">
                           <span class="icon icon-gitDiff"></span>
                           <span class="tooltip">Compare</span>
                           </a>
                           <a href="#quickView" data-bs-toggle="modal" class="box-icon quickview tf-btn-loading">
                           <span class="icon icon-eye"></span>
                           <span class="tooltip">Quick View</span>
                           </a>
                        </div>
                        <div class="list-btn-main">
                           <a href="#shoppingCart" data-bs-toggle="modal" class="btn-main-product">Add To cart</a>
                        </div>
                     </div>
                     <div class="card-product-info">
                        <a href="product-detail.html" class="title link">Gobble  Grain-Free Gibble</a>
                        <span class="price"><span class="old-price">$98.00</span> $16.95</span>
                        <ul class="list-color-product">
                           <li class="list-color-item color-swatch active">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-1.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-1.jpg')}}" alt="image-product">
                           </li>
                           <li class="list-color-item color-swatch">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-2.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-2.jpg')}}" alt="image-product">
                           </li>
                        </ul>
                     </div>
                  </div>
               </div>
               <div class="sec-btn text-center">
                  <a href="shop-default-grid.html" class="btn-line">View All Products</a>
               </div>
            </div>
            <div class="tab-pane" id="ForDog" role="tabpanel">
               <div class="tf-grid-layout tf-col-2 lg-col-3 xl-col-5">
                  <div class="card-product style-swatch-img">
                     <div class="card-product-wrapper">
                        <a href="product-detail.html" class="product-img">
                        <img class="lazyload img-product" data-src="{{asset('frontend/images/products/pet-store/pet-store-1.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-1.jpg')}}" alt="image-product">
                        <img class="lazyload img-hover" data-src="{{asset('frontend/images/products/pet-store/pet-store-2.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-2.jpg')}}" alt="image-product">
                        </a>
                        <div class="list-product-btn">
                           <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                           <span class="icon icon-heart"></span>
                           <span class="tooltip">Wishlist</span>
                           </a>
                           <a href="#compare" data-bs-toggle="offcanvas" aria-controls="compare" class="box-icon compare btn-icon-action">
                           <span class="icon icon-gitDiff"></span>
                           <span class="tooltip">Compare</span>
                           </a>
                           <a href="#quickView" data-bs-toggle="modal" class="box-icon quickview tf-btn-loading">
                           <span class="icon icon-eye"></span>
                           <span class="tooltip">Quick View</span>
                           </a>
                        </div>
                        <div class="list-btn-main">
                           <a href="#shoppingCart" data-bs-toggle="modal" class="btn-main-product">Add To cart</a>
                        </div>
                     </div>
                     <div class="card-product-info">
                        <a href="product-detail.html" class="title link">Beefy Chewin' Collagen Chews</a>
                        <span class="price"><span class="old-price">$98.00</span> $16.95</span>
                        <ul class="list-color-product">
                           <li class="list-color-item color-swatch active">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-1.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-1.jpg')}}" alt="image-product">
                           </li>
                           <li class="list-color-item color-swatch">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-2.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-2.jpg')}}" alt="image-product">
                           </li>
                        </ul>
                     </div>
                  </div>
                  <div class="card-product style-swatch-img">
                     <div class="card-product-wrapper">
                        <a href="product-detail.html" class="product-img">
                        <img class="lazyload img-product" data-src="{{asset('frontend/images/products/pet-store/pet-store-3.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-3.jpg')}}" alt="image-product">
                        <img class="lazyload img-hover" data-src="{{asset('frontend/images/products/pet-store/pet-store-4.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-4.jpg')}}" alt="image-product">
                        </a>
                        <div class="on-sale-wrap"><span class="on-sale-item">-25%</span></div>
                        <div class="list-product-btn">
                           <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                           <span class="icon icon-heart"></span>
                           <span class="tooltip">Wishlist</span>
                           </a>
                           <a href="#compare" data-bs-toggle="offcanvas" aria-controls="compare" class="box-icon compare btn-icon-action">
                           <span class="icon icon-gitDiff"></span>
                           <span class="tooltip">Compare</span>
                           </a>
                           <a href="#quickView" data-bs-toggle="modal" class="box-icon quickview tf-btn-loading">
                           <span class="icon icon-eye"></span>
                           <span class="tooltip">Quick View</span>
                           </a>
                        </div>
                        <div class="list-btn-main">
                           <a href="#shoppingCart" data-bs-toggle="modal" class="btn-main-product">Add To cart</a>
                        </div>
                     </div>
                     <div class="card-product-info">
                        <a href="product-detail.html" class="title link">Adult Chicken & Brown Rice</a>
                        <span class="price"><span class="old-price">$98.00</span> $16.95</span>
                        <ul class="list-color-product">
                           <li class="list-color-item color-swatch active">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-3.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-3.jpg')}}" alt="image-product">
                           </li>
                           <li class="list-color-item color-swatch">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-4.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-4.jpg')}}" alt="image-product">
                           </li>
                           <li class="list-color-item color-swatch">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-5.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-5.jpg')}}" alt="image-product">
                           </li>
                        </ul>
                     </div>
                  </div>
                  <div class="card-product style-swatch-img">
                     <div class="card-product-wrapper">
                        <a href="product-detail.html" class="product-img">
                        <img class="lazyload img-product" data-src="{{asset('frontend/images/products/pet-store/pet-store-6.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-6.jpg')}}" alt="image-product">
                        <img class="lazyload img-hover" data-src="{{asset('frontend/images/products/pet-store/pet-store-7.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-7.jpg')}}" alt="image-product">
                        </a>
                        <div class="on-sale-wrap"><span class="on-sale-item">-25%</span></div>
                        <div class="marquee-product bg-main">
                           <div class="marquee-wrapper">
                              <div class="initial-child-container">
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                              </div>
                           </div>
                           <div class="marquee-wrapper">
                              <div class="initial-child-container">
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="list-product-btn">
                           <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                           <span class="icon icon-heart"></span>
                           <span class="tooltip">Wishlist</span>
                           </a>
                           <a href="#compare" data-bs-toggle="offcanvas" aria-controls="compare" class="box-icon compare btn-icon-action">
                           <span class="icon icon-gitDiff"></span>
                           <span class="tooltip">Compare</span>
                           </a>
                           <a href="#quickView" data-bs-toggle="modal" class="box-icon quickview tf-btn-loading">
                           <span class="icon icon-eye"></span>
                           <span class="tooltip">Quick View</span>
                           </a>
                        </div>
                        <div class="list-btn-main">
                           <a href="#shoppingCart" data-bs-toggle="modal" class="btn-main-product">Add To cart</a>
                        </div>
                     </div>
                     <div class="card-product-info">
                        <a href="product-detail.html" class="title link">Mix-a-Meal Original Recip</a>
                        <span class="price"><span class="old-price">$98.00</span> $16.95</span>
                        <ul class="list-color-product">
                           <li class="list-color-item color-swatch active">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-6.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-6.jpg')}}" alt="image-product">
                           </li>
                           <li class="list-color-item color-swatch">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-7.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-7.jpg')}}" alt="image-product">
                           </li>
                        </ul>
                     </div>
                  </div>
                  <div class="card-product style-swatch-img">
                     <div class="card-product-wrapper">
                        <a href="product-detail.html" class="product-img">
                        <img class="lazyload img-product" data-src="{{asset('frontend/images/products/pet-store/pet-store-8.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-8.jpg')}}" alt="image-product">
                        <img class="lazyload img-hover" data-src="{{asset('frontend/images/products/pet-store/pet-store-9.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-9.jpg')}}" alt="image-product">
                        </a>
                        <div class="on-sale-wrap"><span class="on-sale-item">-25%</span></div>
                        <div class="list-product-btn">
                           <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                           <span class="icon icon-heart"></span>
                           <span class="tooltip">Wishlist</span>
                           </a>
                           <a href="#compare" data-bs-toggle="offcanvas" aria-controls="compare" class="box-icon compare btn-icon-action">
                           <span class="icon icon-gitDiff"></span>
                           <span class="tooltip">Compare</span>
                           </a>
                           <a href="#quickView" data-bs-toggle="modal" class="box-icon quickview tf-btn-loading">
                           <span class="icon icon-eye"></span>
                           <span class="tooltip">Quick View</span>
                           </a>
                        </div>
                        <div class="list-btn-main">
                           <a href="#shoppingCart" data-bs-toggle="modal" class="btn-main-product">Add To cart</a>
                        </div>
                     </div>
                     <div class="card-product-info">
                        <a href="product-detail.html" class="title link">Beefy Toot Loops™ Crunchy</a>
                        <span class="price"><span class="old-price">$98.00</span> $16.95</span>
                        <ul class="list-color-product">
                           <li class="list-color-item color-swatch active">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-8.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-8.jpg')}}" alt="image-product">
                           </li>
                           <li class="list-color-item color-swatch">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-9.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-9.jpg')}}" alt="image-product">
                           </li>
                        </ul>
                     </div>
                  </div>
                  <div class="card-product style-swatch-img">
                     <div class="card-product-wrapper">
                        <a href="product-detail.html" class="product-img">
                        <img class="lazyload img-product" data-src="{{asset('frontend/images/products/pet-store/pet-store-10.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-10.jpg')}}" alt="image-product">
                        <img class="lazyload img-hover" data-src="{{asset('frontend/images/products/pet-store/pet-store-11.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-11.jpg')}}" alt="image-product">
                        </a>
                        <div class="list-product-btn">
                           <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                           <span class="icon icon-heart"></span>
                           <span class="tooltip">Wishlist</span>
                           </a>
                           <a href="#compare" data-bs-toggle="offcanvas" aria-controls="compare" class="box-icon compare btn-icon-action">
                           <span class="icon icon-gitDiff"></span>
                           <span class="tooltip">Compare</span>
                           </a>
                           <a href="#quickView" data-bs-toggle="modal" class="box-icon quickview tf-btn-loading">
                           <span class="icon icon-eye"></span>
                           <span class="tooltip">Quick View</span>
                           </a>
                        </div>
                        <div class="list-btn-main">
                           <a href="#shoppingCart" data-bs-toggle="modal" class="btn-main-product">Add To cart</a>
                        </div>
                     </div>
                     <div class="card-product-info">
                        <a href="product-detail.html" class="title link">Beefy Chewin' Collagen Chews</a>
                        <span class="price"><span class="old-price">$98.00</span> $16.95</span>
                        <ul class="list-color-product">
                           <li class="list-color-item color-swatch active">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-10.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-10.jpg')}}" alt="image-product">
                           </li>
                           <li class="list-color-item color-swatch">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-11.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-11.jpg')}}" alt="image-product">
                           </li>
                        </ul>
                     </div>
                  </div>
                  <div class="card-product style-swatch-img">
                     <div class="card-product-wrapper">
                        <a href="product-detail.html" class="product-img">
                        <img class="lazyload img-product" data-src="{{asset('frontend/images/products/pet-store/pet-store-12.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-12.jpg')}}" alt="image-product">
                        <img class="lazyload img-hover" data-src="{{asset('frontend/images/products/pet-store/pet-store-13.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-13.jpg')}}" alt="image-product">
                        </a>
                        <div class="list-product-btn">
                           <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                           <span class="icon icon-heart"></span>
                           <span class="tooltip">Wishlist</span>
                           </a>
                           <a href="#compare" data-bs-toggle="offcanvas" aria-controls="compare" class="box-icon compare btn-icon-action">
                           <span class="icon icon-gitDiff"></span>
                           <span class="tooltip">Compare</span>
                           </a>
                           <a href="#quickView" data-bs-toggle="modal" class="box-icon quickview tf-btn-loading">
                           <span class="icon icon-eye"></span>
                           <span class="tooltip">Quick View</span>
                           </a>
                        </div>
                        <div class="list-btn-main">
                           <a href="#shoppingCart" data-bs-toggle="modal" class="btn-main-product">Add To cart</a>
                        </div>
                     </div>
                     <div class="card-product-info">
                        <a href="product-detail.html" class="title link">Polarized sunglasses</a>
                        <span class="price"><span class="old-price">$98.00</span> $16.95</span>
                        <ul class="list-color-product">
                           <li class="list-color-item color-swatch active">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-12.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-12.jpg')}}" alt="image-product">
                           </li>
                           <li class="list-color-item color-swatch">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-13.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-13.jpg')}}" alt="image-product">
                           </li>
                           <li class="list-color-item color-swatch">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-14.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-14.jpg')}}" alt="image-product">
                           </li>
                        </ul>
                     </div>
                  </div>
                  <div class="card-product style-swatch-img">
                     <div class="card-product-wrapper">
                        <a href="product-detail.html" class="product-img">
                        <img class="lazyload img-product" data-src="{{asset('frontend/images/products/pet-store/pet-store-15.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-15.jpg')}}" alt="image-product">
                        <img class="lazyload img-hover" data-src="{{asset('frontend/images/products/pet-store/pet-store-16.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-16.jpg')}}" alt="image-product">
                        </a>
                        <div class="on-sale-wrap"><span class="on-sale-item">-25%</span></div>
                        <div class="marquee-product bg-main">
                           <div class="marquee-wrapper">
                              <div class="initial-child-container">
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                              </div>
                           </div>
                           <div class="marquee-wrapper">
                              <div class="initial-child-container">
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="list-product-btn">
                           <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                           <span class="icon icon-heart"></span>
                           <span class="tooltip">Wishlist</span>
                           </a>
                           <a href="#compare" data-bs-toggle="offcanvas" aria-controls="compare" class="box-icon compare btn-icon-action">
                           <span class="icon icon-gitDiff"></span>
                           <span class="tooltip">Compare</span>
                           </a>
                           <a href="#quickView" data-bs-toggle="modal" class="box-icon quickview tf-btn-loading">
                           <span class="icon icon-eye"></span>
                           <span class="tooltip">Quick View</span>
                           </a>
                        </div>
                        <div class="list-btn-main">
                           <a href="#shoppingCart" data-bs-toggle="modal" class="btn-main-product">Add To cart</a>
                        </div>
                     </div>
                     <div class="card-product-info">
                        <a href="product-detail.html" class="title link">Dog Collars, Dog Leads</a>
                        <span class="price"><span class="old-price">$98.00</span> $16.95</span>
                        <ul class="list-color-product">
                           <li class="list-color-item color-swatch active">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-15.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-15.jpg')}}" alt="image-product">
                           </li>
                           <li class="list-color-item color-swatch">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-16.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-16.jpg')}}" alt="image-product">
                           </li>
                        </ul>
                     </div>
                  </div>
                  <div class="card-product style-swatch-img">
                     <div class="card-product-wrapper">
                        <a href="product-detail.html" class="product-img">
                        <img class="lazyload img-product" data-src="{{asset('frontend/images/products/pet-store/pet-store-17.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-17.jpg')}}" alt="image-product">
                        <img class="lazyload img-hover" data-src="{{asset('frontend/images/products/pet-store/pet-store-18.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-18.jpg')}}" alt="image-product">
                        </a>
                        <div class="on-sale-wrap"><span class="on-sale-item">-25%</span></div>
                        <div class="list-product-btn">
                           <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                           <span class="icon icon-heart"></span>
                           <span class="tooltip">Wishlist</span>
                           </a>
                           <a href="#compare" data-bs-toggle="offcanvas" aria-controls="compare" class="box-icon compare btn-icon-action">
                           <span class="icon icon-gitDiff"></span>
                           <span class="tooltip">Compare</span>
                           </a>
                           <a href="#quickView" data-bs-toggle="modal" class="box-icon quickview tf-btn-loading">
                           <span class="icon icon-eye"></span>
                           <span class="tooltip">Quick View</span>
                           </a>
                        </div>
                        <div class="list-btn-main">
                           <a href="#shoppingCart" data-bs-toggle="modal" class="btn-main-product">Add To cart</a>
                        </div>
                     </div>
                     <div class="card-product-info">
                        <a href="product-detail.html" class="title link">Ramie shirt with pockets </a>
                        <span class="price"><span class="old-price">$98.00</span> $18.95</span>
                        <ul class="list-color-product">
                           <li class="list-color-item color-swatch active">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-17.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-17.jpg')}}" alt="image-product">
                           </li>
                           <li class="list-color-item color-swatch">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-18.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-18.jpg')}}" alt="image-product">
                           </li>
                        </ul>
                     </div>
                  </div>
                  <div class="card-product style-swatch-img">
                     <div class="card-product-wrapper">
                        <a href="product-detail.html" class="product-img">
                        <img class="lazyload img-product" data-src="{{asset('frontend/images/products/pet-store/pet-store-19.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-19.jpg')}}" alt="image-product">
                        <img class="lazyload img-hover" data-src="{{asset('frontend/images/products/pet-store/pet-store-20.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-20.jpg')}}" alt="image-product">
                        </a>
                        <div class="list-product-btn">
                           <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                           <span class="icon icon-heart"></span>
                           <span class="tooltip">Wishlist</span>
                           </a>
                           <a href="#compare" data-bs-toggle="offcanvas" aria-controls="compare" class="box-icon compare btn-icon-action">
                           <span class="icon icon-gitDiff"></span>
                           <span class="tooltip">Compare</span>
                           </a>
                           <a href="#quickView" data-bs-toggle="modal" class="box-icon quickview tf-btn-loading">
                           <span class="icon icon-eye"></span>
                           <span class="tooltip">Quick View</span>
                           </a>
                        </div>
                        <div class="list-btn-main">
                           <a href="#shoppingCart" data-bs-toggle="modal" class="btn-main-product">Add To cart</a>
                        </div>
                     </div>
                     <div class="card-product-info">
                        <a href="product-detail.html" class="title link">Leather Dog Training Toy 2</a>
                        <span class="price"><span class="old-price">$98.00</span> $16.95</span>
                        <ul class="list-color-product">
                           <li class="list-color-item color-swatch active">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-19.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-19.jpg')}}" alt="image-product">
                           </li>
                           <li class="list-color-item color-swatch">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-20.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-20.jpg')}}" alt="image-product">
                           </li>
                           <li class="list-color-item color-swatch">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-21.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-21.jpg')}}" alt="image-product">
                           </li>
                        </ul>
                     </div>
                  </div>
                  <div class="card-product style-swatch-img">
                     <div class="card-product-wrapper">
                        <a href="product-detail.html" class="product-img">
                        <img class="lazyload img-product" data-src="{{asset('frontend/images/products/pet-store/pet-store-1.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-1.jpg')}}" alt="image-product">
                        <img class="lazyload img-hover" data-src="{{asset('frontend/images/products/pet-store/pet-store-2.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-2.jpg')}}" alt="image-product">
                        </a>
                        <div class="list-product-btn">
                           <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                           <span class="icon icon-heart"></span>
                           <span class="tooltip">Wishlist</span>
                           </a>
                           <a href="#compare" data-bs-toggle="offcanvas" aria-controls="compare" class="box-icon compare btn-icon-action">
                           <span class="icon icon-gitDiff"></span>
                           <span class="tooltip">Compare</span>
                           </a>
                           <a href="#quickView" data-bs-toggle="modal" class="box-icon quickview tf-btn-loading">
                           <span class="icon icon-eye"></span>
                           <span class="tooltip">Quick View</span>
                           </a>
                        </div>
                        <div class="list-btn-main">
                           <a href="#shoppingCart" data-bs-toggle="modal" class="btn-main-product">Add To cart</a>
                        </div>
                     </div>
                     <div class="card-product-info">
                        <a href="product-detail.html" class="title link">Gobble  Grain-Free Gibble</a>
                        <span class="price"><span class="old-price">$98.00</span> $16.95</span>
                        <ul class="list-color-product">
                           <li class="list-color-item color-swatch active">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-1.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-1.jpg')}}" alt="image-product">
                           </li>
                           <li class="list-color-item color-swatch">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-2.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-2.jpg')}}" alt="image-product">
                           </li>
                        </ul>
                     </div>
                  </div>
               </div>
               <div class="sec-btn text-center">
                  <a href="shop-default-grid.html" class="btn-line">View All Products</a>
               </div>
            </div>
            <div class="tab-pane" id="SmallPet" role="tabpanel">
               <div class="tf-grid-layout tf-col-2 lg-col-3 xl-col-5">
                  <div class="card-product style-swatch-img">
                     <div class="card-product-wrapper">
                        <a href="product-detail.html" class="product-img">
                        <img class="lazyload img-product" data-src="{{asset('frontend/images/products/pet-store/pet-store-1.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-1.jpg')}}" alt="image-product">
                        <img class="lazyload img-hover" data-src="{{asset('frontend/images/products/pet-store/pet-store-2.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-2.jpg')}}" alt="image-product">
                        </a>
                        <div class="list-product-btn">
                           <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                           <span class="icon icon-heart"></span>
                           <span class="tooltip">Wishlist</span>
                           </a>
                           <a href="#compare" data-bs-toggle="offcanvas" aria-controls="compare" class="box-icon compare btn-icon-action">
                           <span class="icon icon-gitDiff"></span>
                           <span class="tooltip">Compare</span>
                           </a>
                           <a href="#quickView" data-bs-toggle="modal" class="box-icon quickview tf-btn-loading">
                           <span class="icon icon-eye"></span>
                           <span class="tooltip">Quick View</span>
                           </a>
                        </div>
                        <div class="list-btn-main">
                           <a href="#shoppingCart" data-bs-toggle="modal" class="btn-main-product">Add To cart</a>
                        </div>
                     </div>
                     <div class="card-product-info">
                        <a href="product-detail.html" class="title link">Beefy Chewin' Collagen Chews</a>
                        <span class="price"><span class="old-price">$98.00</span> $16.95</span>
                        <ul class="list-color-product">
                           <li class="list-color-item color-swatch active">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-1.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-1.jpg')}}" alt="image-product">
                           </li>
                           <li class="list-color-item color-swatch">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-2.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-2.jpg')}}" alt="image-product">
                           </li>
                        </ul>
                     </div>
                  </div>
                  <div class="card-product style-swatch-img">
                     <div class="card-product-wrapper">
                        <a href="product-detail.html" class="product-img">
                        <img class="lazyload img-product" data-src="{{asset('frontend/images/products/pet-store/pet-store-3.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-3.jpg')}}" alt="image-product">
                        <img class="lazyload img-hover" data-src="{{asset('frontend/images/products/pet-store/pet-store-4.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-4.jpg')}}" alt="image-product">
                        </a>
                        <div class="on-sale-wrap"><span class="on-sale-item">-25%</span></div>
                        <div class="list-product-btn">
                           <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                           <span class="icon icon-heart"></span>
                           <span class="tooltip">Wishlist</span>
                           </a>
                           <a href="#compare" data-bs-toggle="offcanvas" aria-controls="compare" class="box-icon compare btn-icon-action">
                           <span class="icon icon-gitDiff"></span>
                           <span class="tooltip">Compare</span>
                           </a>
                           <a href="#quickView" data-bs-toggle="modal" class="box-icon quickview tf-btn-loading">
                           <span class="icon icon-eye"></span>
                           <span class="tooltip">Quick View</span>
                           </a>
                        </div>
                        <div class="list-btn-main">
                           <a href="#shoppingCart" data-bs-toggle="modal" class="btn-main-product">Add To cart</a>
                        </div>
                     </div>
                     <div class="card-product-info">
                        <a href="product-detail.html" class="title link">Adult Chicken & Brown Rice</a>
                        <span class="price"><span class="old-price">$98.00</span> $16.95</span>
                        <ul class="list-color-product">
                           <li class="list-color-item color-swatch active">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-3.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-3.jpg')}}" alt="image-product">
                           </li>
                           <li class="list-color-item color-swatch">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-4.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-4.jpg')}}" alt="image-product">
                           </li>
                           <li class="list-color-item color-swatch">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-5.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-5.jpg')}}" alt="image-product">
                           </li>
                        </ul>
                     </div>
                  </div>
                  <div class="card-product style-swatch-img">
                     <div class="card-product-wrapper">
                        <a href="product-detail.html" class="product-img">
                        <img class="lazyload img-product" data-src="{{asset('frontend/images/products/pet-store/pet-store-6.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-6.jpg')}}" alt="image-product">
                        <img class="lazyload img-hover" data-src="{{asset('frontend/images/products/pet-store/pet-store-7.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-7.jpg')}}" alt="image-product">
                        </a>
                        <div class="on-sale-wrap"><span class="on-sale-item">-25%</span></div>
                        <div class="marquee-product bg-main">
                           <div class="marquee-wrapper">
                              <div class="initial-child-container">
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                              </div>
                           </div>
                           <div class="marquee-wrapper">
                              <div class="initial-child-container">
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="list-product-btn">
                           <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                           <span class="icon icon-heart"></span>
                           <span class="tooltip">Wishlist</span>
                           </a>
                           <a href="#compare" data-bs-toggle="offcanvas" aria-controls="compare" class="box-icon compare btn-icon-action">
                           <span class="icon icon-gitDiff"></span>
                           <span class="tooltip">Compare</span>
                           </a>
                           <a href="#quickView" data-bs-toggle="modal" class="box-icon quickview tf-btn-loading">
                           <span class="icon icon-eye"></span>
                           <span class="tooltip">Quick View</span>
                           </a>
                        </div>
                        <div class="list-btn-main">
                           <a href="#shoppingCart" data-bs-toggle="modal" class="btn-main-product">Add To cart</a>
                        </div>
                     </div>
                     <div class="card-product-info">
                        <a href="product-detail.html" class="title link">Mix-a-Meal Original Recip</a>
                        <span class="price"><span class="old-price">$98.00</span> $16.95</span>
                        <ul class="list-color-product">
                           <li class="list-color-item color-swatch active">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-6.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-6.jpg')}}" alt="image-product">
                           </li>
                           <li class="list-color-item color-swatch">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-7.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-7.jpg')}}" alt="image-product">
                           </li>
                        </ul>
                     </div>
                  </div>
                  <div class="card-product style-swatch-img">
                     <div class="card-product-wrapper">
                        <a href="product-detail.html" class="product-img">
                        <img class="lazyload img-product" data-src="{{asset('frontend/images/products/pet-store/pet-store-8.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-8.jpg')}}" alt="image-product">
                        <img class="lazyload img-hover" data-src="{{asset('frontend/images/products/pet-store/pet-store-9.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-9.jpg')}}" alt="image-product">
                        </a>
                        <div class="on-sale-wrap"><span class="on-sale-item">-25%</span></div>
                        <div class="list-product-btn">
                           <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                           <span class="icon icon-heart"></span>
                           <span class="tooltip">Wishlist</span>
                           </a>
                           <a href="#compare" data-bs-toggle="offcanvas" aria-controls="compare" class="box-icon compare btn-icon-action">
                           <span class="icon icon-gitDiff"></span>
                           <span class="tooltip">Compare</span>
                           </a>
                           <a href="#quickView" data-bs-toggle="modal" class="box-icon quickview tf-btn-loading">
                           <span class="icon icon-eye"></span>
                           <span class="tooltip">Quick View</span>
                           </a>
                        </div>
                        <div class="list-btn-main">
                           <a href="#shoppingCart" data-bs-toggle="modal" class="btn-main-product">Add To cart</a>
                        </div>
                     </div>
                     <div class="card-product-info">
                        <a href="product-detail.html" class="title link">Beefy Toot Loops™ Crunchy</a>
                        <span class="price"><span class="old-price">$98.00</span> $16.95</span>
                        <ul class="list-color-product">
                           <li class="list-color-item color-swatch active">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-8.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-8.jpg')}}" alt="image-product">
                           </li>
                           <li class="list-color-item color-swatch">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-9.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-9.jpg')}}" alt="image-product">
                           </li>
                        </ul>
                     </div>
                  </div>
                  <div class="card-product style-swatch-img">
                     <div class="card-product-wrapper">
                        <a href="product-detail.html" class="product-img">
                        <img class="lazyload img-product" data-src="{{asset('frontend/images/products/pet-store/pet-store-10.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-10.jpg')}}" alt="image-product">
                        <img class="lazyload img-hover" data-src="{{asset('frontend/images/products/pet-store/pet-store-11.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-11.jpg')}}" alt="image-product">
                        </a>
                        <div class="list-product-btn">
                           <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                           <span class="icon icon-heart"></span>
                           <span class="tooltip">Wishlist</span>
                           </a>
                           <a href="#compare" data-bs-toggle="offcanvas" aria-controls="compare" class="box-icon compare btn-icon-action">
                           <span class="icon icon-gitDiff"></span>
                           <span class="tooltip">Compare</span>
                           </a>
                           <a href="#quickView" data-bs-toggle="modal" class="box-icon quickview tf-btn-loading">
                           <span class="icon icon-eye"></span>
                           <span class="tooltip">Quick View</span>
                           </a>
                        </div>
                        <div class="list-btn-main">
                           <a href="#shoppingCart" data-bs-toggle="modal" class="btn-main-product">Add To cart</a>
                        </div>
                     </div>
                     <div class="card-product-info">
                        <a href="product-detail.html" class="title link">Beefy Chewin' Collagen Chews</a>
                        <span class="price"><span class="old-price">$98.00</span> $16.95</span>
                        <ul class="list-color-product">
                           <li class="list-color-item color-swatch active">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-10.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-10.jpg')}}" alt="image-product">
                           </li>
                           <li class="list-color-item color-swatch">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-11.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-11.jpg')}}" alt="image-product">
                           </li>
                        </ul>
                     </div>
                  </div>
                  <div class="card-product style-swatch-img">
                     <div class="card-product-wrapper">
                        <a href="product-detail.html" class="product-img">
                        <img class="lazyload img-product" data-src="{{asset('frontend/images/products/pet-store/pet-store-12.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-12.jpg')}}" alt="image-product">
                        <img class="lazyload img-hover" data-src="{{asset('frontend/images/products/pet-store/pet-store-13.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-13.jpg')}}" alt="image-product">
                        </a>
                        <div class="list-product-btn">
                           <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                           <span class="icon icon-heart"></span>
                           <span class="tooltip">Wishlist</span>
                           </a>
                           <a href="#compare" data-bs-toggle="offcanvas" aria-controls="compare" class="box-icon compare btn-icon-action">
                           <span class="icon icon-gitDiff"></span>
                           <span class="tooltip">Compare</span>
                           </a>
                           <a href="#quickView" data-bs-toggle="modal" class="box-icon quickview tf-btn-loading">
                           <span class="icon icon-eye"></span>
                           <span class="tooltip">Quick View</span>
                           </a>
                        </div>
                        <div class="list-btn-main">
                           <a href="#shoppingCart" data-bs-toggle="modal" class="btn-main-product">Add To cart</a>
                        </div>
                     </div>
                     <div class="card-product-info">
                        <a href="product-detail.html" class="title link">Polarized sunglasses</a>
                        <span class="price"><span class="old-price">$98.00</span> $16.95</span>
                        <ul class="list-color-product">
                           <li class="list-color-item color-swatch active">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-12.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-12.jpg')}}" alt="image-product">
                           </li>
                           <li class="list-color-item color-swatch">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-13.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-13.jpg')}}" alt="image-product">
                           </li>
                           <li class="list-color-item color-swatch">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-14.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-14.jpg')}}" alt="image-product">
                           </li>
                        </ul>
                     </div>
                  </div>
                  <div class="card-product style-swatch-img">
                     <div class="card-product-wrapper">
                        <a href="product-detail.html" class="product-img">
                        <img class="lazyload img-product" data-src="{{asset('frontend/images/products/pet-store/pet-store-15.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-15.jpg')}}" alt="image-product">
                        <img class="lazyload img-hover" data-src="{{asset('frontend/images/products/pet-store/pet-store-16.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-16.jpg')}}" alt="image-product">
                        </a>
                        <div class="on-sale-wrap"><span class="on-sale-item">-25%</span></div>
                        <div class="marquee-product bg-main">
                           <div class="marquee-wrapper">
                              <div class="initial-child-container">
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                              </div>
                           </div>
                           <div class="marquee-wrapper">
                              <div class="initial-child-container">
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="list-product-btn">
                           <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                           <span class="icon icon-heart"></span>
                           <span class="tooltip">Wishlist</span>
                           </a>
                           <a href="#compare" data-bs-toggle="offcanvas" aria-controls="compare" class="box-icon compare btn-icon-action">
                           <span class="icon icon-gitDiff"></span>
                           <span class="tooltip">Compare</span>
                           </a>
                           <a href="#quickView" data-bs-toggle="modal" class="box-icon quickview tf-btn-loading">
                           <span class="icon icon-eye"></span>
                           <span class="tooltip">Quick View</span>
                           </a>
                        </div>
                        <div class="list-btn-main">
                           <a href="#shoppingCart" data-bs-toggle="modal" class="btn-main-product">Add To cart</a>
                        </div>
                     </div>
                     <div class="card-product-info">
                        <a href="product-detail.html" class="title link">Dog Collars, Dog Leads</a>
                        <span class="price"><span class="old-price">$98.00</span> $16.95</span>
                        <ul class="list-color-product">
                           <li class="list-color-item color-swatch active">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-15.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-15.jpg')}}" alt="image-product">
                           </li>
                           <li class="list-color-item color-swatch">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-16.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-16.jpg')}}" alt="image-product">
                           </li>
                        </ul>
                     </div>
                  </div>
                  <div class="card-product style-swatch-img">
                     <div class="card-product-wrapper">
                        <a href="product-detail.html" class="product-img">
                        <img class="lazyload img-product" data-src="{{asset('frontend/images/products/pet-store/pet-store-17.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-17.jpg')}}" alt="image-product">
                        <img class="lazyload img-hover" data-src="{{asset('frontend/images/products/pet-store/pet-store-18.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-18.jpg')}}" alt="image-product">
                        </a>
                        <div class="on-sale-wrap"><span class="on-sale-item">-25%</span></div>
                        <div class="list-product-btn">
                           <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                           <span class="icon icon-heart"></span>
                           <span class="tooltip">Wishlist</span>
                           </a>
                           <a href="#compare" data-bs-toggle="offcanvas" aria-controls="compare" class="box-icon compare btn-icon-action">
                           <span class="icon icon-gitDiff"></span>
                           <span class="tooltip">Compare</span>
                           </a>
                           <a href="#quickView" data-bs-toggle="modal" class="box-icon quickview tf-btn-loading">
                           <span class="icon icon-eye"></span>
                           <span class="tooltip">Quick View</span>
                           </a>
                        </div>
                        <div class="list-btn-main">
                           <a href="#shoppingCart" data-bs-toggle="modal" class="btn-main-product">Add To cart</a>
                        </div>
                     </div>
                     <div class="card-product-info">
                        <a href="product-detail.html" class="title link">Ramie shirt with pockets </a>
                        <span class="price"><span class="old-price">$98.00</span> $18.95</span>
                        <ul class="list-color-product">
                           <li class="list-color-item color-swatch active">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-17.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-17.jpg')}}" alt="image-product">
                           </li>
                           <li class="list-color-item color-swatch">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-18.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-18.jpg')}}" alt="image-product">
                           </li>
                        </ul>
                     </div>
                  </div>
                  <div class="card-product style-swatch-img">
                     <div class="card-product-wrapper">
                        <a href="product-detail.html" class="product-img">
                        <img class="lazyload img-product" data-src="{{asset('frontend/images/products/pet-store/pet-store-19.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-19.jpg')}}" alt="image-product">
                        <img class="lazyload img-hover" data-src="{{asset('frontend/images/products/pet-store/pet-store-20.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-20.jpg')}}" alt="image-product">
                        </a>
                        <div class="list-product-btn">
                           <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                           <span class="icon icon-heart"></span>
                           <span class="tooltip">Wishlist</span>
                           </a>
                           <a href="#compare" data-bs-toggle="offcanvas" aria-controls="compare" class="box-icon compare btn-icon-action">
                           <span class="icon icon-gitDiff"></span>
                           <span class="tooltip">Compare</span>
                           </a>
                           <a href="#quickView" data-bs-toggle="modal" class="box-icon quickview tf-btn-loading">
                           <span class="icon icon-eye"></span>
                           <span class="tooltip">Quick View</span>
                           </a>
                        </div>
                        <div class="list-btn-main">
                           <a href="#shoppingCart" data-bs-toggle="modal" class="btn-main-product">Add To cart</a>
                        </div>
                     </div>
                     <div class="card-product-info">
                        <a href="product-detail.html" class="title link">Leather Dog Training Toy 2</a>
                        <span class="price"><span class="old-price">$98.00</span> $16.95</span>
                        <ul class="list-color-product">
                           <li class="list-color-item color-swatch active">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-19.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-19.jpg')}}" alt="image-product">
                           </li>
                           <li class="list-color-item color-swatch">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-20.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-20.jpg')}}" alt="image-product">
                           </li>
                           <li class="list-color-item color-swatch">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-21.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-21.jpg')}}" alt="image-product">
                           </li>
                        </ul>
                     </div>
                  </div>
                  <div class="card-product style-swatch-img">
                     <div class="card-product-wrapper">
                        <a href="product-detail.html" class="product-img">
                        <img class="lazyload img-product" data-src="{{asset('frontend/images/products/pet-store/pet-store-1.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-1.jpg')}}" alt="image-product">
                        <img class="lazyload img-hover" data-src="{{asset('frontend/images/products/pet-store/pet-store-2.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-2.jpg')}}" alt="image-product">
                        </a>
                        <div class="list-product-btn">
                           <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                           <span class="icon icon-heart"></span>
                           <span class="tooltip">Wishlist</span>
                           </a>
                           <a href="#compare" data-bs-toggle="offcanvas" aria-controls="compare" class="box-icon compare btn-icon-action">
                           <span class="icon icon-gitDiff"></span>
                           <span class="tooltip">Compare</span>
                           </a>
                           <a href="#quickView" data-bs-toggle="modal" class="box-icon quickview tf-btn-loading">
                           <span class="icon icon-eye"></span>
                           <span class="tooltip">Quick View</span>
                           </a>
                        </div>
                        <div class="list-btn-main">
                           <a href="#shoppingCart" data-bs-toggle="modal" class="btn-main-product">Add To cart</a>
                        </div>
                     </div>
                     <div class="card-product-info">
                        <a href="product-detail.html" class="title link">Gobble  Grain-Free Gibble</a>
                        <span class="price"><span class="old-price">$98.00</span> $16.95</span>
                        <ul class="list-color-product">
                           <li class="list-color-item color-swatch active">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-1.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-1.jpg')}}" alt="image-product">
                           </li>
                           <li class="list-color-item color-swatch">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-2.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-2.jpg')}}" alt="image-product">
                           </li>
                        </ul>
                     </div>
                  </div>
               </div>
               <div class="sec-btn text-center">
                  <a href="shop-default-grid.html" class="btn-line">View All Products</a>
               </div>
            </div>
            <div class="tab-pane" id="Pharmacy" role="tabpanel">
               <div class="tf-grid-layout tf-col-2 lg-col-3 xl-col-5">
                  <div class="card-product style-swatch-img">
                     <div class="card-product-wrapper">
                        <a href="product-detail.html" class="product-img">
                        <img class="lazyload img-product" data-src="{{asset('frontend/images/products/pet-store/pet-store-1.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-1.jpg')}}" alt="image-product">
                        <img class="lazyload img-hover" data-src="{{asset('frontend/images/products/pet-store/pet-store-2.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-2.jpg')}}" alt="image-product">
                        </a>
                        <div class="list-product-btn">
                           <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                           <span class="icon icon-heart"></span>
                           <span class="tooltip">Wishlist</span>
                           </a>
                           <a href="#compare" data-bs-toggle="offcanvas" aria-controls="compare" class="box-icon compare btn-icon-action">
                           <span class="icon icon-gitDiff"></span>
                           <span class="tooltip">Compare</span>
                           </a>
                           <a href="#quickView" data-bs-toggle="modal" class="box-icon quickview tf-btn-loading">
                           <span class="icon icon-eye"></span>
                           <span class="tooltip">Quick View</span>
                           </a>
                        </div>
                        <div class="list-btn-main">
                           <a href="#shoppingCart" data-bs-toggle="modal" class="btn-main-product">Add To cart</a>
                        </div>
                     </div>
                     <div class="card-product-info">
                        <a href="product-detail.html" class="title link">Beefy Chewin' Collagen Chews</a>
                        <span class="price"><span class="old-price">$98.00</span> $16.95</span>
                        <ul class="list-color-product">
                           <li class="list-color-item color-swatch active">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-1.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-1.jpg')}}" alt="image-product">
                           </li>
                           <li class="list-color-item color-swatch">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-2.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-2.jpg')}}" alt="image-product">
                           </li>
                        </ul>
                     </div>
                  </div>
                  <div class="card-product style-swatch-img">
                     <div class="card-product-wrapper">
                        <a href="product-detail.html" class="product-img">
                        <img class="lazyload img-product" data-src="{{asset('frontend/images/products/pet-store/pet-store-3.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-3.jpg')}}" alt="image-product">
                        <img class="lazyload img-hover" data-src="{{asset('frontend/images/products/pet-store/pet-store-4.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-4.jpg')}}" alt="image-product">
                        </a>
                        <div class="on-sale-wrap"><span class="on-sale-item">-25%</span></div>
                        <div class="list-product-btn">
                           <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                           <span class="icon icon-heart"></span>
                           <span class="tooltip">Wishlist</span>
                           </a>
                           <a href="#compare" data-bs-toggle="offcanvas" aria-controls="compare" class="box-icon compare btn-icon-action">
                           <span class="icon icon-gitDiff"></span>
                           <span class="tooltip">Compare</span>
                           </a>
                           <a href="#quickView" data-bs-toggle="modal" class="box-icon quickview tf-btn-loading">
                           <span class="icon icon-eye"></span>
                           <span class="tooltip">Quick View</span>
                           </a>
                        </div>
                        <div class="list-btn-main">
                           <a href="#shoppingCart" data-bs-toggle="modal" class="btn-main-product">Add To cart</a>
                        </div>
                     </div>
                     <div class="card-product-info">
                        <a href="product-detail.html" class="title link">Adult Chicken & Brown Rice</a>
                        <span class="price"><span class="old-price">$98.00</span> $16.95</span>
                        <ul class="list-color-product">
                           <li class="list-color-item color-swatch active">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-3.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-3.jpg')}}" alt="image-product">
                           </li>
                           <li class="list-color-item color-swatch">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-4.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-4.jpg')}}" alt="image-product">
                           </li>
                           <li class="list-color-item color-swatch">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-5.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-5.jpg')}}" alt="image-product">
                           </li>
                        </ul>
                     </div>
                  </div>
                  <div class="card-product style-swatch-img">
                     <div class="card-product-wrapper">
                        <a href="product-detail.html" class="product-img">
                        <img class="lazyload img-product" data-src="{{asset('frontend/images/products/pet-store/pet-store-6.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-6.jpg')}}" alt="image-product">
                        <img class="lazyload img-hover" data-src="{{asset('frontend/images/products/pet-store/pet-store-7.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-7.jpg')}}" alt="image-product">
                        </a>
                        <div class="on-sale-wrap"><span class="on-sale-item">-25%</span></div>
                        <div class="marquee-product bg-main">
                           <div class="marquee-wrapper">
                              <div class="initial-child-container">
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                              </div>
                           </div>
                           <div class="marquee-wrapper">
                              <div class="initial-child-container">
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="list-product-btn">
                           <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                           <span class="icon icon-heart"></span>
                           <span class="tooltip">Wishlist</span>
                           </a>
                           <a href="#compare" data-bs-toggle="offcanvas" aria-controls="compare" class="box-icon compare btn-icon-action">
                           <span class="icon icon-gitDiff"></span>
                           <span class="tooltip">Compare</span>
                           </a>
                           <a href="#quickView" data-bs-toggle="modal" class="box-icon quickview tf-btn-loading">
                           <span class="icon icon-eye"></span>
                           <span class="tooltip">Quick View</span>
                           </a>
                        </div>
                        <div class="list-btn-main">
                           <a href="#shoppingCart" data-bs-toggle="modal" class="btn-main-product">Add To cart</a>
                        </div>
                     </div>
                     <div class="card-product-info">
                        <a href="product-detail.html" class="title link">Mix-a-Meal Original Recip</a>
                        <span class="price"><span class="old-price">$98.00</span> $16.95</span>
                        <ul class="list-color-product">
                           <li class="list-color-item color-swatch active">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-6.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-6.jpg')}}" alt="image-product">
                           </li>
                           <li class="list-color-item color-swatch">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-7.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-7.jpg')}}" alt="image-product">
                           </li>
                        </ul>
                     </div>
                  </div>
                  <div class="card-product style-swatch-img">
                     <div class="card-product-wrapper">
                        <a href="product-detail.html" class="product-img">
                        <img class="lazyload img-product" data-src="{{asset('frontend/images/products/pet-store/pet-store-8.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-8.jpg')}}" alt="image-product">
                        <img class="lazyload img-hover" data-src="{{asset('frontend/images/products/pet-store/pet-store-9.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-9.jpg')}}" alt="image-product">
                        </a>
                        <div class="on-sale-wrap"><span class="on-sale-item">-25%</span></div>
                        <div class="list-product-btn">
                           <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                           <span class="icon icon-heart"></span>
                           <span class="tooltip">Wishlist</span>
                           </a>
                           <a href="#compare" data-bs-toggle="offcanvas" aria-controls="compare" class="box-icon compare btn-icon-action">
                           <span class="icon icon-gitDiff"></span>
                           <span class="tooltip">Compare</span>
                           </a>
                           <a href="#quickView" data-bs-toggle="modal" class="box-icon quickview tf-btn-loading">
                           <span class="icon icon-eye"></span>
                           <span class="tooltip">Quick View</span>
                           </a>
                        </div>
                        <div class="list-btn-main">
                           <a href="#shoppingCart" data-bs-toggle="modal" class="btn-main-product">Add To cart</a>
                        </div>
                     </div>
                     <div class="card-product-info">
                        <a href="product-detail.html" class="title link">Beefy Toot Loops™ Crunchy</a>
                        <span class="price"><span class="old-price">$98.00</span> $16.95</span>
                        <ul class="list-color-product">
                           <li class="list-color-item color-swatch active">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-8.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-8.jpg')}}" alt="image-product">
                           </li>
                           <li class="list-color-item color-swatch">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-9.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-9.jpg')}}" alt="image-product">
                           </li>
                        </ul>
                     </div>
                  </div>
                  <div class="card-product style-swatch-img">
                     <div class="card-product-wrapper">
                        <a href="product-detail.html" class="product-img">
                        <img class="lazyload img-product" data-src="{{asset('frontend/images/products/pet-store/pet-store-10.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-10.jpg')}}" alt="image-product">
                        <img class="lazyload img-hover" data-src="{{asset('frontend/images/products/pet-store/pet-store-11.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-11.jpg')}}" alt="image-product">
                        </a>
                        <div class="list-product-btn">
                           <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                           <span class="icon icon-heart"></span>
                           <span class="tooltip">Wishlist</span>
                           </a>
                           <a href="#compare" data-bs-toggle="offcanvas" aria-controls="compare" class="box-icon compare btn-icon-action">
                           <span class="icon icon-gitDiff"></span>
                           <span class="tooltip">Compare</span>
                           </a>
                           <a href="#quickView" data-bs-toggle="modal" class="box-icon quickview tf-btn-loading">
                           <span class="icon icon-eye"></span>
                           <span class="tooltip">Quick View</span>
                           </a>
                        </div>
                        <div class="list-btn-main">
                           <a href="#shoppingCart" data-bs-toggle="modal" class="btn-main-product">Add To cart</a>
                        </div>
                     </div>
                     <div class="card-product-info">
                        <a href="product-detail.html" class="title link">Beefy Chewin' Collagen Chews</a>
                        <span class="price"><span class="old-price">$98.00</span> $16.95</span>
                        <ul class="list-color-product">
                           <li class="list-color-item color-swatch active">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-10.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-10.jpg')}}" alt="image-product">
                           </li>
                           <li class="list-color-item color-swatch">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-11.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-11.jpg')}}" alt="image-product">
                           </li>
                        </ul>
                     </div>
                  </div>
                  <div class="card-product style-swatch-img">
                     <div class="card-product-wrapper">
                        <a href="product-detail.html" class="product-img">
                        <img class="lazyload img-product" data-src="{{asset('frontend/images/products/pet-store/pet-store-12.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-12.jpg')}}" alt="image-product">
                        <img class="lazyload img-hover" data-src="{{asset('frontend/images/products/pet-store/pet-store-13.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-13.jpg')}}" alt="image-product">
                        </a>
                        <div class="list-product-btn">
                           <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                           <span class="icon icon-heart"></span>
                           <span class="tooltip">Wishlist</span>
                           </a>
                           <a href="#compare" data-bs-toggle="offcanvas" aria-controls="compare" class="box-icon compare btn-icon-action">
                           <span class="icon icon-gitDiff"></span>
                           <span class="tooltip">Compare</span>
                           </a>
                           <a href="#quickView" data-bs-toggle="modal" class="box-icon quickview tf-btn-loading">
                           <span class="icon icon-eye"></span>
                           <span class="tooltip">Quick View</span>
                           </a>
                        </div>
                        <div class="list-btn-main">
                           <a href="#shoppingCart" data-bs-toggle="modal" class="btn-main-product">Add To cart</a>
                        </div>
                     </div>
                     <div class="card-product-info">
                        <a href="product-detail.html" class="title link">Polarized sunglasses</a>
                        <span class="price"><span class="old-price">$98.00</span> $16.95</span>
                        <ul class="list-color-product">
                           <li class="list-color-item color-swatch active">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-12.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-12.jpg')}}" alt="image-product">
                           </li>
                           <li class="list-color-item color-swatch">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-13.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-13.jpg')}}" alt="image-product">
                           </li>
                           <li class="list-color-item color-swatch">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-14.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-14.jpg')}}" alt="image-product">
                           </li>
                        </ul>
                     </div>
                  </div>
                  <div class="card-product style-swatch-img">
                     <div class="card-product-wrapper">
                        <a href="product-detail.html" class="product-img">
                        <img class="lazyload img-product" data-src="{{asset('frontend/images/products/pet-store/pet-store-15.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-15.jpg')}}" alt="image-product">
                        <img class="lazyload img-hover" data-src="{{asset('frontend/images/products/pet-store/pet-store-16.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-16.jpg')}}" alt="image-product">
                        </a>
                        <div class="on-sale-wrap"><span class="on-sale-item">-25%</span></div>
                        <div class="marquee-product bg-main">
                           <div class="marquee-wrapper">
                              <div class="initial-child-container">
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                              </div>
                           </div>
                           <div class="marquee-wrapper">
                              <div class="initial-child-container">
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="list-product-btn">
                           <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                           <span class="icon icon-heart"></span>
                           <span class="tooltip">Wishlist</span>
                           </a>
                           <a href="#compare" data-bs-toggle="offcanvas" aria-controls="compare" class="box-icon compare btn-icon-action">
                           <span class="icon icon-gitDiff"></span>
                           <span class="tooltip">Compare</span>
                           </a>
                           <a href="#quickView" data-bs-toggle="modal" class="box-icon quickview tf-btn-loading">
                           <span class="icon icon-eye"></span>
                           <span class="tooltip">Quick View</span>
                           </a>
                        </div>
                        <div class="list-btn-main">
                           <a href="#shoppingCart" data-bs-toggle="modal" class="btn-main-product">Add To cart</a>
                        </div>
                     </div>
                     <div class="card-product-info">
                        <a href="product-detail.html" class="title link">Dog Collars, Dog Leads</a>
                        <span class="price"><span class="old-price">$98.00</span> $16.95</span>
                        <ul class="list-color-product">
                           <li class="list-color-item color-swatch active">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-15.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-15.jpg')}}" alt="image-product">
                           </li>
                           <li class="list-color-item color-swatch">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-16.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-16.jpg')}}" alt="image-product">
                           </li>
                        </ul>
                     </div>
                  </div>
                  <div class="card-product style-swatch-img">
                     <div class="card-product-wrapper">
                        <a href="product-detail.html" class="product-img">
                        <img class="lazyload img-product" data-src="{{asset('frontend/images/products/pet-store/pet-store-17.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-17.jpg')}}" alt="image-product">
                        <img class="lazyload img-hover" data-src="{{asset('frontend/images/products/pet-store/pet-store-18.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-18.jpg')}}" alt="image-product">
                        </a>
                        <div class="on-sale-wrap"><span class="on-sale-item">-25%</span></div>
                        <div class="list-product-btn">
                           <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                           <span class="icon icon-heart"></span>
                           <span class="tooltip">Wishlist</span>
                           </a>
                           <a href="#compare" data-bs-toggle="offcanvas" aria-controls="compare" class="box-icon compare btn-icon-action">
                           <span class="icon icon-gitDiff"></span>
                           <span class="tooltip">Compare</span>
                           </a>
                           <a href="#quickView" data-bs-toggle="modal" class="box-icon quickview tf-btn-loading">
                           <span class="icon icon-eye"></span>
                           <span class="tooltip">Quick View</span>
                           </a>
                        </div>
                        <div class="list-btn-main">
                           <a href="#shoppingCart" data-bs-toggle="modal" class="btn-main-product">Add To cart</a>
                        </div>
                     </div>
                     <div class="card-product-info">
                        <a href="product-detail.html" class="title link">Ramie shirt with pockets </a>
                        <span class="price"><span class="old-price">$98.00</span> $18.95</span>
                        <ul class="list-color-product">
                           <li class="list-color-item color-swatch active">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-17.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-17.jpg')}}" alt="image-product">
                           </li>
                           <li class="list-color-item color-swatch">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-18.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-18.jpg')}}" alt="image-product">
                           </li>
                        </ul>
                     </div>
                  </div>
                  <div class="card-product style-swatch-img">
                     <div class="card-product-wrapper">
                        <a href="product-detail.html" class="product-img">
                        <img class="lazyload img-product" data-src="{{asset('frontend/images/products/pet-store/pet-store-19.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-19.jpg')}}" alt="image-product">
                        <img class="lazyload img-hover" data-src="{{asset('frontend/images/products/pet-store/pet-store-20.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-20.jpg')}}" alt="image-product">
                        </a>
                        <div class="list-product-btn">
                           <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                           <span class="icon icon-heart"></span>
                           <span class="tooltip">Wishlist</span>
                           </a>
                           <a href="#compare" data-bs-toggle="offcanvas" aria-controls="compare" class="box-icon compare btn-icon-action">
                           <span class="icon icon-gitDiff"></span>
                           <span class="tooltip">Compare</span>
                           </a>
                           <a href="#quickView" data-bs-toggle="modal" class="box-icon quickview tf-btn-loading">
                           <span class="icon icon-eye"></span>
                           <span class="tooltip">Quick View</span>
                           </a>
                        </div>
                        <div class="list-btn-main">
                           <a href="#shoppingCart" data-bs-toggle="modal" class="btn-main-product">Add To cart</a>
                        </div>
                     </div>
                     <div class="card-product-info">
                        <a href="product-detail.html" class="title link">Leather Dog Training Toy 2</a>
                        <span class="price"><span class="old-price">$98.00</span> $16.95</span>
                        <ul class="list-color-product">
                           <li class="list-color-item color-swatch active">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-19.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-19.jpg')}}" alt="image-product">
                           </li>
                           <li class="list-color-item color-swatch">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-20.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-20.jpg')}}" alt="image-product">
                           </li>
                           <li class="list-color-item color-swatch">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-21.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-21.jpg')}}" alt="image-product">
                           </li>
                        </ul>
                     </div>
                  </div>
                  <div class="card-product style-swatch-img">
                     <div class="card-product-wrapper">
                        <a href="product-detail.html" class="product-img">
                        <img class="lazyload img-product" data-src="{{asset('frontend/images/products/pet-store/pet-store-1.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-1.jpg')}}" alt="image-product">
                        <img class="lazyload img-hover" data-src="{{asset('frontend/images/products/pet-store/pet-store-2.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-2.jpg')}}" alt="image-product">
                        </a>
                        <div class="list-product-btn">
                           <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                           <span class="icon icon-heart"></span>
                           <span class="tooltip">Wishlist</span>
                           </a>
                           <a href="#compare" data-bs-toggle="offcanvas" aria-controls="compare" class="box-icon compare btn-icon-action">
                           <span class="icon icon-gitDiff"></span>
                           <span class="tooltip">Compare</span>
                           </a>
                           <a href="#quickView" data-bs-toggle="modal" class="box-icon quickview tf-btn-loading">
                           <span class="icon icon-eye"></span>
                           <span class="tooltip">Quick View</span>
                           </a>
                        </div>
                        <div class="list-btn-main">
                           <a href="#shoppingCart" data-bs-toggle="modal" class="btn-main-product">Add To cart</a>
                        </div>
                     </div>
                     <div class="card-product-info">
                        <a href="product-detail.html" class="title link">Gobble  Grain-Free Gibble</a>
                        <span class="price"><span class="old-price">$98.00</span> $16.95</span>
                        <ul class="list-color-product">
                           <li class="list-color-item color-swatch active">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-1.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-1.jpg')}}" alt="image-product">
                           </li>
                           <li class="list-color-item color-swatch">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-2.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-2.jpg')}}" alt="image-product">
                           </li>
                        </ul>
                     </div>
                  </div>
               </div>
               <div class="sec-btn text-center">
                  <a href="shop-default-grid.html" class="btn-line">View All Products</a>
               </div>
            </div>
            <div class="tab-pane" id="Sale" role="tabpanel">
               <div class="tf-grid-layout tf-col-2 lg-col-3 xl-col-5">
                  <div class="card-product style-swatch-img">
                     <div class="card-product-wrapper">
                        <a href="product-detail.html" class="product-img">
                        <img class="lazyload img-product" data-src="{{asset('frontend/images/products/pet-store/pet-store-1.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-1.jpg')}}" alt="image-product">
                        <img class="lazyload img-hover" data-src="{{asset('frontend/images/products/pet-store/pet-store-2.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-2.jpg')}}" alt="image-product">
                        </a>
                        <div class="list-product-btn">
                           <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                           <span class="icon icon-heart"></span>
                           <span class="tooltip">Wishlist</span>
                           </a>
                           <a href="#compare" data-bs-toggle="offcanvas" aria-controls="compare" class="box-icon compare btn-icon-action">
                           <span class="icon icon-gitDiff"></span>
                           <span class="tooltip">Compare</span>
                           </a>
                           <a href="#quickView" data-bs-toggle="modal" class="box-icon quickview tf-btn-loading">
                           <span class="icon icon-eye"></span>
                           <span class="tooltip">Quick View</span>
                           </a>
                        </div>
                        <div class="list-btn-main">
                           <a href="#shoppingCart" data-bs-toggle="modal" class="btn-main-product">Add To cart</a>
                        </div>
                     </div>
                     <div class="card-product-info">
                        <a href="product-detail.html" class="title link">Beefy Chewin' Collagen Chews</a>
                        <span class="price"><span class="old-price">$98.00</span> $16.95</span>
                        <ul class="list-color-product">
                           <li class="list-color-item color-swatch active">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-1.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-1.jpg')}}" alt="image-product">
                           </li>
                           <li class="list-color-item color-swatch">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-2.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-2.jpg')}}" alt="image-product">
                           </li>
                        </ul>
                     </div>
                  </div>
                  <div class="card-product style-swatch-img">
                     <div class="card-product-wrapper">
                        <a href="product-detail.html" class="product-img">
                        <img class="lazyload img-product" data-src="{{asset('frontend/images/products/pet-store/pet-store-3.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-3.jpg')}}" alt="image-product">
                        <img class="lazyload img-hover" data-src="{{asset('frontend/images/products/pet-store/pet-store-4.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-4.jpg')}}" alt="image-product">
                        </a>
                        <div class="on-sale-wrap"><span class="on-sale-item">-25%</span></div>
                        <div class="list-product-btn">
                           <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                           <span class="icon icon-heart"></span>
                           <span class="tooltip">Wishlist</span>
                           </a>
                           <a href="#compare" data-bs-toggle="offcanvas" aria-controls="compare" class="box-icon compare btn-icon-action">
                           <span class="icon icon-gitDiff"></span>
                           <span class="tooltip">Compare</span>
                           </a>
                           <a href="#quickView" data-bs-toggle="modal" class="box-icon quickview tf-btn-loading">
                           <span class="icon icon-eye"></span>
                           <span class="tooltip">Quick View</span>
                           </a>
                        </div>
                        <div class="list-btn-main">
                           <a href="#shoppingCart" data-bs-toggle="modal" class="btn-main-product">Add To cart</a>
                        </div>
                     </div>
                     <div class="card-product-info">
                        <a href="product-detail.html" class="title link">Adult Chicken & Brown Rice</a>
                        <span class="price"><span class="old-price">$98.00</span> $16.95</span>
                        <ul class="list-color-product">
                           <li class="list-color-item color-swatch active">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-3.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-3.jpg')}}" alt="image-product">
                           </li>
                           <li class="list-color-item color-swatch">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-4.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-4.jpg')}}" alt="image-product">
                           </li>
                           <li class="list-color-item color-swatch">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-5.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-5.jpg')}}" alt="image-product">
                           </li>
                        </ul>
                     </div>
                  </div>
                  <div class="card-product style-swatch-img">
                     <div class="card-product-wrapper">
                        <a href="product-detail.html" class="product-img">
                        <img class="lazyload img-product" data-src="{{asset('frontend/images/products/pet-store/pet-store-6.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-6.jpg')}}" alt="image-product">
                        <img class="lazyload img-hover" data-src="{{asset('frontend/images/products/pet-store/pet-store-7.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-7.jpg')}}" alt="image-product">
                        </a>
                        <div class="on-sale-wrap"><span class="on-sale-item">-25%</span></div>
                        <div class="marquee-product bg-main">
                           <div class="marquee-wrapper">
                              <div class="initial-child-container">
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                              </div>
                           </div>
                           <div class="marquee-wrapper">
                              <div class="initial-child-container">
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="list-product-btn">
                           <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                           <span class="icon icon-heart"></span>
                           <span class="tooltip">Wishlist</span>
                           </a>
                           <a href="#compare" data-bs-toggle="offcanvas" aria-controls="compare" class="box-icon compare btn-icon-action">
                           <span class="icon icon-gitDiff"></span>
                           <span class="tooltip">Compare</span>
                           </a>
                           <a href="#quickView" data-bs-toggle="modal" class="box-icon quickview tf-btn-loading">
                           <span class="icon icon-eye"></span>
                           <span class="tooltip">Quick View</span>
                           </a>
                        </div>
                        <div class="list-btn-main">
                           <a href="#shoppingCart" data-bs-toggle="modal" class="btn-main-product">Add To cart</a>
                        </div>
                     </div>
                     <div class="card-product-info">
                        <a href="product-detail.html" class="title link">Mix-a-Meal Original Recip</a>
                        <span class="price"><span class="old-price">$98.00</span> $16.95</span>
                        <ul class="list-color-product">
                           <li class="list-color-item color-swatch active">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-6.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-6.jpg')}}" alt="image-product">
                           </li>
                           <li class="list-color-item color-swatch">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-7.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-7.jpg')}}" alt="image-product">
                           </li>
                        </ul>
                     </div>
                  </div>
                  <div class="card-product style-swatch-img">
                     <div class="card-product-wrapper">
                        <a href="product-detail.html" class="product-img">
                        <img class="lazyload img-product" data-src="{{asset('frontend/images/products/pet-store/pet-store-8.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-8.jpg')}}" alt="image-product">
                        <img class="lazyload img-hover" data-src="{{asset('frontend/images/products/pet-store/pet-store-9.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-9.jpg')}}" alt="image-product">
                        </a>
                        <div class="on-sale-wrap"><span class="on-sale-item">-25%</span></div>
                        <div class="list-product-btn">
                           <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                           <span class="icon icon-heart"></span>
                           <span class="tooltip">Wishlist</span>
                           </a>
                           <a href="#compare" data-bs-toggle="offcanvas" aria-controls="compare" class="box-icon compare btn-icon-action">
                           <span class="icon icon-gitDiff"></span>
                           <span class="tooltip">Compare</span>
                           </a>
                           <a href="#quickView" data-bs-toggle="modal" class="box-icon quickview tf-btn-loading">
                           <span class="icon icon-eye"></span>
                           <span class="tooltip">Quick View</span>
                           </a>
                        </div>
                        <div class="list-btn-main">
                           <a href="#shoppingCart" data-bs-toggle="modal" class="btn-main-product">Add To cart</a>
                        </div>
                     </div>
                     <div class="card-product-info">
                        <a href="product-detail.html" class="title link">Beefy Toot Loops™ Crunchy</a>
                        <span class="price"><span class="old-price">$98.00</span> $16.95</span>
                        <ul class="list-color-product">
                           <li class="list-color-item color-swatch active">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-8.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-8.jpg')}}" alt="image-product">
                           </li>
                           <li class="list-color-item color-swatch">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-9.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-9.jpg')}}" alt="image-product">
                           </li>
                        </ul>
                     </div>
                  </div>
                  <div class="card-product style-swatch-img">
                     <div class="card-product-wrapper">
                        <a href="product-detail.html" class="product-img">
                        <img class="lazyload img-product" data-src="{{asset('frontend/images/products/pet-store/pet-store-10.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-10.jpg')}}" alt="image-product">
                        <img class="lazyload img-hover" data-src="{{asset('frontend/images/products/pet-store/pet-store-11.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-11.jpg')}}" alt="image-product">
                        </a>
                        <div class="list-product-btn">
                           <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                           <span class="icon icon-heart"></span>
                           <span class="tooltip">Wishlist</span>
                           </a>
                           <a href="#compare" data-bs-toggle="offcanvas" aria-controls="compare" class="box-icon compare btn-icon-action">
                           <span class="icon icon-gitDiff"></span>
                           <span class="tooltip">Compare</span>
                           </a>
                           <a href="#quickView" data-bs-toggle="modal" class="box-icon quickview tf-btn-loading">
                           <span class="icon icon-eye"></span>
                           <span class="tooltip">Quick View</span>
                           </a>
                        </div>
                        <div class="list-btn-main">
                           <a href="#shoppingCart" data-bs-toggle="modal" class="btn-main-product">Add To cart</a>
                        </div>
                     </div>
                     <div class="card-product-info">
                        <a href="product-detail.html" class="title link">Beefy Chewin' Collagen Chews</a>
                        <span class="price"><span class="old-price">$98.00</span> $16.95</span>
                        <ul class="list-color-product">
                           <li class="list-color-item color-swatch active">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-10.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-10.jpg')}}" alt="image-product">
                           </li>
                           <li class="list-color-item color-swatch">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-11.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-11.jpg')}}" alt="image-product">
                           </li>
                        </ul>
                     </div>
                  </div>
                  <div class="card-product style-swatch-img">
                     <div class="card-product-wrapper">
                        <a href="product-detail.html" class="product-img">
                        <img class="lazyload img-product" data-src="{{asset('frontend/images/products/pet-store/pet-store-12.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-12.jpg')}}" alt="image-product">
                        <img class="lazyload img-hover" data-src="{{asset('frontend/images/products/pet-store/pet-store-13.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-13.jpg')}}" alt="image-product">
                        </a>
                        <div class="list-product-btn">
                           <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                           <span class="icon icon-heart"></span>
                           <span class="tooltip">Wishlist</span>
                           </a>
                           <a href="#compare" data-bs-toggle="offcanvas" aria-controls="compare" class="box-icon compare btn-icon-action">
                           <span class="icon icon-gitDiff"></span>
                           <span class="tooltip">Compare</span>
                           </a>
                           <a href="#quickView" data-bs-toggle="modal" class="box-icon quickview tf-btn-loading">
                           <span class="icon icon-eye"></span>
                           <span class="tooltip">Quick View</span>
                           </a>
                        </div>
                        <div class="list-btn-main">
                           <a href="#shoppingCart" data-bs-toggle="modal" class="btn-main-product">Add To cart</a>
                        </div>
                     </div>
                     <div class="card-product-info">
                        <a href="product-detail.html" class="title link">Polarized sunglasses</a>
                        <span class="price"><span class="old-price">$98.00</span> $16.95</span>
                        <ul class="list-color-product">
                           <li class="list-color-item color-swatch active">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-12.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-12.jpg')}}" alt="image-product">
                           </li>
                           <li class="list-color-item color-swatch">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-13.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-13.jpg')}}" alt="image-product">
                           </li>
                           <li class="list-color-item color-swatch">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-14.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-14.jpg')}}" alt="image-product">
                           </li>
                        </ul>
                     </div>
                  </div>
                  <div class="card-product style-swatch-img">
                     <div class="card-product-wrapper">
                        <a href="product-detail.html" class="product-img">
                        <img class="lazyload img-product" data-src="{{asset('frontend/images/products/pet-store/pet-store-15.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-15.jpg')}}" alt="image-product">
                        <img class="lazyload img-hover" data-src="{{asset('frontend/images/products/pet-store/pet-store-16.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-16.jpg')}}" alt="image-product">
                        </a>
                        <div class="on-sale-wrap"><span class="on-sale-item">-25%</span></div>
                        <div class="marquee-product bg-main">
                           <div class="marquee-wrapper">
                              <div class="initial-child-container">
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                              </div>
                           </div>
                           <div class="marquee-wrapper">
                              <div class="initial-child-container">
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                                 <div class="marquee-child-item">
                                    <p class="font-2 text-btn-uppercase fw-6 text-white">Hot Sale 25% OFF</p>
                                 </div>
                                 <div class="marquee-child-item">
                                    <span class="icon icon-lightning text-critical"></span>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="list-product-btn">
                           <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                           <span class="icon icon-heart"></span>
                           <span class="tooltip">Wishlist</span>
                           </a>
                           <a href="#compare" data-bs-toggle="offcanvas" aria-controls="compare" class="box-icon compare btn-icon-action">
                           <span class="icon icon-gitDiff"></span>
                           <span class="tooltip">Compare</span>
                           </a>
                           <a href="#quickView" data-bs-toggle="modal" class="box-icon quickview tf-btn-loading">
                           <span class="icon icon-eye"></span>
                           <span class="tooltip">Quick View</span>
                           </a>
                        </div>
                        <div class="list-btn-main">
                           <a href="#shoppingCart" data-bs-toggle="modal" class="btn-main-product">Add To cart</a>
                        </div>
                     </div>
                     <div class="card-product-info">
                        <a href="product-detail.html" class="title link">Dog Collars, Dog Leads</a>
                        <span class="price"><span class="old-price">$98.00</span> $16.95</span>
                        <ul class="list-color-product">
                           <li class="list-color-item color-swatch active">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-15.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-15.jpg')}}" alt="image-product">
                           </li>
                           <li class="list-color-item color-swatch">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-16.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-16.jpg')}}" alt="image-product">
                           </li>
                        </ul>
                     </div>
                  </div>
                  <div class="card-product style-swatch-img">
                     <div class="card-product-wrapper">
                        <a href="product-detail.html" class="product-img">
                        <img class="lazyload img-product" data-src="{{asset('frontend/images/products/pet-store/pet-store-17.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-17.jpg')}}" alt="image-product">
                        <img class="lazyload img-hover" data-src="{{asset('frontend/images/products/pet-store/pet-store-18.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-18.jpg')}}" alt="image-product">
                        </a>
                        <div class="on-sale-wrap"><span class="on-sale-item">-25%</span></div>
                        <div class="list-product-btn">
                           <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                           <span class="icon icon-heart"></span>
                           <span class="tooltip">Wishlist</span>
                           </a>
                           <a href="#compare" data-bs-toggle="offcanvas" aria-controls="compare" class="box-icon compare btn-icon-action">
                           <span class="icon icon-gitDiff"></span>
                           <span class="tooltip">Compare</span>
                           </a>
                           <a href="#quickView" data-bs-toggle="modal" class="box-icon quickview tf-btn-loading">
                           <span class="icon icon-eye"></span>
                           <span class="tooltip">Quick View</span>
                           </a>
                        </div>
                        <div class="list-btn-main">
                           <a href="#shoppingCart" data-bs-toggle="modal" class="btn-main-product">Add To cart</a>
                        </div>
                     </div>
                     <div class="card-product-info">
                        <a href="product-detail.html" class="title link">Ramie shirt with pockets </a>
                        <span class="price"><span class="old-price">$98.00</span> $18.95</span>
                        <ul class="list-color-product">
                           <li class="list-color-item color-swatch active">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-17.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-17.jpg')}}" alt="image-product">
                           </li>
                           <li class="list-color-item color-swatch">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-18.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-18.jpg')}}" alt="image-product">
                           </li>
                        </ul>
                     </div>
                  </div>
                  <div class="card-product style-swatch-img">
                     <div class="card-product-wrapper">
                        <a href="product-detail.html" class="product-img">
                        <img class="lazyload img-product" data-src="{{asset('frontend/images/products/pet-store/pet-store-19.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-19.jpg')}}" alt="image-product">
                        <img class="lazyload img-hover" data-src="{{asset('frontend/images/products/pet-store/pet-store-20.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-20.jpg')}}" alt="image-product">
                        </a>
                        <div class="list-product-btn">
                           <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                           <span class="icon icon-heart"></span>
                           <span class="tooltip">Wishlist</span>
                           </a>
                           <a href="#compare" data-bs-toggle="offcanvas" aria-controls="compare" class="box-icon compare btn-icon-action">
                           <span class="icon icon-gitDiff"></span>
                           <span class="tooltip">Compare</span>
                           </a>
                           <a href="#quickView" data-bs-toggle="modal" class="box-icon quickview tf-btn-loading">
                           <span class="icon icon-eye"></span>
                           <span class="tooltip">Quick View</span>
                           </a>
                        </div>
                        <div class="list-btn-main">
                           <a href="#shoppingCart" data-bs-toggle="modal" class="btn-main-product">Add To cart</a>
                        </div>
                     </div>
                     <div class="card-product-info">
                        <a href="product-detail.html" class="title link">Leather Dog Training Toy 2</a>
                        <span class="price"><span class="old-price">$98.00</span> $16.95</span>
                        <ul class="list-color-product">
                           <li class="list-color-item color-swatch active">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-19.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-19.jpg')}}" alt="image-product">
                           </li>
                           <li class="list-color-item color-swatch">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-20.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-20.jpg')}}" alt="image-product">
                           </li>
                           <li class="list-color-item color-swatch">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-21.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-21.jpg')}}" alt="image-product">
                           </li>
                        </ul>
                     </div>
                  </div>
                  <div class="card-product style-swatch-img">
                     <div class="card-product-wrapper">
                        <a href="product-detail.html" class="product-img">
                        <img class="lazyload img-product" data-src="{{asset('frontend/images/products/pet-store/pet-store-1.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-1.jpg')}}" alt="image-product">
                        <img class="lazyload img-hover" data-src="{{asset('frontend/images/products/pet-store/pet-store-2.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-2.jpg')}}" alt="image-product">
                        </a>
                        <div class="list-product-btn">
                           <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                           <span class="icon icon-heart"></span>
                           <span class="tooltip">Wishlist</span>
                           </a>
                           <a href="#compare" data-bs-toggle="offcanvas" aria-controls="compare" class="box-icon compare btn-icon-action">
                           <span class="icon icon-gitDiff"></span>
                           <span class="tooltip">Compare</span>
                           </a>
                           <a href="#quickView" data-bs-toggle="modal" class="box-icon quickview tf-btn-loading">
                           <span class="icon icon-eye"></span>
                           <span class="tooltip">Quick View</span>
                           </a>
                        </div>
                        <div class="list-btn-main">
                           <a href="#shoppingCart" data-bs-toggle="modal" class="btn-main-product">Add To cart</a>
                        </div>
                     </div>
                     <div class="card-product-info">
                        <a href="product-detail.html" class="title link">Gobble  Grain-Free Gibble</a>
                        <span class="price"><span class="old-price">$98.00</span> $16.95</span>
                        <ul class="list-color-product">
                           <li class="list-color-item color-swatch active">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-1.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-1.jpg')}}" alt="image-product">
                           </li>
                           <li class="list-color-item color-swatch">
                              <img class="lazyload" data-src="{{asset('frontend/images/products/pet-store/pet-store-2.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-2.jpg')}}" alt="image-product">
                           </li>
                        </ul>
                     </div>
                  </div>
               </div>
               <div class="sec-btn text-center">
                  <a href="shop-default-grid.html" class="btn-line">View All Products</a>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<!-- /Top Picks -->
<!-- flash-sale -->
<section class="section-flash-sale">
   <div class="container">
      <div class="wrap">
         <div class="left">
            <h1 class="heading wow fadeInUp">Flash Sale!</h1>
            <p class="body-text-1 wow fadeInUp">Big Savings Up to 25% Off at the Shop</p>
            <ul>
               <li>
                  <h6 class="fw-6 wow fadeInUp"><a href="shop-categories-top.html" class="link">For Dog</a></h6>
               </li>
               <li>
                  <h6 class="fw-6 wow fadeInUp" data-wow-delay="0.1s"><a href="shop-categories-top.html" class="link">For Cat</a></h6>
               </li>
               <li>
                  <h6 class="fw-6 wow fadeInUp" data-wow-delay="0.2s"><a href="shop-categories-top.html" class="link">Small Pet</a></h6>
               </li>
            </ul>
         </div>
         <div class="image">
            <img class="lazyload" data-src="{{asset('frontend/images/section/flash-sale.png')}}" src="{{asset('frontend/images/section/flash-sale.png')}}" alt="">
         </div>
         <div class="right text-center">
            <h3 class="fw-6">Up To 25%</h3>
            <p class="body-text-1">Get 20% off if you spend 120$ or more!</p>
            <div class="tf-countdown-lg">
               <div class="js-countdown" data-timer="1007500" data-labels="Days,Hours,Mins,Secs"></div>
            </div>
            <a href="shop-default-grid.html" class="tf-btn btn-fill"><span class="text">Shop Now</span><i class="icon icon-arrowUpRight"></i></a>
         </div>
      </div>
   </div>
</section>
<!-- /flash-sale -->
<!-- Collection -->
<section class="flat-spacing">
   <div class="container">
      <div class="heading-section-2 wow fadeInUp">
         <h3>Deals Of The Day</h3>
         <div class="d-flex gap-12">
            <div class="nav-prev-collection d-none d-lg-flex nav-sw style-line nav-sw-left"><i class="icon icon-arrLeft"></i></div>
            <div class="nav-next-collection d-none d-lg-flex nav-sw style-line nav-sw-right"><i class="icon icon-arrRight"></i></div>
         </div>
      </div>
      <div dir="ltr" class="swiper tf-sw-collection wow fadeInUp" data-wow-delay="0.1s" data-preview="2" data-tablet="2" data-mobile-sm="1" data-mobile="1" data-space-lg="30" data-space-md="30" data-space="15" data-pagination="1" data-pagination-md="1" data-pagination-lg="1">
         <div class="swiper-wrapper">
            <div class="swiper-slide">
               <div class="card-product list-st-3">
                  <div class="inner-wrapper-card">
                     <div class="card-product-wrapper">
                        <a href="product-detail.html" class="product-img">
                        <img class="lazyload img-product" data-src="{{asset('frontend/images/products/pet-store/pet-store-22.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-22.jpg')}}" alt="image-product">
                        <img class="lazyload img-hover" data-src="{{asset('frontend/images/products/pet-store/pet-store-23.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-23.jpg')}}" alt="image-product">
                        </a>
                        <div class="on-sale-wrap"><span class="on-sale-item">-25%</span></div>
                     </div>
                     <div class="box-progress-stock">
                        <div class="progress">
                           <div class="progress-bar" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="stock-status d-flex justify-content-between align-items-center">
                           <div class="stock-item text-caption-1">
                              <span class="stock-label text-secondary-2">Available:</span>
                              <span class="stock-value">50</span>
                           </div>
                           <div class="stock-item text-caption-1">
                              <span class="stock-label text-secondary-2">Sold:</span>
                              <span class="stock-value">50</span>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="card-product-info">
                     <div class="archive-info-top">
                        <div class="inner-top">
                           <a href="product-detail.html" class="title link">Soft Baked Feline Morsels with Nutritious Ingredients</a>
                           <div class="box-rating">
                              <ul class="list-star">
                                 <li class="icon icon-star"></li>
                                 <li class="icon icon-star"></li>
                                 <li class="icon icon-star"></li>
                                 <li class="icon icon-star"></li>
                                 <li class="icon icon-star"></li>
                              </ul>
                              <span class="text-caption-1 text-secondary">(1.234)</span>
                           </div>
                           <span class="price"> $59.99</span>
                        </div>
                        <div class="inner-bottom">
                           <p class="description text-secondary text-caption-1 text-line-clamp-2">The garments labelled as Committed are products that have been produced...</p>
                           <div class="list-product-btn">
                              <a href="#shoppingCart" data-bs-toggle="modal" class="btn-main-product">Add To cart</a>
                              <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                              <span class="icon icon-heart"></span>
                              <span class="tooltip">Wishlist</span>
                              </a>
                              <a href="#compare" data-bs-toggle="offcanvas" aria-controls="compare" class="box-icon compare btn-icon-action">
                              <span class="icon icon-gitDiff"></span>
                              <span class="tooltip">Compare</span>
                              </a>
                           </div>
                        </div>
                     </div>
                     <div class="archive-info-bottom">
                        <div class="text-btn-uppercase fw-6 letter-1 d-none d-lg-block">Offer <br>
                           ends in:
                        </div>
                        <div class="countdown-box">
                           <div class="js-countdown" data-timer="1007500" data-labels="Days,Hours,Mins,Secs"></div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="swiper-slide">
               <div class="card-product list-st-3">
                  <div class="inner-wrapper-card">
                     <div class="card-product-wrapper">
                        <a href="product-detail.html" class="product-img">
                        <img class="lazyload img-product" data-src="{{asset('frontend/images/products/pet-store/pet-store-24.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-24.jpg')}}" alt="image-product">
                        <img class="lazyload img-hover" data-src="{{asset('frontend/images/products/pet-store/pet-store-25.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-25.jpg')}}" alt="image-product">
                        </a>
                        <div class="on-sale-wrap"><span class="on-sale-item">-25%</span></div>
                     </div>
                     <div class="box-progress-stock">
                        <div class="progress">
                           <div class="progress-bar" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="stock-status d-flex justify-content-between align-items-center">
                           <div class="stock-item text-caption-1">
                              <span class="stock-label text-secondary-2">Available:</span>
                              <span class="stock-value">50</span>
                           </div>
                           <div class="stock-item text-caption-1">
                              <span class="stock-label text-secondary-2">Sold:</span>
                              <span class="stock-value">50</span>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="card-product-info">
                     <div class="archive-info-top">
                        <div class="inner-top">
                           <a href="product-detail.html" class="title link">Soft Baked Feline Morsels with Nutritious Ingredients</a>
                           <div class="box-rating">
                              <ul class="list-star">
                                 <li class="icon icon-star"></li>
                                 <li class="icon icon-star"></li>
                                 <li class="icon icon-star"></li>
                                 <li class="icon icon-star"></li>
                                 <li class="icon icon-star"></li>
                              </ul>
                              <span class="text-caption-1 text-secondary">(1.234)</span>
                           </div>
                           <span class="price"> $59.99</span>
                        </div>
                        <div class="inner-bottom">
                           <p class="description text-secondary text-caption-1 text-line-clamp-2">Pawsome Fashion Hoodie, Stylish Cat Comfort Gear</p>
                           <div class="list-product-btn">
                              <a href="#shoppingCart" data-bs-toggle="modal" class="btn-main-product">Add To cart</a>
                              <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                              <span class="icon icon-heart"></span>
                              <span class="tooltip">Wishlist</span>
                              </a>
                              <a href="#compare" data-bs-toggle="offcanvas" aria-controls="compare" class="box-icon compare btn-icon-action">
                              <span class="icon icon-gitDiff"></span>
                              <span class="tooltip">Compare</span>
                              </a>
                           </div>
                        </div>
                     </div>
                     <div class="archive-info-bottom">
                        <div class="text-btn-uppercase fw-6 letter-1 d-none d-lg-block">Offer <br>
                           ends in:
                        </div>
                        <div class="countdown-box">
                           <div class="js-countdown" data-timer="1007500" data-labels="Days,Hours,Mins,Secs"></div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="swiper-slide">
               <div class="card-product list-st-3">
                  <div class="inner-wrapper-card">
                     <div class="card-product-wrapper">
                        <a href="product-detail.html" class="product-img">
                        <img class="lazyload img-product" data-src="{{asset('frontend/images/products/pet-store/pet-store-22.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-22.jpg')}}" alt="image-product">
                        <img class="lazyload img-hover" data-src="{{asset('frontend/images/products/pet-store/pet-store-23.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-23.jpg')}}" alt="image-product">
                        </a>
                        <div class="on-sale-wrap"><span class="on-sale-item">-25%</span></div>
                     </div>
                     <div class="box-progress-stock">
                        <div class="progress">
                           <div class="progress-bar" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="stock-status d-flex justify-content-between align-items-center">
                           <div class="stock-item text-caption-1">
                              <span class="stock-label text-secondary-2">Available:</span>
                              <span class="stock-value">50</span>
                           </div>
                           <div class="stock-item text-caption-1">
                              <span class="stock-label text-secondary-2">Sold:</span>
                              <span class="stock-value">50</span>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="card-product-info">
                     <div class="archive-info-top">
                        <div class="inner-top">
                           <a href="product-detail.html" class="title link">Soft Baked Feline Morsels with Nutritious Ingredients</a>
                           <div class="box-rating">
                              <ul class="list-star">
                                 <li class="icon icon-star"></li>
                                 <li class="icon icon-star"></li>
                                 <li class="icon icon-star"></li>
                                 <li class="icon icon-star"></li>
                                 <li class="icon icon-star"></li>
                              </ul>
                              <span class="text-caption-1 text-secondary">(1.234)</span>
                           </div>
                           <span class="price"> $59.99</span>
                        </div>
                        <div class="inner-bottom">
                           <p class="description text-secondary text-caption-1 text-line-clamp-2">The garments labelled as Committed are products that have been produced...</p>
                           <div class="list-product-btn">
                              <a href="#shoppingCart" data-bs-toggle="modal" class="btn-main-product">Add To cart</a>
                              <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                              <span class="icon icon-heart"></span>
                              <span class="tooltip">Wishlist</span>
                              </a>
                              <a href="#compare" data-bs-toggle="offcanvas" aria-controls="compare" class="box-icon compare btn-icon-action">
                              <span class="icon icon-gitDiff"></span>
                              <span class="tooltip">Compare</span>
                              </a>
                           </div>
                        </div>
                     </div>
                     <div class="archive-info-bottom">
                        <div class="text-btn-uppercase fw-6 letter-1 d-none d-lg-block">Offer <br>
                           ends in:
                        </div>
                        <div class="countdown-box">
                           <div class="js-countdown" data-timer="1007500" data-labels="Days,Hours,Mins,Secs"></div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<!-- /Collection -->
<!-- BANNER -->
<section class="">
   <div class="container">
      <div class="wg-big-save">
         <img class="lazyload" data-src="{{asset('frontend/images/section/big-save.jpg')}}" src="{{asset('frontend/images/section/big-save.jpg')}}" alt="img">
         <div class="content">
            <h3 class="heading wow fadeInUp">Big Savings Up To 25% Off <br> At The Modave Shop</h3>
            <div class="text body-text-1 wow fadeInUp">25% off select long-lasting edible chews</div>
            <a href="shop-default-grid.html" class="tf-btn btn-fill wow fadeInUp"><span class="text">Buy at a discount - 25%</span><i class="icon icon-arrowUpRight"></i></a>
         </div>
      </div>
   </div>
</section>
<!-- /BANNER -->
<!-- Maybe you will love -->
<section class="flat-spacing">
   <div class="container">
      <div class="heading-section-2 wow fadeInUp">
         <h3>Maybe you will love</h3>
         <a href="shop-default-grid.html" class="tf-btn btn-white rounded-full has-border"><span class="text">View All</span><i class="icon icon-arrowUpRight"></i></a>
      </div>
      <div class="tf-grid-layout sm-col-2 xl-col-3">
         <div class="card-product list-st-2 has-border wow fadeInUp" data-wow-delay="0s">
            <div class="card-product-wrapper">
               <a href="product-detail.html" class="product-img">
               <img class="lazyload img-product" data-src="{{asset('frontend/images/products/pet-store/pet-store-26.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-26.jpg')}}" alt="image-product">
               <img class="lazyload img-hover" data-src="{{asset('frontend/images/products/pet-store/pet-store-27.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-27.jpg')}}" alt="image-product">
               </a>
               <div class="on-sale-wrap"><span class="on-sale-item">-25%</span></div>
            </div>
            <div class="card-product-info">
               <a href="product-detail.html" class="title link">Cat Backpack Bubble Bag, Pet Space Bag Hiking Dog</a>
               <div class="bottom">
                  <div class="inner-left">
                     <div class="box-rating">
                        <ul class="list-star">
                           <li class="icon icon-star"></li>
                           <li class="icon icon-star"></li>
                           <li class="icon icon-star"></li>
                           <li class="icon icon-star"></li>
                           <li class="icon icon-star"></li>
                        </ul>
                        <span class="text-caption-1 text-secondary">(1.234)</span>
                     </div>
                     <span class="price py-4"> $59.99</span>
                  </div>
                  <a href="#shoppingCart" data-bs-toggle="modal" class="box-icon">
                     <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16.2187 10.3327V5.99935C16.2187 4.85008 15.7622 3.74788 14.9495 2.93522C14.1369 2.12256 13.0347 1.66602 11.8854 1.66602C10.7361 1.66602 9.63394 2.12256 8.82129 2.93522C8.00863 3.74788 7.55208 4.85008 7.55208 5.99935V10.3327M4.30208 8.16602H19.4687L20.5521 21.166H3.21875L4.30208 8.16602Z" stroke="#181818" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                     </svg>
                  </a>
               </div>
            </div>
         </div>
         <div class="card-product list-st-2 has-border wow fadeInUp" data-wow-delay="0.1s">
            <div class="card-product-wrapper">
               <a href="product-detail.html" class="product-img">
               <img class="lazyload img-product" data-src="{{asset('frontend/images/products/pet-store/pet-store-24.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-24.jpg')}}" alt="image-product">
               <img class="lazyload img-hover" data-src="{{asset('frontend/images/products/pet-store/pet-store-25.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-25.jpg')}}" alt="image-product">
               </a>
               <div class="on-sale-wrap"><span class="on-sale-item">-25%</span></div>
            </div>
            <div class="card-product-info">
               <a href="product-detail.html" class="title link">Pawsome Fashion Hoodie, Stylish Cat Comfort Gear</a>
               <div class="bottom">
                  <div class="inner-left">
                     <div class="box-rating">
                        <ul class="list-star">
                           <li class="icon icon-star"></li>
                           <li class="icon icon-star"></li>
                           <li class="icon icon-star"></li>
                           <li class="icon icon-star"></li>
                           <li class="icon icon-star"></li>
                        </ul>
                        <span class="text-caption-1 text-secondary">(1.234)</span>
                     </div>
                     <span class="price py-4"> $59.99</span>
                  </div>
                  <a href="#shoppingCart" data-bs-toggle="modal" class="box-icon">
                     <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16.2187 10.3327V5.99935C16.2187 4.85008 15.7622 3.74788 14.9495 2.93522C14.1369 2.12256 13.0347 1.66602 11.8854 1.66602C10.7361 1.66602 9.63394 2.12256 8.82129 2.93522C8.00863 3.74788 7.55208 4.85008 7.55208 5.99935V10.3327M4.30208 8.16602H19.4687L20.5521 21.166H3.21875L4.30208 8.16602Z" stroke="#181818" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                     </svg>
                  </a>
               </div>
            </div>
         </div>
         <div class="card-product list-st-2 has-border wow fadeInUp" data-wow-delay="0.2s">
            <div class="card-product-wrapper">
               <a href="product-detail.html" class="product-img">
               <img class="lazyload img-product" data-src="{{asset('frontend/images/products/pet-store/pet-store-28.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-28.jpg')}}" alt="image-product">
               <img class="lazyload img-hover" data-src="{{asset('frontend/images/products/pet-store/pet-store-29.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-29.jpg')}}" alt="image-product">
               </a>
               <div class="on-sale-wrap"><span class="on-sale-item">-25%</span></div>
            </div>
            <div class="card-product-info">
               <a href="product-detail.html" class="title link">Hoodie, Stylish dog Comfort Gear Pawsome Fashion</a>
               <div class="bottom">
                  <div class="inner-left">
                     <div class="box-rating">
                        <ul class="list-star">
                           <li class="icon icon-star"></li>
                           <li class="icon icon-star"></li>
                           <li class="icon icon-star"></li>
                           <li class="icon icon-star"></li>
                           <li class="icon icon-star"></li>
                        </ul>
                        <span class="text-caption-1 text-secondary">(1.234)</span>
                     </div>
                     <span class="price py-4"> $59.99</span>
                  </div>
                  <a href="#shoppingCart" data-bs-toggle="modal" class="box-icon">
                     <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16.2187 10.3327V5.99935C16.2187 4.85008 15.7622 3.74788 14.9495 2.93522C14.1369 2.12256 13.0347 1.66602 11.8854 1.66602C10.7361 1.66602 9.63394 2.12256 8.82129 2.93522C8.00863 3.74788 7.55208 4.85008 7.55208 5.99935V10.3327M4.30208 8.16602H19.4687L20.5521 21.166H3.21875L4.30208 8.16602Z" stroke="#181818" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                     </svg>
                  </a>
               </div>
            </div>
         </div>
         <div class="card-product list-st-2 has-border wow fadeInUp" data-wow-delay="0s">
            <div class="card-product-wrapper">
               <a href="product-detail.html" class="product-img">
               <img class="lazyload img-product" data-src="{{asset('frontend/images/products/pet-store/pet-store-30.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-30.jpg')}}" alt="image-product">
               <img class="lazyload img-hover" data-src="{{asset('frontend/images/products/pet-store/pet-store-31.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-31.jpg')}}" alt="image-product">
               </a>
               <div class="on-sale-wrap"><span class="on-sale-item">-25%</span></div>
            </div>
            <div class="card-product-info">
               <a href="product-detail.html" class="title link">Deluxe Cozy Cat Nook Bed with Memory Foam</a>
               <div class="bottom">
                  <div class="inner-left">
                     <div class="box-rating">
                        <ul class="list-star">
                           <li class="icon icon-star"></li>
                           <li class="icon icon-star"></li>
                           <li class="icon icon-star"></li>
                           <li class="icon icon-star"></li>
                           <li class="icon icon-star"></li>
                        </ul>
                        <span class="text-caption-1 text-secondary">(1.234)</span>
                     </div>
                     <span class="price py-4"> $59.99</span>
                  </div>
                  <a href="#shoppingCart" data-bs-toggle="modal" class="box-icon">
                     <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16.2187 10.3327V5.99935C16.2187 4.85008 15.7622 3.74788 14.9495 2.93522C14.1369 2.12256 13.0347 1.66602 11.8854 1.66602C10.7361 1.66602 9.63394 2.12256 8.82129 2.93522C8.00863 3.74788 7.55208 4.85008 7.55208 5.99935V10.3327M4.30208 8.16602H19.4687L20.5521 21.166H3.21875L4.30208 8.16602Z" stroke="#181818" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                     </svg>
                  </a>
               </div>
            </div>
         </div>
         <div class="card-product list-st-2 has-border wow fadeInUp" data-wow-delay="0.1s">
            <div class="card-product-wrapper">
               <a href="product-detail.html" class="product-img">
               <img class="lazyload img-product" data-src="{{asset('frontend/images/products/pet-store/pet-store-10.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-10.jpg')}}" alt="image-product">
               <img class="lazyload img-hover" data-src="{{asset('frontend/images/products/pet-store/pet-store-11.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-11.jpg')}}" alt="image-product">
               </a>
               <div class="on-sale-wrap"><span class="on-sale-item">-25%</span></div>
            </div>
            <div class="card-product-info">
               <a href="product-detail.html" class="title link">Cat Bed with this gorgeous new cat bed from DOGUE</a>
               <div class="bottom">
                  <div class="inner-left">
                     <div class="box-rating">
                        <ul class="list-star">
                           <li class="icon icon-star"></li>
                           <li class="icon icon-star"></li>
                           <li class="icon icon-star"></li>
                           <li class="icon icon-star"></li>
                           <li class="icon icon-star"></li>
                        </ul>
                        <span class="text-caption-1 text-secondary">(1.234)</span>
                     </div>
                     <span class="price py-4"> $59.99</span>
                  </div>
                  <a href="#shoppingCart" data-bs-toggle="modal" class="box-icon">
                     <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16.2187 10.3327V5.99935C16.2187 4.85008 15.7622 3.74788 14.9495 2.93522C14.1369 2.12256 13.0347 1.66602 11.8854 1.66602C10.7361 1.66602 9.63394 2.12256 8.82129 2.93522C8.00863 3.74788 7.55208 4.85008 7.55208 5.99935V10.3327M4.30208 8.16602H19.4687L20.5521 21.166H3.21875L4.30208 8.16602Z" stroke="#181818" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                     </svg>
                  </a>
               </div>
            </div>
         </div>
         <div class="card-product list-st-2 has-border wow fadeInUp" data-wow-delay="0.2s">
            <div class="card-product-wrapper">
               <a href="product-detail.html" class="product-img">
               <img class="lazyload img-product" data-src="{{asset('frontend/images/products/pet-store/pet-store-8.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-8.jpg')}}" alt="image-product">
               <img class="lazyload img-hover" data-src="{{asset('frontend/images/products/pet-store/pet-store-9.jpg')}}" src="{{asset('frontend/images/products/pet-store/pet-store-9.jpg')}}" alt="image-product">
               </a>
               <div class="on-sale-wrap"><span class="on-sale-item">-25%</span></div>
            </div>
            <div class="card-product-info">
               <a href="product-detail.html" class="title link">Beefy Toot Loops™ Crunchy Dog Treats - Beef Blend</a>
               <div class="bottom">
                  <div class="inner-left">
                     <div class="box-rating">
                        <ul class="list-star">
                           <li class="icon icon-star"></li>
                           <li class="icon icon-star"></li>
                           <li class="icon icon-star"></li>
                           <li class="icon icon-star"></li>
                           <li class="icon icon-star"></li>
                        </ul>
                        <span class="text-caption-1 text-secondary">(1.234)</span>
                     </div>
                     <span class="price py-4"> $59.99</span>
                  </div>
                  <a href="#shoppingCart" data-bs-toggle="modal" class="box-icon">
                     <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16.2187 10.3327V5.99935C16.2187 4.85008 15.7622 3.74788 14.9495 2.93522C14.1369 2.12256 13.0347 1.66602 11.8854 1.66602C10.7361 1.66602 9.63394 2.12256 8.82129 2.93522C8.00863 3.74788 7.55208 4.85008 7.55208 5.99935V10.3327M4.30208 8.16602H19.4687L20.5521 21.166H3.21875L4.30208 8.16602Z" stroke="#181818" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                     </svg>
                  </a>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<!-- /Maybe you will love -->
<!-- Latest new -->
<section class="flat-spacing pt-0">
   <div class="container">
      <div class="heading-section text-center wow fadeInUp">
         <h3 class="heading">News insight</h3>
         <p class="subheading text-secondary">Browse our Top Trending: the hottest picks loved by all.</p>
      </div>
      <div dir="ltr" class="swiper tf-sw-latest" data-preview="3" data-tablet="3" data-mobile="2" data-space-lg="30" data-space-md="30" data-space="15" data-pagination="1" data-pagination-md="1" data-pagination-lg="1">
         <div class="swiper-wrapper">
            <div class="swiper-slide">
               <div class="wg-blog style-1 hover-image wow fadeInUp" data-wow-delay="0s">
                  <div class="image">
                     <img class="lazyload" data-src="{{asset('frontend/images/blog/blog-grid-10.jpg')}}" src="{{asset('frontend/images/blog/blog-grid-10.jpg')}}" alt="">
                  </div>
                  <div class="content">
                     <p class="text-btn-uppercase text-secondary-2">13 August</p>
                     <div>
                        <h6 class="title fw-5">
                           <a class="link" href="blog-detail.html">Top 10 Summer Fashion Trends You Can't Miss in 2024</a>
                        </h6>
                        <div class="body-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. In sed vulputate massa.</div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="swiper-slide">
               <div class="wg-blog style-1 hover-image wow fadeInUp" data-wow-delay="0.1s">
                  <div class="image">
                     <img class="lazyload" data-src="{{asset('frontend/images/blog/blog-grid-11.jpg')}}" src="{{asset('frontend/images/blog/blog-grid-11.jpg')}}" alt="">
                  </div>
                  <div class="content">
                     <p class="text-btn-uppercase text-secondary-2">13 August</p>
                     <div>
                        <h6 class="title fw-5">
                           <a class="link" href="blog-detail.html">How to Effortlessly Style Your Office Wear for a Modern Look</a>
                        </h6>
                        <div class="body-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. In sed vulputate massa.</div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="swiper-slide">
               <div class="wg-blog style-1 hover-image wow fadeInUp" data-wow-delay="0.2s">
                  <div class="image">
                     <img class="lazyload" data-src="{{asset('frontend/images/blog/blog-grid-12.jpg')}}" src="{{asset('frontend/images/blog/blog-grid-12.jpg')}}" alt="">
                  </div>
                  <div class="content">
                     <p class="text-btn-uppercase text-secondary-2">13 August</p>
                     <div>
                        <h6 class="title fw-5">
                           <a class="link" href="blog-detail.html">Sustainable Fashion: Eco-Friendly Brands to Watch This Year</a>
                        </h6>
                        <div class="body-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. In sed vulputate massa.</div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="sw-pagination-latest sw-dots type-circle justify-content-center"></div>
      </div>
   </div>
</section>
<!-- /Latest new -->
<!-- Marquee -->
<section class="tf-marquee bg-light-pink-3 border-0">
   <div class="marquee-wrapper">
      <div class="initial-child-container">
         <div class="marquee-child-item">
            <p class="text-btn-uppercase">Free shipping on all orders over $20.00</p>
         </div>
         <div class="marquee-child-item">
            <span class="icon icon-lightning-line"></span>
         </div>
         <div class="marquee-child-item">
            <p class="text-btn-uppercase">Returns are free within 14 days</p>
         </div>
         <div class="marquee-child-item">
            <span class="icon icon-lightning-line"></span>
         </div>
         <!-- 2 -->
         <div class="marquee-child-item">
            <p class="text-btn-uppercase">Free shipping on all orders over $20.00</p>
         </div>
         <div class="marquee-child-item">
            <span class="icon icon-lightning-line"></span>
         </div>
         <div class="marquee-child-item">
            <p class="text-btn-uppercase">Returns are free within 14 days</p>
         </div>
         <div class="marquee-child-item">
            <span class="icon icon-lightning-line"></span>
         </div>
         <!-- 3 -->
         <div class="marquee-child-item">
            <p class="text-btn-uppercase">Free shipping on all orders over $20.00</p>
         </div>
         <div class="marquee-child-item">
            <span class="icon icon-lightning-line"></span>
         </div>
         <div class="marquee-child-item">
            <p class="text-btn-uppercase">Returns are free within 14 days</p>
         </div>
         <div class="marquee-child-item">
            <span class="icon icon-lightning-line"></span>
         </div>
         <!-- 4 -->
         <div class="marquee-child-item">
            <p class="text-btn-uppercase">Free shipping on all orders over $20.00</p>
         </div>
         <div class="marquee-child-item">
            <span class="icon icon-lightning-line"></span>
         </div>
         <div class="marquee-child-item">
            <p class="text-btn-uppercase">Returns are free within 14 days</p>
         </div>
         <div class="marquee-child-item">
            <span class="icon icon-lightning-line"></span>
         </div>
         <!-- 5 -->
         <div class="marquee-child-item">
            <p class="text-btn-uppercase">Free shipping on all orders over $20.00</p>
         </div>
         <div class="marquee-child-item">
            <span class="icon icon-lightning-line"></span>
         </div>
         <div class="marquee-child-item">
            <p class="text-btn-uppercase">Returns are free within 14 days</p>
         </div>
         <div class="marquee-child-item">
            <span class="icon icon-lightning-line"></span>
         </div>
         <!-- 6 -->
         <div class="marquee-child-item">
            <p class="text-btn-uppercase">Free shipping on all orders over $20.00</p>
         </div>
         <div class="marquee-child-item">
            <span class="icon icon-lightning-line"></span>
         </div>
         <div class="marquee-child-item">
            <p class="text-btn-uppercase">Returns are free within 14 days</p>
         </div>
         <div class="marquee-child-item">
            <span class="icon icon-lightning-line"></span>
         </div>
      </div>
   </div>
</section>
<!-- /Marquee -->
<script>
   document.addEventListener("DOMContentLoaded", function () {
      document.querySelectorAll(".shubham-category .row ul.facet-body").forEach(function (ul) {
         let closestCol = ul.closest(".my-col"); // Find the closest `.my-col`

         if (closestCol) {
               let parentCategory = closestCol.closest(".shubham-category"); // Get the `.shubham-category` container
               
               if (parentCategory) {
                  let leftOffset = closestCol.offsetLeft - parentCategory.offsetLeft; // Calculate relative left position
                  console.log('Left Offset (relative to .shubham-category):', leftOffset); // Debugging
                  ul.style.left = `-${leftOffset - 5}px`; // Adjust position
               }
         }
      });
   });

   document.addEventListener("DOMContentLoaded", function () {
      document.querySelectorAll(".shubham-category .row ul.facet-body").forEach(function (ul) {
         let categoryContainer = document.querySelector(".shubham-category"); // Select the parent container
         
         if (categoryContainer) {
               ul.style.width = `${categoryContainer.clientWidth - 40}px`; // Set ul width equal to .shubham-category width
         }
      });
   });

</script>
@endsection