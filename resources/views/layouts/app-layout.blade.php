@php
    $active = $__env->yieldContent('active', 'home');
    $cartCount = $cartCount ?? 0;
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f6f8fb">
    <meta name="description" content="Shop electronics, home essentials, fashion and accessories at We Shop Smart.">
    <title>@yield('title', 'Home') | We Shop Smart</title>
    <link rel="stylesheet" href="{{ asset('css/storefront.css') }}">

    {{-- Shared WSS typography: use in the <head> of customer, admin and auth layouts. --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/wss-typography.css') }}">

    @include('partials.typography')
</head>
<body>
    <div class="wss-shell">
        @include('partials.sidebar', ['active' => $active, 'cartCount' => $cartCount])
        <button class="sidebar-overlay" type="button" data-close-sidebar aria-label="Close navigation" tabindex="-1"></button>

        <div class="wss-workspace">
            @include('partials.navbar', ['active' => $active, 'cartCount' => $cartCount])
            <main class="wss-main" id="main-content">
                @if(session('success'))
                    <div class="flash flash-success" role="status">
                        <span aria-hidden="true">✓</span> <span>{{ session('success') }}</span>
                        <button type="button" data-dismiss-flash aria-label="Dismiss notification">×</button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="flash flash-error" role="alert">
                        <span aria-hidden="true">!</span> <span>{{ session('error') }}</span>
                        <button type="button" data-dismiss-flash aria-label="Dismiss notification">×</button>
                    </div>
                @endif
                @yield('content')
            </main>
            <footer class="wss-footer">
                <span>© {{ date('Y') }} We Shop Smart.</span>
                <span>Smart picks. Simple shopping.</span>
            </footer>
        </div>
    </div>
    <script src="{{ asset('js/storefront.js') }}" defer></script>
</body>
</html>
