{{-- ============================================================
     Product Card — reusable across all grids
     Props: $product (array with keys below)
       name, brand, price, original_price, image, images[],
       colors[], rating, review_count, badge, slug, is_bogo
     ============================================================ --}}
@php
    $discount = isset($product['original_price']) && $product['original_price'] > 0
        ? round((1 - $product['price'] / $product['original_price']) * 100)
        : 0;
@endphp

<article class="group relative flex flex-col rounded-2xl bg-white ring-1 ring-slate-100
                hover:ring-brand-teal/40 hover:shadow-xl transition-all duration-300">

    {{-- Image container --}}
    <div class="relative overflow-hidden rounded-t-2xl bg-slate-50">

        {{-- Badges --}}
        <div class="absolute left-3 top-3 z-10 flex flex-col gap-1.5">
            @if($product['is_bogo'] ?? false)
                <span class="rounded-full bg-brand-teal px-2.5 py-1 text-[11px] font-bold uppercase text-white leading-none shadow">
                    B1G1 Free
                </span>
            @endif
            @if($discount > 0)
                <span class="rounded-full bg-brand-badge px-2.5 py-1 text-[11px] font-bold text-white leading-none shadow">
                    −{{ $discount }}%
                </span>
            @endif
            @if($product['badge'] ?? false)
                <span class="rounded-full bg-brand-dark px-2.5 py-1 text-[11px] font-bold text-white leading-none shadow">
                    {{ $product['badge'] }}
                </span>
            @endif
        </div>

        {{-- Wishlist --}}
        <button aria-label="Add to wishlist"
                class="absolute right-3 top-3 z-10 rounded-full bg-white/80 p-1.5 shadow backdrop-blur-sm
                       text-slate-400 hover:text-brand-badge hover:bg-white transition-all
                       opacity-0 group-hover:opacity-100">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
            </svg>
        </button>

        {{-- Product image with hover swap --}}
        <a href="/products/{{ $product['slug'] ?? '#' }}" class="block aspect-square overflow-hidden">
            <img src="{{ $product['image'] }}"
                 alt="{{ $product['name'] }}"
                 class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105" />
        </a>

        {{-- Quick-add (slides up on hover) --}}
        <div class="absolute inset-x-0 bottom-0 translate-y-full transition-transform duration-300 group-hover:translate-y-0">
            <button onclick="addToCart('{{ $product['slug'] ?? '' }}')"
                    class="w-full bg-brand-teal py-3 text-sm font-bold text-white hover:bg-teal-600 transition-colors">
                Quick Add to Cart
            </button>
        </div>
    </div>

    {{-- Card body --}}
    <div class="flex flex-1 flex-col gap-2 p-4">

        {{-- Brand --}}
        @if($product['brand'] ?? false)
            <p class="text-[11px] font-semibold uppercase tracking-widest text-brand-teal">{{ $product['brand'] }}</p>
        @endif

        {{-- Name --}}
        <a href="/products/{{ $product['slug'] ?? '#' }}"
           class="text-sm font-semibold leading-snug text-brand-dark line-clamp-2 hover:text-brand-teal transition-colors">
            {{ $product['name'] }}
        </a>

        {{-- Color swatches --}}
        @if(!empty($product['colors']))
        <div class="flex items-center gap-1.5">
            @foreach(array_slice($product['colors'], 0, 5) as $color)
                <button style="background-color: {{ $color['hex'] }};"
                        title="{{ $color['name'] }}"
                        aria-label="Color: {{ $color['name'] }}"
                        class="h-4 w-4 rounded-full ring-1 ring-white ring-offset-1 hover:ring-brand-teal transition-shadow">
                </button>
            @endforeach
            @if(count($product['colors']) > 5)
                <span class="text-[11px] text-slate-400">+{{ count($product['colors']) - 5 }}</span>
            @endif
        </div>
        @endif

        {{-- Rating --}}
        @if(isset($product['rating']) && $product['rating'] > 0)
        <div class="flex items-center gap-1.5">
            <div class="flex text-amber-400" aria-label="Rating: {{ $product['rating'] }} out of 5">
                @for($i = 1; $i <= 5; $i++)
                    @if($i <= floor($product['rating']))
                        <svg class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 0 0 .95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 0 0-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 0 0-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 0 0-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 0 0 .951-.69l1.07-3.292z"/>
                        </svg>
                    @else
                        <svg class="h-3.5 w-3.5 text-slate-200" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 0 0 .95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 0 0-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 0 0-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 0 0-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 0 0 .951-.69l1.07-3.292z"/>
                        </svg>
                    @endif
                @endfor
            </div>
            <span class="text-[11px] text-slate-400">({{ number_format($product['review_count'] ?? 0) }})</span>
        </div>
        @endif

        {{-- Price --}}
        <div class="mt-auto flex items-baseline gap-2 pt-1">
            <span class="text-base font-extrabold text-brand-dark">
                AED {{ number_format($product['price'], 0) }}
            </span>
            @if($product['original_price'] ?? false)
                <span class="text-sm text-slate-400 line-through">
                    AED {{ number_format($product['original_price'], 0) }}
                </span>
            @endif
        </div>
    </div>
</article>
