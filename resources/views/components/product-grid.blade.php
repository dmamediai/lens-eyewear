{{-- ============================================================
     Product Grid Section
     Props: $title, $subtitle, $products, $viewAllHref, $cols (default 4)
     ============================================================ --}}
<section class="py-12 md:py-16">
    <div class="mx-auto max-w-7xl px-4 lg:px-8">

        {{-- Section header --}}
        @if($title ?? false)
        <div class="mb-8 flex items-end justify-between">
            <div>
                <h2 class="text-2xl font-extrabold text-brand-dark md:text-3xl">{{ $title }}</h2>
                @if($subtitle ?? false)
                    <p class="mt-1 text-sm text-slate-500">{{ $subtitle }}</p>
                @endif
            </div>
            @if($viewAllHref ?? false)
                <a href="{{ $viewAllHref }}"
                   class="flex items-center gap-1 text-sm font-semibold text-brand-teal hover:gap-2 transition-all">
                    View All
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" d="m9 18 6-6-6-6"/>
                    </svg>
                </a>
            @endif
        </div>
        @endif

        {{-- Tab filters (optional) --}}
        @if($tabs ?? false)
        <div class="mb-6 flex gap-2 overflow-x-auto pb-2 scrollbar-none">
            @foreach($tabs as $i => $tab)
                <button onclick="filterTab(this, '{{ $tab['key'] }}')"
                        data-tab="{{ $tab['key'] }}"
                        class="tab-btn flex-none rounded-full px-4 py-2 text-sm font-medium transition-colors
                               {{ $i === 0 ? 'bg-brand-teal text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    {{ $tab['label'] }}
                </button>
            @endforeach
        </div>
        @endif

        {{-- Grid --}}
        <div class="grid grid-cols-2 gap-4 md:gap-6
                    {{ ($cols ?? 4) === 3 ? 'lg:grid-cols-3' : 'lg:grid-cols-4' }}">
            @forelse($products ?? [] as $product)
                @include('components.product-card', ['product' => $product])
            @empty
                <div class="col-span-full py-16 text-center text-slate-400">
                    <svg class="mx-auto mb-3 h-12 w-12 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" d="M20 13V6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v7m16 0v5a2 2 0 0 0-2 2H6a2 2 0 0 0-2-2v-5m16 0H4"/>
                    </svg>
                    <p class="font-medium">No products found</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<script>
function filterTab(btn, key) {
    document.querySelectorAll('.tab-btn').forEach(b => {
        b.classList.remove('bg-brand-teal', 'text-white');
        b.classList.add('bg-slate-100', 'text-slate-600');
    });
    btn.classList.add('bg-brand-teal', 'text-white');
    btn.classList.remove('bg-slate-100', 'text-slate-600');
    // Extend: fetch /api/products?category=key and re-render cards
}

function addToCart(slug) {
    fetch(`/cart/add`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.content ?? '' },
        body: JSON.stringify({ slug, qty: 1 })
    })
    .then(r => r.json())
    .then(data => {
        const count = document.getElementById('cart-count');
        if (count) count.textContent = data.cart_count;
    });
}
</script>
