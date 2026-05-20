{{-- ============================================================
     Responsive Navigation Bar — sticky, with search overlay
     ============================================================ --}}
<header class="sticky top-0 z-40 w-full bg-white shadow-sm">

    {{-- Promo ribbon --}}
    <div class="bg-brand-teal py-2 text-center text-xs font-semibold tracking-wide text-white md:text-sm">
        🎉 Buy 1 Get 1 FREE on all frames &nbsp;|&nbsp; Free shipping on orders over AED 150
        <button class="ml-4 opacity-70 hover:opacity-100" onclick="this.parentElement.remove()" aria-label="Close">✕</button>
    </div>

    {{-- Main nav --}}
    <nav class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-3 lg:px-8" aria-label="Main navigation">

        {{-- Logo --}}
        <a href="{{ route('home') }}" class="flex-shrink-0" aria-label="Lens home">
            <span class="text-2xl font-extrabold tracking-tight text-brand-dark">
                lens<span class="text-brand-teal">.</span>
            </span>
        </a>

        {{-- Desktop category links --}}
        <ul class="hidden items-center gap-1 lg:flex" role="list">
            @foreach([
                ['label' => 'Eyeglasses',      'href' => '/eyeglasses',      'badge' => null],
                ['label' => 'Sunglasses',       'href' => '/sunglasses',       'badge' => 'New'],
                ['label' => 'Contact Lenses',   'href' => '/contact-lenses',   'badge' => null],
                ['label' => 'Color Lenses',     'href' => '/color-lenses',     'badge' => 'Hot'],
                ['label' => 'Accessories',      'href' => '/accessories',      'badge' => null],
                ['label' => 'Brands',           'href' => '/brands',           'badge' => null],
            ] as $item)
            <li>
                <a href="{{ $item['href'] }}"
                   class="group relative flex items-center gap-1.5 rounded-md px-3 py-2 text-sm font-medium text-slate-600
                          hover:text-brand-teal transition-colors">
                    {{ $item['label'] }}
                    @if($item['badge'])
                        <span class="rounded-full bg-brand-teal px-1.5 py-0.5 text-[10px] font-bold text-white leading-none">
                            {{ $item['badge'] }}
                        </span>
                    @endif
                    <span class="absolute bottom-0 left-3 right-3 h-0.5 scale-x-0 rounded-full bg-brand-teal
                                 transition-transform group-hover:scale-x-100"></span>
                </a>
            </li>
            @endforeach
        </ul>

        {{-- Right-side actions --}}
        <div class="flex items-center gap-2">

            {{-- Search --}}
            <button onclick="openSearch()" aria-label="Open search"
                    class="rounded-full p-2 text-slate-500 hover:bg-slate-100 hover:text-brand-teal transition-colors">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"/><path stroke-linecap="round" d="m21 21-4.35-4.35"/>
                </svg>
            </button>

            {{-- Account (desktop) --}}
            <a href="/account" aria-label="Account"
               class="hidden rounded-full p-2 text-slate-500 hover:bg-slate-100 hover:text-brand-teal transition-colors md:block">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                    <circle cx="12" cy="7" r="4"/>
                </svg>
            </a>

            {{-- Wishlist --}}
            <a href="/wishlist" aria-label="Wishlist"
               class="hidden rounded-full p-2 text-slate-500 hover:bg-slate-100 hover:text-brand-teal transition-colors md:block">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                </svg>
            </a>

            {{-- Cart --}}
            <a href="/cart" aria-label="Shopping cart"
               class="relative rounded-full p-2 text-slate-500 hover:bg-slate-100 hover:text-brand-teal transition-colors">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/>
                    <line x1="3" y1="6" x2="21" y2="6"/>
                    <path stroke-linecap="round" d="M16 10a4 4 0 0 1-8 0"/>
                </svg>
                <span id="cart-count"
                      class="absolute -right-1 -top-1 flex h-4 w-4 items-center justify-center rounded-full
                             bg-brand-teal text-[10px] font-bold text-white">
                    {{ session('cart_count', 0) }}
                </span>
            </a>

            {{-- Hamburger (mobile) --}}
            <button onclick="toggleMenu()" aria-label="Open menu"
                    class="rounded-full p-2 text-slate-500 hover:bg-slate-100 lg:hidden">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <line x1="3" y1="6"  x2="21" y2="6"/>
                    <line x1="3" y1="12" x2="21" y2="12"/>
                    <line x1="3" y1="18" x2="21" y2="18"/>
                </svg>
            </button>
        </div>
    </nav>

    {{-- Mobile drawer --}}
    <div id="mobile-menu" class="hidden border-t border-slate-100 bg-white lg:hidden">
        <ul class="flex flex-col divide-y divide-slate-50 px-4 pb-4" role="list">
            @foreach([
                'Eyeglasses', 'Sunglasses', 'Contact Lenses', 'Color Lenses', 'Accessories', 'Brands'
            ] as $link)
            <li>
                <a href="/{{ Str::slug($link) }}"
                   class="flex items-center justify-between py-3.5 text-sm font-medium text-slate-700 hover:text-brand-teal transition-colors">
                    {{ $link }}
                    <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" d="m9 18 6-6-6-6"/>
                    </svg>
                </a>
            </li>
            @endforeach
            <li class="pt-4 flex gap-3">
                <a href="/account" class="flex-1 rounded-full border border-slate-200 py-2.5 text-center text-sm font-semibold hover:border-brand-teal hover:text-brand-teal transition-colors">Account</a>
                <a href="/wishlist" class="flex-1 rounded-full border border-slate-200 py-2.5 text-center text-sm font-semibold hover:border-brand-teal hover:text-brand-teal transition-colors">Wishlist</a>
            </li>
        </ul>
    </div>

</header>
