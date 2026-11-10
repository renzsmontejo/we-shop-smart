@extends('layouts.app-layout')
@section('title', 'Shopping Cart')
@section('nav_title', 'Shopping cart')
@section('active', 'cart')

@section('content')
    <nav class="breadcrumbs" aria-label="Breadcrumb"><a href="{{ route('storefront.home') }}">Home</a><span aria-hidden="true">/</span><span aria-current="page">Cart</span></nav>
    <div class="page-head cart-page-head"><div><span class="eyebrow">YOUR SELECTIONS</span><h1>Shopping cart</h1><p>Review your items and update quantities before proceeding.</p></div><a class="page-head-action" href="{{ route('storefront.shop') }}">Continue shopping <span aria-hidden="true">→</span></a></div>

    @if(count($items))
        <div class="cart-layout">
            <div class="cart-items-panel">
                <div class="cart-panel-heading"><h2>Cart items</h2><span>{{ $cartCount }} {{ $cartCount === 1 ? 'item' : 'items' }}</span></div>
                <div class="cart-items">
                    @foreach($items as $item)
                        <article class="cart-item">
                            <div class="cart-item-image"><img src="{{ asset('images/storefront/'.$item['product']['image']) }}" alt="{{ $item['product']['name'] }}"></div>
                            <div class="cart-item-main"><span class="cart-item-brand">{{ $item['product']['brand'] }}</span><h3>{{ $item['product']['name'] }}</h3><p>₱{{ number_format($item['product']['price']) }} each</p>
                                <form class="cart-quantity-form" action="{{ route('storefront.cart.update') }}" method="POST">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="product_id" value="{{ $item['product']['id'] }}">
                                    <label for="qty-{{ $item['product']['id'] }}">Qty</label>
                                    <input id="qty-{{ $item['product']['id'] }}" type="number" min="0" max="99" name="quantity" value="{{ $item['quantity'] }}">
                                    <button type="submit">Update</button><span class="quantity-hint">Use 0 to remove</span>
                                </form>
                            </div>
                            <strong class="cart-line-price">₱{{ number_format($item['lineTotal']) }}</strong>
                        </article>
                    @endforeach
                </div>
            </div>
            <aside class="order-summary" aria-label="Order summary">
                <h2>Order summary</h2>
                <div class="summary-row"><span>Subtotal ({{ $cartCount }} items)</span><strong>₱{{ number_format($subtotal) }}</strong></div>
                <div class="summary-row"><span>Shipping</span><span>Not calculated</span></div>
                <div class="summary-total"><span>Subtotal</span><strong>₱{{ number_format($subtotal) }}</strong></div>
                <p class="checkout-note">Checkout and payment have not been connected to this demo storefront.</p>
                <a href="{{ route('storefront.shop') }}" class="button button-blue full-width">Continue shopping <span aria-hidden="true">→</span></a>
            </aside>
        </div>
    @else
        <div class="empty-state cart-empty"><div class="empty-icon" aria-hidden="true">▢</div><h2>Your cart is empty</h2><p>Browse the shop and add products you like.</p><a href="{{ route('storefront.shop') }}" class="button button-blue">Explore products <span aria-hidden="true">→</span></a></div>
    @endif
@endsection
