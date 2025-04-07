@php
    use App\Models\CartItem;
    use App\Models\Cart;

    $user = auth()->user();
    $cartItems = [];

    if ($user) {
        $cart = Cart::where('user_id', $user->id)->first();
        if ($cart) {
            $cartItems = CartItem::where('cart_id', $cart->id)
                ->pluck('quantity', 'product_id')
                ->toArray();
        }
    }

    $price = App\Http\Controllers\UserController::getProductPriceForUser($product->id);
    $currentQuantity = isset($cartItems[$product->id]) ? $cartItems[$product->id] : 0;
@endphp

<div class="card-product grid" data-availability="Out of stock" data-brand="adidas">
    <div class="card-product-wrapper">
        <a href="{{ url('product-detail/' . $product->slug) }}" class="product-img">
            @php
                $defaultImage = isset($product->image[0]) ? asset('storage/' . $product->image[0]) : asset('frontend/images/placeholder.jpg');
                $hoverImage = isset($product->image[1]) ? asset('storage/' . $product->image[1]) : $defaultImage;
            @endphp

            <img class="lazyload img-product" data-src="{{ $defaultImage }}" src="{{ $defaultImage }}" alt="image-product">
            <img class="lazyload img-hover" data-src="{{ $hoverImage }}" src="{{ $hoverImage }}" alt="image-product">
        </a>

        @auth
        <div class="list-btn-main d-block">
            <div class="quantity-selector d-flex">
                <button class="decrement">-</button>
                <input type="number" class="product-qty" id="qty-{{ $product->id }}" value="{{ $currentQuantity }}" min="0" disabled="true">
                <button class="increment">+</button>
            </div>
            <div>
                @if ($currentQuantity <= 0)
                    <a href="#shoppingCart" data-id="{{ $product->id }}" data-url="{{ url('update-cart', $product->id) }}" class="btn-main-product add-cart">Add To Cart</a>
                @else
                    <a href="#shoppingCart" data-id="{{ $product->id }}" data-url="{{ url('update-cart', $product->id) }}" class="btn-main-product add-cart">Update Cart</a>
                @endif
            </div>
        </div>
        @endauth
    </div>

    <div class="card-product-info">
        <a href="{{ url('product-detail/' . $product->slug) }}" class="title link">{{ $product->name }}</a>
        @if (auth()->user() && !auth()->user()->hasRole('complete-franchise'))
            <span class="price current-price">${{ $price }}</span>
        @endif
    </div>
</div>

