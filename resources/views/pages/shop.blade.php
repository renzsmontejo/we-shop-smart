@extends('layouts.app-layout')
@section('title', 'Shop')
@section('nav_title', 'Shop products')
@section('active', 'shop')

@section('content')
    <nav class="breadcrumbs" aria-label="Breadcrumb"><a href="{{ route('storefront.home') }}">Home</a><span aria-hidden="true">/</span><span aria-current="page">Shop</span></nav>
    <div class="page-head shop-page-head">
        <div><span class="eyebrow">PRODUCT CATALOG</span><h1>Shop products</h1><p>Browse our catalog, compare prices, and find the right products for you.</p></div>
        <span class="page-counter">{{ count($products) }} products found</span>
    </div>

    <div class="shop-layout">
        <aside class="filter-panel" aria-label="Filter products">
            <div class="filter-header"><h2>Filters</h2><a href="{{ route('storefront.shop') }}">Clear all</a></div>
            <div class="filter-section">
                <h3>Categories</h3>
                <nav class="filter-categories" aria-label="Filter by category">
                    <a class="filter-category {{ $category === 'All' ? 'selected' : '' }}" href="{{ route('storefront.shop', array_filter(['q' => $q, 'sort' => $sort, 'max_price' => $maxPrice !== 'all' ? $maxPrice : null])) }}"><span>All products</span><span class="filter-number">{{ array_sum(array_column($categories, 'count')) }}</span></a>
                    @foreach($categories as $item)
                        <a class="filter-category {{ $category === $item['name'] ? 'selected' : '' }}" href="{{ route('storefront.shop', array_filter(['category' => $item['name'], 'q' => $q, 'sort' => $sort, 'max_price' => $maxPrice !== 'all' ? $maxPrice : null])) }}"><span>{{ $item['name'] }}</span><span class="filter-number">{{ $item['count'] }}</span></a>
                    @endforeach
                </nav>
            </div>
            <div class="filter-section">
                <h3>Price range</h3>
                <form action="{{ route('storefront.shop') }}" method="GET">
                    @if($category !== 'All')<input type="hidden" name="category" value="{{ $category }}">@endif
                    @if($q !== '')<input type="hidden" name="q" value="{{ $q }}">@endif
                    <input type="hidden" name="sort" value="{{ $sort }}">
                    <label class="radio-option"><input type="radio" name="max_price" value="all" @checked($maxPrice === 'all') data-auto-submit><span>Any price</span></label>
                    <label class="radio-option"><input type="radio" name="max_price" value="1500" @checked($maxPrice === '1500') data-auto-submit><span>Up to ₱1,500</span></label>
                    <label class="radio-option"><input type="radio" name="max_price" value="3000" @checked($maxPrice === '3000') data-auto-submit><span>Up to ₱3,000</span></label>
                    <label class="radio-option"><input type="radio" name="max_price" value="5000" @checked($maxPrice === '5000') data-auto-submit><span>Up to ₱5,000</span></label>
                    <button type="submit" class="filter-submit">Apply filters</button>
                </form>
            </div>
            <div class="filter-footer"><span>WSS TIP</span><p>Use search or filters to narrow down products.</p></div>
        </aside>

        <section class="shop-products" aria-label="Product results">
            <div class="shop-toolbar">
                <div class="toolbar-title"><strong>{{ $category === 'All' ? 'All products' : $category }}</strong><span>{{ count($products) }} matching items</span></div>
                <form action="{{ route('storefront.shop') }}" method="GET" class="sort-form">
                    @if($category !== 'All')<input type="hidden" name="category" value="{{ $category }}">@endif
                    @if($q !== '')<input type="hidden" name="q" value="{{ $q }}">@endif
                    @if($maxPrice !== 'all')<input type="hidden" name="max_price" value="{{ $maxPrice }}">@endif
                    <label for="sort">Sort by</label>
                    <select id="sort" name="sort" data-auto-submit>
                        <option value="featured" @selected($sort === 'featured')>Featured</option>
                        <option value="newest" @selected($sort === 'newest')>Newest</option>
                        <option value="price_low" @selected($sort === 'price_low')>Price: low to high</option>
                        <option value="price_high" @selected($sort === 'price_high')>Price: high to low</option>
                        <option value="rating" @selected($sort === 'rating')>Top rated</option>
                    </select>
                    <button type="submit" class="sort-submit">Apply</button>
                </form>
            </div>
            <form action="{{ route('storefront.shop') }}" method="GET" class="mobile-filter-form">
                <label for="mobile-category">Category</label>
                <select id="mobile-category" name="category" data-auto-submit><option value="All">All products</option>@foreach($categories as $item)<option value="{{ $item['name'] }}" @selected($category === $item['name'])>{{ $item['name'] }}</option>@endforeach</select>
                <label for="mobile-price">Price</label>
                <select id="mobile-price" name="max_price" data-auto-submit><option value="all">Any price</option><option value="1500" @selected($maxPrice === '1500')>Up to ₱1,500</option><option value="3000" @selected($maxPrice === '3000')>Up to ₱3,000</option><option value="5000" @selected($maxPrice === '5000')>Up to ₱5,000</option></select>
                @if($q !== '')<input type="hidden" name="q" value="{{ $q }}">@endif
                <input type="hidden" name="sort" value="{{ $sort }}">
                <button type="submit">Apply</button>
            </form>
            @if($q !== '' || $category !== 'All' || $maxPrice !== 'all')
                <div class="active-filters"><span>Active filters:</span>@if($q !== '')<span class="filter-chip">Search: {{ $q }}</span>@endif @if($category !== 'All')<span class="filter-chip">{{ $category }}</span>@endif @if($maxPrice !== 'all')<span class="filter-chip">Up to ₱{{ number_format((int)$maxPrice) }}</span>@endif<a href="{{ route('storefront.shop') }}">Reset</a></div>
            @endif

            @if(count($products))
                <div class="product-grid shop-product-grid">
                    @foreach($products as $product)
                        @include('partials.product-card', ['product' => $product])
                    @endforeach
                </div>
            @else
                <div class="empty-state"><div class="empty-icon" aria-hidden="true">⌕</div><h2>No products found</h2><p>Try another search term, category, or price range.</p><a href="{{ route('storefront.shop') }}" class="button button-blue">View all products</a></div>
            @endif
        </section>
    </div>
@endsection
