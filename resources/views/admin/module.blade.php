@extends('layouts.admin')
@section('title', $title)
@section('content')
<div class="page-heading"><div><div class="eyebrow">STORE MANAGEMENT</div><h1>{{ $title }}</h1><p>Manage your store's {{ strtolower($title) }} from this workspace.</p></div></div>
<section class="surface-card module-placeholder"><span class="module-icon"><x-ui-icon name="grid" size="28" /></span><h2>{{ $title }} module</h2><p>The navigation and reusable layout are ready. Replace this placeholder with your {{ strtolower($title) }} Blade view, controller, and database-backed features.</p><a href="{{ route('admin.dashboard') }}" class="button-primary">Return to dashboard <x-ui-icon name="arrow-right" size="16" /></a></section>
@endsection
