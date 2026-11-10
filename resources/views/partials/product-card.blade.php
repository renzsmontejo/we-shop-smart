<article class="product-card">
    <div class="product-image-wrap">
        @if(!empty($product['badge']))
            <span class="product-badge">{{ $product['badge'] }}</span>
        @endif
        <img src="{{ asset('images/storefront/'.$product['image']) }}" alt="{{ $product['name'] }}" loading="lazy">
    </div>
    <div class="product-info">
        <div class="product-topline"><span>{{ $product['brand'] }}</span><span class="rating">★ {{ number_format($product['rating'], 1) }} <span class="review-count">({{ $product['reviews'] }})</span></span></div>
        <h3>{{ $product['name'] }}</h3>
        <div class="price-row"><strong>₱{{ number_format($product['price']) }}</strong>@if($product['old_price'])<s>₱{{ number_format($product['old_price']) }}</s>@endif</div>
        <form method="POST" action="{{ route('storefront.cart.add') }}">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product['id'] }}">
            <button class="add-to-cart" type="submit">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M4 8h16l-1.5 12h-13L4 8Z"/><path d="M9 9V6a3 3 0 0 1 6 0v3"/></svg>
                Add to cart
            </button>
        </form>
    </div>
</article>
