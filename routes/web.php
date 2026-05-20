<?php

use Illuminate\Support\Facades\Route;
use App\Models\Product;

// ── Public storefront ───────────────────────────────────────────────

Route::get('/', function () {
    $featured = Product::active()->featured()->get()->map(fn($p) => $p->toArray());
    return view('home');
})->name('home');

// Category listing pages
foreach ([
    'eyeglasses'    => 'Eyeglasses',
    'sunglasses'    => 'Sunglasses',
    'contact-lenses'=> 'Contact Lenses',
    'color-lenses'  => 'Color Lenses',
    'accessories'   => 'Accessories',
] as $slug => $title) {
    Route::get("/{$slug}", function () use ($slug, $title) {
        $products = Product::active()->byCategory($slug)
            ->when(request('brand'),     fn($q) => $q->whereIn('brand', (array)request('brand')))
            ->when(request('min_price'), fn($q) => $q->where('price', '>=', request('min_price')))
            ->when(request('max_price'), fn($q) => $q->where('price', '<=', request('max_price')))
            ->when(request('rating'),    fn($q) => $q->where('rating', '>=', request('rating')))
            ->when(request('sort') === 'price_asc',  fn($q) => $q->orderBy('price'))
            ->when(request('sort') === 'price_desc', fn($q) => $q->orderByDesc('price'))
            ->when(request('sort') === 'newest',     fn($q) => $q->latest())
            ->when(request('sort') === 'rating',     fn($q) => $q->orderByDesc('rating'))
            ->paginate(20)->withQueryString();
        return view('products.listing', compact('products', 'title'));
    })->name($slug);
}

Route::get('/brands', fn() => view('brands.index'))->name('brands');

// Product Detail
Route::get('/products/{slug}', function (string $slug) {
    $product = Product::where('slug', $slug)->active()->firstOrFail()->toArray();
    $related = Product::active()
        ->where('category_id', Product::where('slug', $slug)->value('category_id'))
        ->where('slug', '!=', $slug)
        ->limit(4)->get()->map(fn($p) => $p->toArray())->toArray();
    return view('products.contact-lenses', compact('product', 'related'));
})->name('product.show');

// Search
Route::get('/search', function () {
    $q        = request('q', '');
    $products = Product::active()
        ->where(fn($q2) => $q2->where('name', 'like', "%{$q}%")->orWhere('brand', 'like', "%{$q}%"))
        ->paginate(20)->withQueryString();
    return view('search.results', compact('products'));
})->name('search');

// Cart
Route::get('/cart',               fn() => view('cart.index', ['cartItems' => session('cart', [])]))->name('cart');
Route::post('/cart/add',          function () {
    $cart = session('cart', []);
    $id   = request('slug') . '-' . uniqid();
    $cart[$id] = ['id'=>$id,'name'=>request('name','Product'),'price'=>request('price',0),'qty'=>1,'image'=>'/images/placeholder.jpg','brand'=>''];
    session(['cart' => $cart, 'cart_count' => count($cart)]);
    return response()->json(['cart_count' => count($cart)]);
})->name('cart.add');
Route::delete('/cart/{id}',       function (string $id) { $cart = session('cart',[]); unset($cart[$id]); session(['cart'=>$cart,'cart_count'=>count($cart)]); return back(); })->name('cart.remove');
Route::patch('/cart/{id}',        function (string $id) { $cart = session('cart',[]); if(isset($cart[$id])) $cart[$id]['qty'] = max(1,(int)request('qty',1)); session(['cart'=>$cart]); return response()->json(['ok'=>true]); })->name('cart.update');

// Checkout
Route::get('/checkout',          fn() => view('checkout.index'))->name('checkout');
Route::post('/checkout/process', fn() => redirect('/checkout/success')->with('order_number','ORD-'.strtoupper(substr(uniqid(),0,6))))->name('checkout.process');
Route::get('/checkout/success',  fn() => view('checkout.success', ['orderNumber' => session('order_number')]))->name('checkout.success');

// Wishlist
Route::get('/wishlist',          fn() => view('wishlist.index', ['wishlistItems' => session('wishlist', [])]))->name('wishlist');
Route::post('/wishlist/toggle',  fn() => back())->name('wishlist.toggle');

// Account
Route::prefix('account')->name('account.')->group(function () {
    Route::get('/orders',            fn() => view('account.orders', ['orders' => []]))->name('orders');
    Route::get('/orders/{id}',       fn($id) => abort(404))->name('order.show');
    Route::get('/profile',           fn() => view('account.profile' ))->name('profile');
});

// Virtual Try-On
Route::get('/virtual-try-on', fn() => view('try-on.index'))->name('try-on');

// Newsletter
Route::post('/newsletter', function (\Illuminate\Http\Request $req) {
    $req->validate(['email' => 'required|email']);
    return response()->json(['status' => 'subscribed']);
})->name('newsletter');

// Guides
Route::get('/guides/{slug}', fn(string $slug) => abort(404))->name('guides.show');

// Legal
Route::get('/privacy', fn() => view('legal.privacy'))->name('privacy');
Route::get('/terms',   fn() => view('legal.terms'))->name('terms');

// ── Admin dashboard ─────────────────────────────────────────────────
require __DIR__.'/admin.php';
