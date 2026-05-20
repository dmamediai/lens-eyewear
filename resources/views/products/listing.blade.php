<x-layouts.app :title="$title . ' — Lens'">

    <div class="mx-auto max-w-7xl px-4 py-8 lg:px-8">

        {{-- Breadcrumb + heading --}}
        <div class="mb-6">
            <nav class="mb-2 flex gap-1.5 text-xs text-slate-400">
                <a href="{{ route('home') }}" class="hover:text-brand-teal transition-colors">Home</a>
                <span>/</span>
                <span class="font-medium text-brand-dark">{{ $title }}</span>
            </nav>
            <div class="flex items-baseline justify-between">
                <h1 class="text-2xl font-extrabold text-brand-dark md:text-3xl">{{ $title }}</h1>
                <p class="text-sm text-slate-500">{{ $products->total() ?? count($products) }} products</p>
            </div>
        </div>

        <div class="flex gap-8">

            {{-- ── Filter Sidebar ── --}}
            <aside class="hidden w-60 flex-shrink-0 lg:block">
                <form method="GET" id="filter-form" class="flex flex-col gap-6">

                    {{-- Active filters --}}
                    @if(request()->hasAny(['brand','min_price','max_price','color']))
                    <div class="flex flex-wrap gap-2">
                        @foreach(request()->only(['brand','min_price','max_price','color']) as $key => $val)
                        <a href="{{ request()->fullUrlWithoutParameters([$key]) }}"
                           class="flex items-center gap-1 rounded-full bg-brand-teal/10 px-3 py-1 text-xs font-semibold text-brand-teal hover:bg-brand-teal hover:text-white transition-colors">
                            {{ ucfirst($key) }}: {{ $val }} ✕
                        </a>
                        @endforeach
                    </div>
                    @endif

                    {{-- Sort --}}
                    <div>
                        <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-400">Sort By</label>
                        <select name="sort" onchange="this.form.submit()"
                                class="w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm focus:border-brand-teal focus:outline-none">
                            <option value="popular"   {{ request('sort') === 'popular'    ? 'selected' : '' }}>Most Popular</option>
                            <option value="price_asc" {{ request('sort') === 'price_asc'  ? 'selected' : '' }}>Price: Low → High</option>
                            <option value="price_desc"{{ request('sort') === 'price_desc' ? 'selected' : '' }}>Price: High → Low</option>
                            <option value="newest"    {{ request('sort') === 'newest'     ? 'selected' : '' }}>Newest</option>
                            <option value="rating"    {{ request('sort') === 'rating'     ? 'selected' : '' }}>Top Rated</option>
                        </select>
                    </div>

                    {{-- Brand --}}
                    <div>
                        <p class="mb-2 text-xs font-bold uppercase tracking-wider text-slate-400">Brand</p>
                        <div class="flex flex-col gap-2">
                            @foreach(['Alcon', 'Solotica', 'Bella', 'Desio', 'Ray-Ban', 'Oakley', 'Gucci', 'Prada'] as $brand)
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="brand[]" value="{{ $brand }}"
                                       class="rounded border-slate-300 text-brand-teal focus:ring-brand-teal"
                                       {{ in_array($brand, (array)request('brand', [])) ? 'checked' : '' }}
                                       onchange="this.form.submit()" />
                                <span class="text-sm text-slate-700">{{ $brand }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Price Range --}}
                    <div>
                        <p class="mb-2 text-xs font-bold uppercase tracking-wider text-slate-400">Price (AED)</p>
                        <div class="flex items-center gap-2">
                            <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min"
                                   class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:border-brand-teal focus:outline-none" />
                            <span class="text-slate-400">–</span>
                            <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max"
                                   class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:border-brand-teal focus:outline-none" />
                        </div>
                        <button type="submit" class="mt-2 w-full rounded-xl bg-slate-100 py-2 text-xs font-semibold text-slate-700 hover:bg-brand-teal hover:text-white transition-colors">Apply</button>
                    </div>

                    {{-- Rating --}}
                    <div>
                        <p class="mb-2 text-xs font-bold uppercase tracking-wider text-slate-400">Min Rating</p>
                        @foreach([5, 4, 3] as $stars)
                        <label class="flex items-center gap-2 py-1 cursor-pointer">
                            <input type="radio" name="rating" value="{{ $stars }}"
                                   class="text-brand-teal focus:ring-brand-teal"
                                   {{ request('rating') == $stars ? 'checked' : '' }}
                                   onchange="this.form.submit()" />
                            <span class="text-amber-400 text-sm">{{ str_repeat('★', $stars) }}{{ str_repeat('☆', 5 - $stars) }}</span>
                            <span class="text-xs text-slate-500">& up</span>
                        </label>
                        @endforeach
                    </div>

                    <a href="{{ url()->current() }}"
                       class="block text-center text-xs font-semibold text-slate-400 hover:text-brand-teal transition-colors">
                        Clear all filters
                    </a>
                </form>
            </aside>

            {{-- ── Product Grid ── --}}
            <div class="flex-1">
                <div class="grid grid-cols-2 gap-4 md:gap-5 lg:grid-cols-3 xl:grid-cols-4">
                    @forelse($products as $product)
                        @include('components.product-card', ['product' => is_array($product) ? $product : $product->toArray()])
                    @empty
                    <div class="col-span-full py-20 text-center">
                        <p class="text-4xl mb-3">🔍</p>
                        <p class="font-semibold text-brand-dark">No products found</p>
                        <p class="text-sm text-slate-500 mt-1">Try adjusting your filters</p>
                        <a href="{{ url()->current() }}" class="mt-4 inline-block text-sm font-semibold text-brand-teal hover:underline">Clear filters</a>
                    </div>
                    @endforelse
                </div>

                @if(method_exists($products, 'hasPages') && $products->hasPages())
                <div class="mt-10">{{ $products->links() }}</div>
                @endif
            </div>
        </div>
    </div>

</x-layouts.app>
