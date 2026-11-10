<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StorefrontController extends Controller
{
    public function home(Request $request): View
    {
        $catalog = $this->catalog();

        return view('pages.home', [
            'featured' => array_slice(array_values(array_filter($catalog, fn ($p) => $p['featured'])), 0, 4),
            'categories' => $this->categories($catalog),
            'cartCount' => $this->cartCount($request),
        ]);
    }

    public function shop(Request $request): View
    {
        $catalog = $this->catalog();
        $categories = $this->categories($catalog);
        $category = (string) $request->query('category', 'All');
        $validCategories = array_column($categories, 'name');
        if ($category !== 'All' && !in_array($category, $validCategories, true)) {
            $category = 'All';
        }

        $q = trim((string) $request->query('q', ''));
        $q = mb_substr($q, 0, 90);
        $sort = (string) $request->query('sort', 'featured');
        if (!in_array($sort, ['featured', 'newest', 'price_low', 'price_high', 'rating'], true)) {
            $sort = 'featured';
        }
        $maxPrice = (string) $request->query('max_price', 'all');
        if (!in_array($maxPrice, ['all', '1500', '3000', '5000'], true)) {
            $maxPrice = 'all';
        }

        $products = collect($catalog)
            ->filter(fn ($p) => $category === 'All' || $p['category'] === $category)
            ->filter(fn ($p) => $q === '' || str_contains(mb_strtolower($p['name'].' '.$p['category'].' '.$p['brand']), mb_strtolower($q)))
            ->filter(fn ($p) => $maxPrice === 'all' || $p['price'] <= (int) $maxPrice);

        $products = match ($sort) {
            'newest' => $products->sortByDesc('id'),
            'price_low' => $products->sortBy('price'),
            'price_high' => $products->sortByDesc('price'),
            'rating' => $products->sortByDesc('rating'),
            default => $products->sortByDesc(fn ($p) => ($p['featured'] ? 100 : 0) + $p['rating']),
        };

        return view('pages.shop', [
            'products' => $products->values()->all(),
            'categories' => $categories,
            'category' => $category,
            'q' => $q,
            'sort' => $sort,
            'maxPrice' => $maxPrice,
            'cartCount' => $this->cartCount($request),
        ]);
    }

    public function cart(Request $request): View
    {
        $catalog = collect($this->catalog())->keyBy('id');
        $items = [];
        $subtotal = 0;

        foreach ($request->session()->get('storefront_cart', []) as $id => $qty) {
            if (!$catalog->has((int) $id)) {
                continue;
            }
            $product = $catalog->get((int) $id);
            $quantity = max(1, min(99, (int) $qty));
            $lineTotal = $product['price'] * $quantity;
            $items[] = ['product' => $product, 'quantity' => $quantity, 'lineTotal' => $lineTotal];
            $subtotal += $lineTotal;
        }

        return view('pages.cart', [
            'items' => $items,
            'subtotal' => $subtotal,
            'cartCount' => $this->cartCount($request),
        ]);
    }

    public function addToCart(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => ['required', 'integer'],
            'quantity' => ['nullable', 'integer', 'min:1', 'max:99'],
        ]);
        $productId = (int) $validated['product_id'];
        $product = collect($this->catalog())->firstWhere('id', $productId);

        if (!$product) {
            return back()->with('error', 'This product is unavailable.');
        }

        $cart = $request->session()->get('storefront_cart', []);
        $cart[$productId] = min(99, ($cart[$productId] ?? 0) + (int) ($validated['quantity'] ?? 1));
        $request->session()->put('storefront_cart', $cart);

        return back()->with('success', $product['name'].' added to your bag.');
    }

    public function updateCart(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => ['required', 'integer'],
            'quantity' => ['required', 'integer', 'min:0', 'max:99'],
        ]);
        $cart = $request->session()->get('storefront_cart', []);
        $id = (int) $validated['product_id'];
        if (array_key_exists($id, $cart)) {
            if ((int) $validated['quantity'] === 0) {
                unset($cart[$id]);
            } else {
                $cart[$id] = (int) $validated['quantity'];
            }
            $request->session()->put('storefront_cart', $cart);
        }

        return back()->with('success', 'Your bag has been updated.');
    }

    private function cartCount(Request $request): int
    {
        return array_sum(array_map('intval', $request->session()->get('storefront_cart', [])));
    }

    private function categories(array $catalog): array
    {
        $meta = [
            'Electronics' => ['slug' => 'electronics', 'description' => 'Smart, everyday essentials', 'image' => 'headphones.svg'],
            'Home & Living' => ['slug' => 'home-living', 'description' => 'Make space feel like yours', 'image' => 'lamp.svg'],
            'Fashion' => ['slug' => 'fashion', 'description' => 'Everyday looks, elevated', 'image' => 'sneakers.svg'],
            'Accessories' => ['slug' => 'accessories', 'description' => 'The little finishing touches', 'image' => 'watch.svg'],
        ];
        return collect($meta)->map(fn ($details, $name) => array_merge($details, [
            'name' => $name,
            'count' => count(array_filter($catalog, fn ($p) => $p['category'] === $name)),
        ]))->values()->all();
    }

    /**
     * Demo data so the pages work before a Product model/database is connected.
     * Replace this method with an Eloquent query when you connect your product catalog.
     */
    private function catalog(): array
    {
        return [
            ['id' => 101, 'name' => 'Studio Wireless Headphones', 'brand' => 'SONORA', 'category' => 'Electronics', 'price' => 2890, 'old_price' => 3490, 'rating' => 4.9, 'reviews' => 124, 'badge' => 'BEST SELLER', 'image' => 'headphones.svg', 'featured' => true],
            ['id' => 102, 'name' => 'Arc Table Lamp', 'brand' => 'FORM & CO.', 'category' => 'Home & Living', 'price' => 1990, 'old_price' => null, 'rating' => 4.8, 'reviews' => 86, 'badge' => 'NEW', 'image' => 'lamp.svg', 'featured' => true],
            ['id' => 103, 'name' => 'Tempo Analog Watch', 'brand' => 'MINUTE', 'category' => 'Accessories', 'price' => 3290, 'old_price' => 3790, 'rating' => 4.9, 'reviews' => 92, 'badge' => '', 'image' => 'watch.svg', 'featured' => true],
            ['id' => 104, 'name' => 'Daybreak Everyday Sneakers', 'brand' => 'WALK CLUB', 'category' => 'Fashion', 'price' => 2490, 'old_price' => null, 'rating' => 4.7, 'reviews' => 68, 'badge' => 'POPULAR', 'image' => 'sneakers.svg', 'featured' => true],
            ['id' => 105, 'name' => 'Sage Canvas Tote', 'brand' => 'MELLOW', 'category' => 'Fashion', 'price' => 790, 'old_price' => 990, 'rating' => 4.8, 'reviews' => 120, 'badge' => '', 'image' => 'tote.svg', 'featured' => false],
            ['id' => 106, 'name' => 'Compact Bluetooth Speaker', 'brand' => 'SONORA', 'category' => 'Electronics', 'price' => 1490, 'old_price' => null, 'rating' => 4.6, 'reviews' => 53, 'badge' => '', 'image' => 'speaker.svg', 'featured' => false],
            ['id' => 107, 'name' => 'Drift Ceramic Mug', 'brand' => 'FORM & CO.', 'category' => 'Home & Living', 'price' => 690, 'old_price' => null, 'rating' => 4.9, 'reviews' => 44, 'badge' => 'NEW', 'image' => 'mug.svg', 'featured' => false],
            ['id' => 108, 'name' => 'Lumen Mechanical Keyboard', 'brand' => 'KEYWORKS', 'category' => 'Electronics', 'price' => 3990, 'old_price' => 4490, 'rating' => 4.8, 'reviews' => 37, 'badge' => '', 'image' => 'keyboard.svg', 'featured' => false],
            ['id' => 109, 'name' => 'Ridge Stainless Bottle', 'brand' => 'MELLOW', 'category' => 'Accessories', 'price' => 890, 'old_price' => null, 'rating' => 4.7, 'reviews' => 105, 'badge' => '', 'image' => 'bottle.svg', 'featured' => false],
            ['id' => 110, 'name' => 'Mira Reading Chair', 'brand' => 'FORM & CO.', 'category' => 'Home & Living', 'price' => 4990, 'old_price' => null, 'rating' => 4.9, 'reviews' => 21, 'badge' => 'LIMITED', 'image' => 'chair.svg', 'featured' => false],
            ['id' => 111, 'name' => 'Solstice Sunglasses', 'brand' => 'MINUTE', 'category' => 'Accessories', 'price' => 1190, 'old_price' => 1490, 'rating' => 4.6, 'reviews' => 63, 'badge' => '', 'image' => 'glasses.svg', 'featured' => false],
            ['id' => 112, 'name' => 'Weekender Crossbody Bag', 'brand' => 'MELLOW', 'category' => 'Fashion', 'price' => 1690, 'old_price' => null, 'rating' => 4.8, 'reviews' => 39, 'badge' => '', 'image' => 'crossbody.svg', 'featured' => false],
        ];
    }
}
