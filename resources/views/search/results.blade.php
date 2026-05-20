<x-layouts.app :title="'Search: '.request('q').' — Lens'">

    <div class="mx-auto max-w-7xl px-4 py-10 lg:px-8">

        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-xl font-extrabold text-brand-dark md:text-2xl">
                Results for "<span class="text-brand-teal">{{ request('q') }}</span>"
            </h1>
            <p class="mt-1 text-sm text-slate-500">{{ $products->total() ?? 0 }} products found</p>
        </div>

        @if(($products->total() ?? 0) === 0)
        <div class="flex flex-col items-center gap-5 py-24 text-center">
            <span class="text-6xl">🔍</span>
            <h2 class="text-xl font-bold text-brand-dark">No results for "{{ request('q') }}"</h2>
            <p class="text-sm text-slate-500">Try a different keyword, or browse our categories.</p>
            <div class="flex flex-wrap justify-center gap-2 mt-2">
                @foreach(['Contact Lenses', 'Sunglasses', 'Ray-Ban', 'Color Lenses'] as $sug)
                <a href="/search?q={{ urlencode($sug) }}"
                   class="rounded-full bg-brand-teal/10 px-4 py-2 text-sm font-semibold text-brand-teal hover:bg-brand-teal hover:text-white transition-colors">
                    {{ $sug }}
                </a>
                @endforeach
            </div>
        </div>
        @else
        <div class="grid grid-cols-2 gap-4 md:gap-5 lg:grid-cols-4">
            @foreach($products as $product)
                @include('components.product-card', ['product' => is_array($product) ? $product : $product->toArray()])
            @endforeach
        </div>
        @if(method_exists($products, 'hasPages') && $products->hasPages())
        <div class="mt-10">{{ $products->links() }}</div>
        @endif
        @endif
    </div>

</x-layouts.app>
