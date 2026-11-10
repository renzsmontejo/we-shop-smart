<aside id="storefront-sidebar" class="wss-sidebar" aria-label="Customer navigation">
    <a class="sidebar-brand" href="{{ route('storefront.home') }}" aria-label="We Shop Smart homepage">
        <span class="brand-mark" aria-hidden="true">W</span>
        <span class="brand-words"><strong>WE SHOP SMART</strong><small>CUSTOMER STORE</small></span>
    </a>

    <div class="sidebar-scroll">
        <div class="sidebar-group">
            <p class="sidebar-label">MAIN MENU</p>
            <nav class="sidebar-nav" aria-label="Main menu">
                <a class="sidebar-link {{ $active === 'home' ? 'is-active' : '' }}" href="{{ route('storefront.home') }}" @if($active === 'home') aria-current="page" @endif>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="m3 10 9-7 9 7v10H3z"/><path d="M9 20v-7h6v7"/></svg>
                    <span>Home</span>
                </a>
                <a class="sidebar-link {{ $active === 'shop' ? 'is-active' : '' }}" href="{{ route('storefront.shop') }}" @if($active === 'shop') aria-current="page" @endif>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg>
                    <span>Shop products</span>
                </a>
                <a class="sidebar-link {{ $active === 'cart' ? 'is-active' : '' }}" href="{{ route('storefront.cart') }}" @if($active === 'cart') aria-current="page" @endif>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M4 8h16l-1.5 12h-13L4 8Z"/><path d="M9 9V6a3 3 0 0 1 6 0v3"/></svg>
                    <span>Shopping cart</span>
                    @if($cartCount > 0)<span class="sidebar-count">{{ $cartCount > 99 ? '99+' : $cartCount }}</span>@endif
                </a>
            </nav>
        </div>

        <div class="sidebar-group sidebar-group-categories">
            <p class="sidebar-label">CATEGORIES</p>
            <nav class="sidebar-nav" aria-label="Product categories">
                <a class="sidebar-sub-link" href="{{ route('storefront.shop', ['category' => 'Electronics']) }}"><span>Electronics</span><span aria-hidden="true">›</span></a>
                <a class="sidebar-sub-link" href="{{ route('storefront.shop', ['category' => 'Home & Living']) }}"><span>Home & Living</span><span aria-hidden="true">›</span></a>
                <a class="sidebar-sub-link" href="{{ route('storefront.shop', ['category' => 'Fashion']) }}"><span>Fashion</span><span aria-hidden="true">›</span></a>
                <a class="sidebar-sub-link" href="{{ route('storefront.shop', ['category' => 'Accessories']) }}"><span>Accessories</span><span aria-hidden="true">›</span></a>
            </nav>
        </div>

        <div class="sidebar-bottom">
            <div class="sidebar-support">
                <div class="support-icon" aria-hidden="true">?</div>
                <strong>Looking for something?</strong>
                <p>Browse the full catalog or search by product name.</p>
                <a href="{{ route('storefront.shop') }}">View all products <span aria-hidden="true">→</span></a>
            </div>
            <div class="sidebar-copyright">WSS · WE SHOP SMART</div>
        </div>
    </div>
</aside>
