<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sign in · We Shop Smart</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --pine: #075a38;
            --pine-dark: #092f22;
            --mint: #a5efbb;
            --ink: #15252c;
            --muted: #687983;
            --outline: #dbe4e5;
        }
        *, *::before, *::after { box-sizing: border-box; }
        html { min-height: 100%; }
        body { min-width: 320px; min-height: 100vh; margin: 0; background: white; color: var(--ink); font-family: 'DM Sans', Arial, sans-serif; -webkit-font-smoothing: antialiased; }
        input, button { font: inherit; }
        button { cursor: pointer; }
        a { color: inherit; }
        svg { display: block; }
        .auth-shell { display: grid; grid-template-columns: minmax(440px, 36.5%) minmax(0, 1fr); min-height: 100vh; }

        /* Customer and admin use the same secure Laravel form. */
        .auth-form-side { display: flex; flex-direction: column; min-width: 0; padding: 45px clamp(35px, 4.2vw, 80px) 35px; background: #fff; }
        .brand { display: inline-flex; align-items: center; align-self: flex-start; gap: 15px; text-decoration: none; }
        .brand-mark { display: grid; place-items: center; width: 52px; height: 52px; border-radius: 10px; background: #075a39; color: #fff; font: 700 34px/1 Georgia, serif; box-shadow: 0 3px 9px #153b2920; }
        .brand-wordmark strong { display: block; font: 800 20px/1.25 'Manrope', sans-serif; letter-spacing: -0.9px; }
        .brand-wordmark small { display: block; margin-top: 5px; color: #607777; font-size: 9px; font-weight: 700; letter-spacing: 2.45px; }
        .auth-content { width: 100%; max-width: 455px; margin: auto 0; padding: 50px 0; }
        .eyebrow { color: #4a646a; font-size: 12px; font-weight: 700; letter-spacing: 2.6px; margin: 0 0 17px; }
        h1 { font: 800 clamp(27px, 2.25vw, 37px)/1.2 'Manrope', sans-serif; letter-spacing: -1.45px; margin: 0; }
        .intro { max-width: 370px; margin: 16px 0 36px; color: var(--muted); font-size: 16px; line-height: 1.65; }
        .field { margin-bottom: 19px; }
        .field > label { display: block; margin-bottom: 10px; font-size: 14px; font-weight: 700; }
        .field-box { display: flex; align-items: center; height: 54px; gap: 12px; padding: 0 15px; border: 1px solid var(--outline); border-radius: 9px; background: #fff; transition: border-color .12s, box-shadow .12s; }
        .field-box:focus-within { border-color: #29a365; box-shadow: 0 0 0 3px #26a56716; }
        .field-box.is-invalid { border-color: #c35d5d; }
        .field-box > svg { width: 21px; height: 21px; color: #183a32; flex: none; }
        .field-box input { flex: 1; min-width: 0; height: 100%; padding: 0; border: 0; outline: 0; color: var(--ink); background: transparent; font-size: 14px; }
        .field-box input::placeholder { color: #9caab0; opacity: 1; }
        .toggle-password { flex: none; display: grid; place-items: center; width: 32px; height: 32px; padding: 0; border: 0; border-radius: 6px; background: transparent; color: #163c33; }
        .toggle-password:hover { background: #edf7f0; }
        .toggle-password svg { width: 21px; height: 21px; }
        .toggle-password svg[hidden] { display: none; }
        .field-error { margin: 6px 0 0; color: #ad3a3a; font-size: 12px; }
        .form-options { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px; margin: 21px 0 27px; font-size: 13px; }
        .remember { display: flex; align-items: center; gap: 9px; cursor: pointer; font-weight: 600; }
        .remember input { width: 16px; height: 16px; margin: 0; accent-color: var(--pine); }
        .forgot { color: var(--pine); text-decoration: none; font-weight: 700; }
        .forgot.disabled { opacity: .45; cursor: default; }
        .forgot:not(.disabled):hover { text-decoration: underline; }
        .submit-btn { display: flex; align-items: center; justify-content: center; gap: 12px; position: relative; width: 100%; min-height: 55px; padding: 13px 44px; border: none; border-radius: 9px; background: #00643b; box-shadow: 0 7px 14px #005c3922; color: #fff; font-size: 14px; font-weight: 700; }
        .submit-btn:hover { background: #004f30; }
        .submit-btn > svg { width: 19px; height: 19px; }
        .submit-btn .arrow { position: absolute; right: 18px; }
        .status, .error-summary { padding: 12px 14px; margin-bottom: 20px; border-radius: 8px; font-size: 13px; line-height: 1.6; }
        .status { background: #e9f7ee; color: #175b36; border: 1px solid #b9dfc6; }
        .error-summary { background: #fff2f2; color: #a13d3d; border: 1px solid #eacbcb; }
        .social-divider { display: flex; align-items: center; gap: 15px; color: #73838a; margin: 28px 0 22px; font-size: 13px; white-space: nowrap; }
        .social-divider::before, .social-divider::after { content: ''; height: 1px; flex: 1; background: var(--outline); }
        .social-buttons { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .social { display: flex; align-items: center; justify-content: center; gap: 11px; min-height: 52px; border: 1px solid var(--outline); border-radius: 9px; background: #fff; color: #25353b; font-weight: 700; font-size: 14px; text-decoration: none; }
        .social svg { width: 20px; height: 20px; flex: none; }
        .social:disabled { opacity: .48; cursor: not-allowed; }
        .social:not(:disabled):hover { border-color: #7fad92; background: #f5fbf7; }
        .register { margin: 39px 0 0; text-align: center; color: #6f8185; font-size: 13px; }
        .register a { color: var(--pine); text-decoration: none; font-weight: 700; margin-left: 5px; }
        .register a:hover { text-decoration: underline; }
        .register span { color: #739582; font-weight: 700; margin-left: 5px; opacity: .65; }
        :is(a, button, input):focus-visible { outline: 3px solid #a4d8b2; outline-offset: 3px; }

        /* Entire showcase below is HTML/CSS/inline SVG. No image files. */
        .showcase { position: relative; min-width: 0; min-height: 100vh; overflow: hidden; color: #fff; background: radial-gradient(ellipse at 59% 68%, #1f8256 0%, #13533a 35%, #0c3828 68%, #092d21 100%); isolation: isolate; }
        .showcase::before { content: ''; position: absolute; z-index: 5; left: -206px; top: -8%; height: 116%; width: 240px; border-radius: 50%; background: #fff; box-shadow: 19px 0 0 #dff1e6; pointer-events: none; }
        .showcase::after { content: ''; position: absolute; z-index: -1; left: 23%; top: 38%; width: 70%; aspect-ratio: 1; border: 2px solid #aaf2bb2b; border-radius: 50%; box-shadow: 0 0 85px #7ce4a425, inset 0 0 70px #62d89018; pointer-events: none; }
        .ambient-top { position: absolute; top: -360px; right: -180px; width: 760px; height: 740px; border-radius: 50%; background: radial-gradient(circle, #358f5935, transparent 70%); }
        .ambient-bottom { position: absolute; bottom: -230px; left: 4%; width: 760px; height: 470px; border-radius: 50%; background: radial-gradient(ellipse, #a2f4c01c, transparent 72%); }
        .showcase-content { position: relative; z-index: 2; height: 100%; min-height: 100vh; display: flex; flex-direction: column; align-items: center; padding: 58px 30px 33px 85px; }
        .showcase-heading { position: relative; z-index: 10; text-align: center; }
        .showcase-pill { display: inline-flex; align-items: center; gap: 9px; border: 1px solid #a1eebb91; padding: 9px 18px; border-radius: 999px; background: #0b382c6c; box-shadow: inset 0 0 13px #72cb9032, 0 0 16px #88e6ac3a; font-size: 13px; font-weight: 600; }
        .showcase-pill svg { width: 18px; height: 18px; }
        .showcase-heading h2 { margin: 24px 0 15px; font: 800 clamp(28px, 2.35vw, 43px)/1.19 'Manrope', sans-serif; letter-spacing: -1.5px; }
        .showcase-heading h2 span { color: var(--mint); }
        .showcase-heading p { max-width: 480px; margin: 0 auto; color: #d1e8d8; font-size: 14px; line-height: 1.7; }
        .scene { position: relative; flex: 1; align-self: stretch; min-height: 400px; max-height: 630px; width: min(100%, 1000px); margin: 10px auto 0; }
        .floor { position: absolute; z-index: 0; left: -5%; right: -10%; bottom: -2%; height: 22%; border-top: 1px solid #c7ecd14c; background: linear-gradient(180deg, #7ec2a72b, #06302320 85%); transform: skewY(-1.5deg); }
        .light-ring { position: absolute; z-index: 0; width: 42%; aspect-ratio: 1; left: 35%; top: 7%; border: 3px solid #a2f5bd66; border-radius: 50%; box-shadow: 0 0 30px #a5ffc876, inset 0 0 27px #a5ffc833; }
        .float-tile { position: absolute; z-index: 2; display: grid; place-items: center; width: 63px; height: 63px; border: 1px solid #ffffff3b; border-radius: 16px; background: linear-gradient(140deg, #95d7ae48, #0b674436); box-shadow: inset 0 1px 0 #ffffff50, 0 13px 27px #062a1e3a; backdrop-filter: blur(3px); }
        .float-tile svg { width: 35px; height: 35px; color: #f0fff2; }
        .tile-cart { top: 14%; left: 13%; }
        .tile-chart { top: 35%; left: 4%; }
        .tile-box { top: 7%; right: 9%; }
        .tile-tag { top: 37%; right: 2%; }
        /* Laptop is a real HTML mock storefront, not a screenshot. */
        .laptop { position: absolute; z-index: 5; left: 24%; bottom: 12%; width: 62%; min-width: 0; transform: perspective(1300px) rotateY(-6deg) rotateZ(-2deg); transform-origin: center bottom; filter: drop-shadow(0 25px 26px #02190f78); }
        .laptop-frame { padding: 10px 10px 12px; border: 5px solid #1e2728; border-radius: 15px 15px 5px 5px; background: #273132; box-shadow: inset 0 2px 0 #a8b0a8; }
        .laptop-screen { overflow: hidden; aspect-ratio: 1.74; border-radius: 4px; background: #f1faf3; color: #133b29; }
        .screen-nav { display: flex; align-items: center; justify-content: space-between; height: 15%; padding: 0 5%; background: #fff; font-size: clamp(7px, .75vw, 11px); }
        .screen-logo { display: flex; align-items: center; gap: 6px; font-weight: 800; white-space: nowrap; }
        .screen-logo b { display: grid; place-items: center; width: 17px; height: 17px; color: #fff; background: var(--pine); border-radius: 4px; font: 700 12px Georgia, serif; }
        .screen-links { display: flex; gap: 13px; color: #60736a; font-size: clamp(6px, .66vw, 9px); }
        .screen-main { display: grid; grid-template-columns: 48% 52%; height: 85%; overflow: hidden; background: linear-gradient(135deg, #f5faf5 0 51%, #dff4e5 51% 72%, #b9dfca 72%); }
        .screen-copy { position: relative; z-index: 1; align-self: center; padding-left: 13%; }
        .screen-copy small { color: #548d66; font-size: clamp(6px, .55vw, 8px); letter-spacing: 1px; font-weight: 800; }
        .screen-copy h3 { margin: 7px 0; font: 800 clamp(20px, 2.2vw, 38px)/1.05 'Manrope', sans-serif; letter-spacing: -1px; }
        .screen-copy p { max-width: 160px; margin: 0; font-size: clamp(7px, .75vw, 11px); color: #658875; line-height: 1.6; }
        .screen-copy .shop-now { display: inline-block; margin-top: 14px; padding: 8px 13px; background: #00653c; color: #fff; font-size: clamp(7px, .67vw, 10px); font-weight: 700; border-radius: 6px; }
        .product-display { display: grid; place-items: center; position: relative; }
        .product-display::before { content: ''; position: absolute; inset: 12% 7%; border-radius: 50%; background: #90d5ad3f; }
        .product-display svg { position: relative; width: 87%; max-height: 96%; filter: drop-shadow(7px 10px 7px #315d4d38); }
        .laptop-base { position: relative; height: 18px; margin: -1px -12% 0; background: linear-gradient(#dce7e4, #8d9e9a 36%, #374c49 77%, #a9bcaf); border-radius: 0 0 45% 45%; border-bottom: 2px solid #1d3b30; }
        .laptop-base::before { content: ''; position: absolute; top: 0; left: 38%; width: 24%; height: 5px; border-radius: 0 0 7px 7px; background: #889b93; }
        /* Shopping bags */
        .bag { position: absolute; z-index: 4; bottom: 13%; width: 15%; max-width: 120px; height: 25%; max-height: 170px; border-radius: 3px 3px 7px 7px; box-shadow: 10px 20px 25px #041d153d; }
        .bag::before { content: ''; position: absolute; left: 27%; top: -26%; width: 47%; height: 38%; border: 5px solid #e3f5e6; border-bottom: 0; border-radius: 48% 48% 0 0; }
        .bag-green { left: 11%; background: linear-gradient(105deg, #087246, #005333); }
        .bag-green b { position: absolute; display: grid; place-items: center; width: 37%; aspect-ratio: 1; left: 32%; top: 39%; background: white; color: var(--pine); border-radius: 7px; font: 800 clamp(19px,2vw,27px) Georgia,serif; }
        .bag-white { z-index: 2; bottom: 18%; left: 21%; width: 13%; height: 28%; background: linear-gradient(100deg, #eef8ee, #a8bdb1); transform: rotate(4deg); }
        .bag-white::before { border-color: #f3fbf0; }
        /* Parcels */
        .parcel { position: absolute; z-index: 6; width: 11%; height: 12%; background: linear-gradient(115deg, #e5b47e, #ad7950); box-shadow: inset -12px 0 #885d3440, 10px 14px 20px #0621194d; }
        .parcel::before { content: ''; position: absolute; width: 17%; height: 100%; left: 45%; background: #f4d3a1aa; }
        .parcel-left { left: 4%; bottom: 9%; transform: rotate(-1deg); }
        .parcel-right { right: 2%; bottom: 9%; width: 15%; height: 15%; }
        .parcel-high { right: 7%; bottom: 24%; width: 11%; height: 11%; z-index: 3; }
        /* CSS-only plant and ceramic pot */
        .plant { position: absolute; z-index: 4; right: 10%; bottom: 25%; width: 15%; height: 30%; }
        .plant .stem { position: absolute; left: 49%; bottom: 5%; width: 3px; height: 75%; background: #478d48; transform-origin: bottom; }
        .plant .stem:nth-child(1) { transform: rotate(-37deg); }
        .plant .stem:nth-child(2) { transform: rotate(-15deg); }
        .plant .stem:nth-child(3) { transform: rotate(12deg); }
        .plant .stem:nth-child(4) { transform: rotate(36deg); }
        .plant .stem:nth-child(5) { transform: rotate(52deg); }
        .leaf { position: absolute; left: 50%; bottom: 37%; width: 25%; height: 49%; background: linear-gradient(95deg, #276e35, #8abf55 70%, #3e8a3c); border-radius: 95% 4% 95% 4%; transform-origin: bottom left; }
        .leaf.l1 { transform: rotate(-58deg) translateY(-10%); }
        .leaf.l2 { transform: rotate(-25deg) translateY(-18%); }
        .leaf.l3 { transform: rotate(8deg) translateY(-20%); }
        .leaf.l4 { transform: rotate(39deg) translateY(-12%); }
        .leaf.l5 { transform: rotate(65deg) translateY(-6%); }
        .pot { position: absolute; z-index: 2; bottom: 0; left: 21%; width: 66%; height: 40%; border-radius: 6px 6px 18px 18px; background: linear-gradient(92deg,#c5d4c7,#f6f5e8 48%,#a7bcaf); box-shadow: 8px 11px 16px #001b1359; }
        .showcase-note { margin-top: 8px; text-align: center; font-size: 11px; color: #badac7; }
        @media (max-width: 1250px) {
            .auth-shell { grid-template-columns: 42% minmax(0,1fr); }
            .auth-form-side { padding-inline: 35px; }
            .showcase-content { padding: 45px 20px 30px 70px; }
            .showcase-heading h2 { font-size: 30px; }
            .scene { min-height: 330px; }
            .laptop { left: 23%; width: 69%; }
            .bag-green { left: 8%; }
        }
        @media (max-width: 900px) {
            .auth-shell { grid-template-columns: 1fr; }
            .auth-form-side { min-height: 100vh; min-height: 100svh; padding: 28px 24px 45px; align-items: center; }
            .brand { align-self: flex-start; }
            .auth-content { max-width: 460px; margin: auto 0; padding: 50px 0; }
            .showcase { display: none; }
        }
        @media (max-width: 480px) {
            .auth-form-side { padding: 25px 20px 40px; }
            .brand-mark { width: 45px; height: 45px; font-size: 30px; }
            .brand-wordmark strong { font-size: 17px; }
            .brand-wordmark small { font-size: 8px; letter-spacing: 1.4px; }
            .auth-content { padding: 40px 0; }
            h1 { font-size: 28px; }
            .intro { font-size: 14px; margin-bottom: 27px; }
            .social { font-size: 12px; }
        }
    </style>
</head>
<body>
<div class="auth-shell">
    <main class="auth-form-side">
        <a href="{{ url('/') }}" class="brand" aria-label="We Shop Smart home">
            <span class="brand-mark">W</span>
            <span class="brand-wordmark">
                <strong>We Shop Smart</strong>
                <small>STORE MANAGEMENT</small>
            </span>
        </a>

        <div class="auth-content">
            <p class="eyebrow">WELCOME BACK</p>
            <h1>Sign in to your account</h1>
            <p class="intro">Access your shopping account, orders, and store workspace in one secure place.</p>

            @if (session('status'))
                <div class="status" role="status">{{ session('status') }}</div>
            @endif
            @if ($errors->any())
                <div class="error-summary" role="alert">Please check your login details and try again.</div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="field">
                    <label for="email">Email Address</label>
                    <div class="field-box @error('email') is-invalid @enderror">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2.5" y="4.5" width="19" height="15" rx="2"/><path d="m3.5 6 8.5 7 8.5-7"/></svg>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Enter your email address" autocomplete="username" required autofocus>
                    </div>
                    @error('email') <p class="field-error">{{ $message }}</p> @enderror
                </div>
                <div class="field">
                    <label for="password">Password</label>
                    <div class="field-box @error('password') is-invalid @enderror">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="5" y="10" width="14" height="11" rx="2"/><path d="M8 10V7a4 4 0 0 1 8 0v3"/></svg>
                        <input id="password" type="password" name="password" placeholder="Enter your password" autocomplete="current-password" required>
                        <button id="togglePassword" type="button" class="toggle-password" aria-label="Show password" aria-controls="password" aria-pressed="false">
                            <svg id="eyeClosed" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 3 21 21"/><path d="M10.6 5.6A11 11 0 0 1 12 5.5c6.5 0 10 6.5 10 6.5a16 16 0 0 1-3.1 3.8M6 6.9C3.3 8.8 2 12 2 12s3.5 6.5 10 6.5a10 10 0 0 0 4-.8"/><path d="M10 10a3 3 0 0 0 4 4"/></svg>
                            <svg id="eyeOpen" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" hidden><path d="M2 12s3.5-6.5 10-6.5 10 6.5 10 6.5-3.5 6.5-10 6.5S2 12 2 12Z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                    @error('password') <p class="field-error">{{ $message }}</p> @enderror
                </div>

                <div class="form-options">
                    <label class="remember"><input type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}> Remember me</label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot">Forgot your password?</a>
                    @else
                        <span class="forgot disabled" title="Password reset is not configured">Forgot your password?</span>
                    @endif
                </div>
                <button class="submit-btn" type="submit">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M10 12h11m-4-4 4 4-4 4"/><path d="M13 4H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h7"/></svg>
                    Sign in to your account
                    <svg class="arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 12h16m-6-6 6 6-6 6"/></svg>
                </button>
            </form>

            <div class="social-divider">Or continue with</div>
            <div class="social-buttons">
                @if (Route::has('auth.google.redirect'))
                    <a href="{{ route('auth.google.redirect') }}" class="social">
                @else
                    <button class="social" type="button" disabled title="Google sign-in is not configured">
                @endif
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path fill="#4285F4" d="M21.6 12.23c0-.7-.06-1.4-.18-2.07H12v3.92h5.38a4.6 4.6 0 0 1-2 3.02v2.5h3.24c1.9-1.75 2.98-4.33 2.98-7.37Z"/><path fill="#34A853" d="M12 22c2.7 0 4.96-.9 6.61-2.4l-3.23-2.5a6 6 0 0 1-8.95-3.14H3.1v2.58A10 10 0 0 0 12 22Z"/><path fill="#FBBC05" d="M6.43 13.96a6 6 0 0 1 0-3.92V7.46H3.1a10 10 0 0 0 0 9.08l3.33-2.58Z"/><path fill="#EA4335" d="M12 6a5.45 5.45 0 0 1 3.83 1.5l2.88-2.88A9.55 9.55 0 0 0 12 2a10 10 0 0 0-8.9 5.46l3.33 2.58A5.98 5.98 0 0 1 12 6Z"/></svg>
                    Google
                @if (Route::has('auth.google.redirect')) </a> @else </button> @endif

                @if (Route::has('auth.microsoft.redirect'))
                    <a href="{{ route('auth.microsoft.redirect') }}" class="social">
                @else
                    <button class="social" type="button" disabled title="Microsoft sign-in is not configured">
                @endif
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path fill="#F25022" d="M1 1h10.5v10.5H1z"/><path fill="#7FBA00" d="M12.5 1H23v10.5H12.5z"/><path fill="#00A4EF" d="M1 12.5h10.5V23H1z"/><path fill="#FFB900" d="M12.5 12.5H23V23H12.5z"/></svg>
                    Microsoft
                @if (Route::has('auth.microsoft.redirect')) </a> @else </button> @endif
            </div>

            <p class="register">
                Don't have an account?
                @if (Route::has('register'))
                    <a href="{{ route('register') }}">Create an account</a>
                @else
                    <span title="Registration has not been configured">Create an account</span>
                @endif
            </p>
        </div>
    </main>

    <!-- Pure HTML, CSS, inline SVG. No PNG, JPG, GIF, or <img> tags. -->
    <aside class="showcase" aria-label="We Shop Smart storefront design">
        <div class="ambient-top" aria-hidden="true"></div><div class="ambient-bottom" aria-hidden="true"></div>
        <div class="showcase-content">
            <div class="showcase-heading">
                <div class="showcase-pill">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="9" cy="20" r="1"/><circle cx="19" cy="20" r="1"/><path d="M2 3h3l2.6 12h11.8l2.3-9H6"/></svg>
                    Your Store, Smarter
                </div>
                <h2>Shopping made simple.<br><span>Management made smart.</span></h2>
                <p>A secure and efficient platform to manage products, orders, customers, and store performance.</p>
            </div>
            <div class="scene" aria-hidden="true">
                <div class="light-ring"></div>
                <div class="floor"></div>
                <div class="float-tile tile-cart"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2 3h3l2.6 13h12L22 7H6"/></svg></div>
                <div class="float-tile tile-chart"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M3 3v18h18"/><path d="M8 17v-5m5 5V8m5 9V5"/></svg></div>
                <div class="float-tile tile-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"><path d="m12 2 9 5-9 5-9-5 9-5Zm-9 5v10l9 5 9-5V7M12 12v10"/></svg></div>
                <div class="float-tile tile-tag"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"><path d="m20 13-8 8-9-9V3h9l8 8a2 2 0 0 1 0 2Z"/><circle cx="7.5" cy="7.5" r="1.4"/></svg></div>
                <div class="bag bag-white"></div>
                <div class="bag bag-green"><b>W</b></div>
                <div class="parcel parcel-left"></div>
                <div class="laptop">
                    <div class="laptop-frame">
                        <div class="laptop-screen">
                            <div class="screen-nav"><span class="screen-logo"><b>W</b> We Shop Smart</span><span class="screen-links"><span>Home</span><span>Shop</span><span>Deals</span><span>About</span></span></div>
                            <div class="screen-main">
                                <div class="screen-copy"><small>JUST LANDED</small><h3>New<br>Arrivals</h3><p>Discover the latest trends and everyday essentials.</p><span class="shop-now">Shop Now &nbsp;→</span></div>
                                <div class="product-display">
                                    <!-- Vector headphones drawn directly in SVG -->
                                    <svg viewBox="0 0 230 230" xmlns="http://www.w3.org/2000/svg">
                                        <defs><linearGradient id="headband" x1="0" y1="0" x2="1" y2="1"><stop stop-color="#f9fffd"/><stop offset=".5" stop-color="#c9dcd1"/><stop offset="1" stop-color="#7c9d8d"/></linearGradient><linearGradient id="earpiece" x1="0" y1="0" x2="1" y2="1"><stop stop-color="#f6fcf8"/><stop offset="1" stop-color="#9ab6a6"/></linearGradient></defs>
                                        <ellipse cx="122" cy="202" rx="79" ry="12" fill="#416d5540"/>
                                        <path d="M57 125V93c0-39 24-65 59-65s59 26 59 65v33" fill="none" stroke="#668c7a" stroke-width="26" stroke-linecap="round"/>
                                        <path d="M57 125V93c0-39 24-65 59-65s59 26 59 65v33" fill="none" stroke="url(#headband)" stroke-width="20" stroke-linecap="round"/>
                                        <g transform="rotate(-12 59 149)"><rect x="36" y="112" width="48" height="81" rx="24" fill="#5d8873"/><rect x="42" y="117" width="37" height="71" rx="18" fill="url(#earpiece)"/><ellipse cx="60" cy="153" rx="12" ry="29" fill="#edf7ee"/></g>
                                        <g transform="rotate(12 172 149)"><rect x="147" y="112" width="48" height="81" rx="24" fill="#5d8873"/><rect x="153" y="117" width="37" height="71" rx="18" fill="url(#earpiece)"/><ellipse cx="172" cy="153" rx="12" ry="29" fill="#edf7ee"/></g>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="laptop-base"></div>
                </div>
                <div class="parcel parcel-high"></div>
                <div class="plant"><span class="stem"></span><span class="stem"></span><span class="stem"></span><span class="stem"></span><span class="stem"></span><span class="leaf l1"></span><span class="leaf l2"></span><span class="leaf l3"></span><span class="leaf l4"></span><span class="leaf l5"></span><div class="pot"></div></div>
                <div class="parcel parcel-right"></div>
            </div>
            <div class="showcase-note">Made for better shopping, every day.</div>
        </div>
    </aside>
</div>
<script>
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');
    const eyeOpen = document.getElementById('eyeOpen');
    const eyeClosed = document.getElementById('eyeClosed');
    togglePassword.addEventListener('click', () => {
        const visible = password.type === 'password';
        password.type = visible ? 'text' : 'password';
        eyeOpen.hidden = !visible;
        eyeClosed.hidden = visible;
        togglePassword.setAttribute('aria-label', visible ? 'Hide password' : 'Show password');
        togglePassword.setAttribute('aria-pressed', String(visible));
    });
</script>
</body>
</html>
