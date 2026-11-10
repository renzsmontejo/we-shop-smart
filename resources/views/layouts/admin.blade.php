<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') · We Shop Smart</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @stack('styles')
</head>
<body>
@php
    $nav = [
        ['label' => 'Dashboard',  'route' => 'admin.dashboard',  'icon' => 'dashboard'],
        ['label' => 'Orders',     'route' => 'admin.orders',     'icon' => 'bag'],
        ['label' => 'Products',   'route' => 'admin.products',   'icon' => 'package'],
        ['label' => 'Categories', 'route' => 'admin.categories', 'icon' => 'grid'],
        ['label' => 'Customers',  'route' => 'admin.customers',  'icon' => 'users'],
        ['label' => 'Reports',    'route' => 'admin.reports',    'icon' => 'chart'],
        ['label' => 'Discounts',  'route' => 'admin.discounts',  'icon' => 'tag'],
        ['label' => 'Content',    'route' => 'admin.content',    'icon' => 'image'],
        ['label' => 'Settings',   'route' => 'admin.settings',   'icon' => 'settings'],
    ];
    $accountName = auth()->user()?->name ?? 'Administrator';
@endphp
<div class="admin-shell" id="adminShell">
    <div class="sidebar-backdrop" data-close-sidebar></div>
    <aside class="admin-sidebar" id="adminSidebar" aria-label="Main navigation">
        <div class="sidebar-brand">
            <div class="brand-symbol">W<span>.</span></div>
            <div class="brand-copy"><strong>We Shop Smart</strong><span>STORE MANAGEMENT</span></div>
            <button type="button" class="icon-btn sidebar-close" aria-label="Close menu" data-close-sidebar><x-ui-icon name="close" /></button>
        </div>
        <div class="sidebar-body">
            <div class="sidebar-section-label">WORKSPACE</div>
            <nav class="sidebar-nav" id="adminNav">
                @foreach($nav as $item)
                    <a href="{{ route($item['route']) }}"
                       class="nav-link {{ request()->routeIs($item['route']) ? 'is-active' : '' }}"
                       data-nav-label="{{ strtolower($item['label']) }}"
                       @if(request()->routeIs($item['route'])) aria-current="page" @endif>
                        <x-ui-icon :name="$item['icon']" /><span>{{ $item['label'] }}</span>
                        @if(request()->routeIs($item['route'])) <span class="active-dot"></span> @endif
                    </a>
                @endforeach
            </nav>
            <p id="navEmpty" class="nav-empty" hidden>No matching pages.</p>
        </div>
        <div class="sidebar-footer">
            <div class="store-card">
                <span class="store-card-icon"><x-ui-icon name="bag" /></span>
                <div><strong>Storefront</strong><small>Your customer-facing site</small></div>
                <a href="{{ url('/') }}" title="Open storefront" aria-label="Open storefront"><x-ui-icon name="external" size="17" /></a>
            </div>
            <p class="sidebar-version">We Shop Smart &copy; {{ date('Y') }}</p>
        </div>
    </aside>
    <div class="admin-main">
        <header class="admin-topbar">
            <div class="topbar-left">
                <button type="button" class="icon-btn mobile-menu" aria-label="Open navigation" aria-expanded="false" aria-controls="adminSidebar" id="menuToggle"><x-ui-icon name="menu" size="22" /></button>
                <div class="topbar-context"><span class="context-label">Workspace</span><span class="context-divider">/</span><strong>@yield('title', 'Dashboard')</strong></div>
            </div>
            <div class="topbar-search">
                <label for="navSearch"><x-ui-icon name="search" size="18" /><span class="sr-only">Search menu pages</span></label>
                <input id="navSearch" type="search" placeholder="Search pages..." autocomplete="off" aria-label="Search menu pages">
                <kbd>/</kbd>
            </div>
            <div class="topbar-actions">
                <div class="dropdown-wrap">
                    <button type="button" class="icon-btn" id="notificationToggle" aria-expanded="false" aria-controls="notificationsPanel" aria-label="Notifications"><x-ui-icon name="bell" size="20" /></button>
                    <div class="popover-panel" id="notificationsPanel" hidden><strong>Notifications</strong><p>No new notifications.</p></div>
                </div>
                <span class="topbar-separator"></span>
                <div class="dropdown-wrap">
                    <button type="button" class="account-trigger" id="accountToggle" aria-expanded="false" aria-controls="accountPanel">
                        <span class="avatar">{{ mb_strtoupper(mb_substr($accountName, 0, 1)) }}</span>
                        <span class="account-name">{{ $accountName }}<small>Store admin</small></span>
                        <x-ui-icon name="chevron-down" size="15" />
                    </button>
                    <div class="popover-panel account-panel" id="accountPanel" hidden>
                        <strong>{{ $accountName }}</strong><p>Signed in to the admin workspace.</p>
                        @if(auth()->check() && Route::has('logout'))
                            <form method="POST" action="{{ route('logout') }}">@csrf
                                <button type="submit" class="signout-btn"><x-ui-icon name="logout" size="17" /> Sign out</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </header>
        <main class="admin-content" id="main-content">@yield('content')</main>
    </div>
</div>
<script src="{{ asset('js/admin.js') }}" defer></script>
@stack('scripts')
</body>
</html>
