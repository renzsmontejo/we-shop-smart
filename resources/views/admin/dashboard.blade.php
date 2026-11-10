@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')
@php
    // Example numbers only. Replace with controller data when your database is connected.
    $stats = [
        ['label' => 'Total revenue', 'value' => '₱286,430', 'change' => '+12.8% this month', 'icon' => 'wallet'],
        ['label' => 'Total orders', 'value' => '1,284', 'change' => '+8.2% this month', 'icon' => 'bag'],
        ['label' => 'Customers', 'value' => '3,892', 'change' => '+6.5% this month', 'icon' => 'users'],
        ['label' => 'Products sold', 'value' => '2,476', 'change' => '+9.3% this month', 'icon' => 'package'],
    ];
    $sales = [
        ['month' => 'May', 'height' => 40], ['month' => 'Jun', 'height' => 57],
        ['month' => 'Jul', 'height' => 46], ['month' => 'Aug', 'height' => 72],
        ['month' => 'Sep', 'height' => 63], ['month' => 'Oct', 'height' => 86],
        ['month' => 'Nov', 'height' => 100],
    ];
    $orders = [
        ['id' => 'WSS-10249', 'customer' => 'Sofia Reyes', 'items' => '2 items', 'total' => '₱2,890', 'status' => 'Delivered', 'tone' => 'success'],
        ['id' => 'WSS-10248', 'customer' => 'Joshua Tan', 'items' => '1 item', 'total' => '₱1,250', 'status' => 'Processing', 'tone' => 'warning'],
        ['id' => 'WSS-10247', 'customer' => 'Mika Santos', 'items' => '3 items', 'total' => '₱4,750', 'status' => 'Shipped', 'tone' => 'info'],
        ['id' => 'WSS-10246', 'customer' => 'Daniel Cruz', 'items' => '1 item', 'total' => '₱950', 'status' => 'Pending', 'tone' => 'neutral'],
    ];
    $lowStock = [
        ['name' => 'Relaxed Knit Sweater', 'sku' => 'WSS-KNT-001', 'left' => 5],
        ['name' => 'Classic Trench Coat', 'sku' => 'WSS-COAT-018', 'left' => 3],
        ['name' => 'Wide Leg Trousers', 'sku' => 'WSS-TR-024', 'left' => 8],
    ];
@endphp
<div class="page-heading">
    <div><div class="eyebrow">OVERVIEW <span class="demo-pill">DEMO DATA</span></div><h1>Dashboard</h1><p>Here’s what’s happening with your store today.</p></div>
    <div class="heading-actions"><span class="date-chip">November 2026</span><a class="button-primary" href="{{ route('admin.reports') }}">View reports <x-ui-icon name="arrow-up-right" size="16" /></a></div>
</div>
<div class="stats-grid">
    @foreach($stats as $stat)
        <section class="stat-card"><div class="stat-top"><span>{{ $stat['label'] }}</span><span class="stat-icon"><x-ui-icon :name="$stat['icon']" /></span></div><div class="stat-value">{{ $stat['value'] }}</div><div class="stat-change"><x-ui-icon name="arrow-up-right" size="14" /> {{ $stat['change'] }}</div></section>
    @endforeach
</div>
<div class="dashboard-grid">
    <section class="surface-card sales-card">
        <div class="card-heading"><div><h2>Sales overview</h2><p>Revenue performance over the last 7 months</p></div><span class="subtle-tag">Monthly</span></div>
        <div class="sales-chart" role="img" aria-label="Demo monthly sales bar chart from May to November, trending upward">
            @foreach($sales as $point)
                <div class="chart-column"><div class="chart-bar" style="--bar-height: {{ $point['height'] }}%"></div><span>{{ $point['month'] }}</span></div>
            @endforeach
        </div>
    </section>
    <section class="surface-card quick-card">
        <div class="card-heading"><div><h2>Quick actions</h2><p>Frequently used tools</p></div></div>
        <div class="quick-actions">
            <a href="{{ route('admin.products') }}"><span class="quick-icon"><x-ui-icon name="package" /></span><span>Manage products<small>Update catalog and stock</small></span><x-ui-icon name="arrow-right" size="17" /></a>
            <a href="{{ route('admin.orders') }}"><span class="quick-icon"><x-ui-icon name="bag" /></span><span>Review orders<small>Process new purchases</small></span><x-ui-icon name="arrow-right" size="17" /></a>
            <a href="{{ route('admin.discounts') }}"><span class="quick-icon"><x-ui-icon name="tag" /></span><span>Manage discounts<small>Coupons and promotions</small></span><x-ui-icon name="arrow-right" size="17" /></a>
        </div>
    </section>
    <section class="surface-card orders-card">
        <div class="card-heading"><div><h2>Recent orders</h2><p>Latest activity from your customers</p></div><a class="text-link" href="{{ route('admin.orders') }}">View all <x-ui-icon name="arrow-right" size="15" /></a></div>
        <div class="table-scroll"><table class="data-table"><thead><tr><th>Order ID</th><th>Customer</th><th>Items</th><th>Total</th><th>Status</th></tr></thead><tbody>
            @foreach($orders as $order)
                <tr><td><strong>{{ $order['id'] }}</strong></td><td>{{ $order['customer'] }}</td><td>{{ $order['items'] }}</td><td>{{ $order['total'] }}</td><td><span class="status-pill {{ $order['tone'] }}">{{ $order['status'] }}</span></td></tr>
            @endforeach
        </tbody></table></div>
    </section>
    <section class="surface-card stock-card">
        <div class="card-heading"><div><h2>Low stock</h2><p>Products that need attention</p></div><span class="attention-count">{{ count($lowStock) }}</span></div>
        <div class="stock-list">
            @foreach($lowStock as $item)
                <div class="stock-row"><span class="stock-graphic"><x-ui-icon name="package" size="20" /></span><div><strong>{{ $item['name'] }}</strong><small>{{ $item['sku'] }}</small></div><span class="stock-remaining">{{ $item['left'] }} left</span></div>
            @endforeach
        </div>
        <a class="stock-link" href="{{ route('admin.products') }}">Go to products <x-ui-icon name="arrow-right" size="15" /></a>
    </section>
</div>
@endsection
