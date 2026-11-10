<header class="wss-navbar">
    <div class="navbar-left">
        <button type="button" class="icon-button menu-button" data-open-sidebar aria-controls="storefront-sidebar" aria-expanded="false" aria-label="Open navigation">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
        </button>
        <div class="navbar-page"><strong>@yield('nav_title', 'Storefront')</strong><span>We Shop Smart / Customer Store</span></div>
    </div>

    <form class="navbar-search" role="search" action="{{ route('storefront.shop') }}" method="GET">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="10.8" cy="10.8" r="6.8"/><path d="m16 16 5 5"/></svg>
        <input type="search" name="q" value="{{ request('q', '') }}" placeholder="Search products..." aria-label="Search products">
        <button type="submit">Search</button>
    </form>

    <div class="navbar-actions">
        <a class="icon-button nav-cart" href="{{ route('storefront.cart') }}" aria-label="Shopping cart, {{ $cartCount }} items">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M4 8h16l-1.5 12h-13L4 8Z"/><path d="M9 9V6a3 3 0 0 1 6 0v3"/></svg>
            @if($cartCount > 0)<span class="cart-badge">{{ $cartCount > 99 ? '99+' : $cartCount }}</span>@endif
        </a>
        @php
            $accountHref = auth()->check() ? route('account') : (\Illuminate\Support\Facades\Route::has('login') ? route('login') : route('account'));
        @endphp
        <a class="account-link" href="{{ $accountHref }}" aria-label="{{ auth()->check() ? 'My account' : 'Log in' }}">
            <span class="account-avatar" aria-hidden="true">{{ strtoupper(mb_substr(auth()->user()?->name ?? 'G', 0, 1)) }}</span>
            <span class="account-text">{{ auth()->check() ? 'My account' : 'Sign in' }}</span>
        </a>
    </div>
</header>
