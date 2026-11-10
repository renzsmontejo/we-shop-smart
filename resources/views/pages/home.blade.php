@extends('layouts.app-layout')
@section('title', 'Home')
@section('nav_title', 'Home')
@section('active', 'home')

@section('content')
    <div class="page-head home-page-head">
        <div><span class="eyebrow">WELCOME TO WE SHOP SMART</span><h1>Shop smarter, every day.</h1><p>Explore useful finds for your home, work, and everyday routine.</p></div>
        <a class="page-head-action" href="{{ route('storefront.shop') }}">Browse all products <span aria-hidden="true">→</span></a>
    </div>

    <section class="home-hero" aria-labelledby="home-hero-title">
        <div class="hero-content">
            <span class="hero-eyebrow"><span class="hero-dot"></span> WSS PRODUCT SELECTION</span>
            <h2 id="home-hero-title">Good products.<br>Better choices.</h2>
            <p>Discover practical essentials at clear prices. Find what you need without the extra noise.</p>
            <div class="hero-buttons">
                <a href="{{ route('storefront.shop') }}" class="button button-white">Shop the collection <span aria-hidden="true">→</span></a>
                <a href="{{ route('storefront.shop', ['sort' => 'rating']) }}" class="hero-secondary">View top rated</a>
            </div>
        </div>
        @if(count($featured))
            <div class="hero-product">
                <div class="hero-product-label"><span>FEATURED PRODUCT</span><span>01 / WSS</span></div>
                <img src="{{ asset('images/storefront/'.$featured[0]['image']) }}" alt="{{ $featured[0]['name'] }}">
                <div class="hero-product-details"><span>{{ $featured[0]['name'] }}</span><strong>₱{{ number_format($featured[0]['price']) }}</strong></div>
            </div>
        @endif
    </section>

    <section class="benefit-strip" aria-label="Shopping features">
        <div><span class="benefit-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="m3 12 6 6L21 6"/></svg></span><span><strong>Clear prices</strong><small>See product prices upfront</small></span></div>
        <div><span class="benefit-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M4 8h16l-1.5 12h-13L4 8Z"/><path d="M9 9V6a3 3 0 0 1 6 0v3"/></svg></span><span><strong>Simple shopping cart</strong><small>Manage your selections easily</small></span></div>
        <div><span class="benefit-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="10.8" cy="10.8" r="6.8"/><path d="m16 16 5 5"/></svg></span><span><strong>Easy product search</strong><small>Find items and filter results</small></span></div>
    </section>

    <section class="section-block" aria-labelledby="categories-title">
        <div class="section-head"><div><span class="eyebrow">BROWSE BY TYPE</span><h2 id="categories-title">Shop by category</h2></div><a class="subtle-link" href="{{ route('storefront.shop') }}">See all categories <span aria-hidden="true">→</span></a></div>
        <div class="category-grid">
            @foreach($categories as $category)
                <a class="category-card" href="{{ route('storefront.shop', ['category' => $category['name']]) }}">
                    <div class="category-photo"><img src="{{ asset('images/storefront/'.$category['image']) }}" alt="" loading="lazy"></div>
                    <div class="category-caption"><span><strong>{{ $category['name'] }}</strong><small>{{ $category['count'] }} products</small></span><span class="category-arrow" aria-hidden="true">↗</span></div>
                </a>
            @endforeach
        </div>
    </section>

    <section class="section-block featured-block" aria-labelledby="featured-title">
        <div class="section-head"><div><span class="eyebrow">RECOMMENDED FOR YOU</span><h2 id="featured-title">Featured products</h2></div><a class="subtle-link" href="{{ route('storefront.shop') }}">View all products <span aria-hidden="true">→</span></a></div>
        <div class="product-grid">
            @foreach($featured as $product)
                @include('partials.product-card', ['product' => $product])
            @endforeach
        </div>
    </section>

    <section class="home-endcap" aria-label="Explore more products">
        <div><span class="eyebrow">WE SHOP SMART</span><h2>Find what fits your day.</h2><p>Browse the full range of electronics, home products, fashion, and accessories.</p></div>
        <a class="button button-dark" href="{{ route('storefront.shop') }}">Explore the shop <span aria-hidden="true">→</span></a>
    </section>
@endsection
