<div class="wrapper-shop row">
    @if($products->count() > 0)
        @foreach ($products as $product)
            <div class="col-6 col-md-3 col-lg-2">
                @include('components.product-card', ['product' => $product])
            </div>
        @endforeach
    @else
        <p class="text-center">No products available in this category.</p>
    @endif
</div>