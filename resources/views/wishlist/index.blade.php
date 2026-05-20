<x-layouts.app title="Wishlist — Lens">

    <div class="mx-auto max-w-7xl px-4 py-10 lg:px-8">
        <div class="mb-8 flex items-baseline justify-between">
            <h1 class="text-2xl font-extrabold text-brand-dark md:text-3xl">My Wishlist</h1>
            @if(!empty($wishlistItems ?? []))
            <p class="text-sm text-slate-500">{{ count($wishlistItems) }} saved item(s)</p>
            @endif
        </div>

        @if(empty($wishlistItems ?? []))
        <div class="flex flex-col items-center gap-5 py-24 text-center">
            <span class="text-6xl">💛</span>
            <h2 class="text-xl font-bold text-brand-dark">Your wishlist is empty</h2>
            <p class="text-sm text-slate-500">Save items you love and come back to them anytime.</p>
            <a href="{{ route('home') }}"
               class="rounded-full bg-brand-teal px-8 py-3.5 text-sm font-bold text-white hover:bg-teal-600 transition-colors">
                Discover Products
            </a>
        </div>
        @else
        <div class="grid grid-cols-2 gap-4 md:gap-6 lg:grid-cols-4">
            @foreach($wishlistItems as $product)
                @include('components.product-card', ['product' => $product])
            @endforeach
        </div>
        @endif
    </div>

</x-layouts.app>
