<x-layouts.app title="Your Cart — Lens">

    <div class="mx-auto max-w-7xl px-4 py-10 lg:px-8">
        <h1 class="mb-8 text-2xl font-extrabold text-brand-dark md:text-3xl">Your Cart</h1>

        @if(empty($cartItems ?? []))
        {{-- Empty cart --}}
        <div class="flex flex-col items-center gap-5 py-24 text-center">
            <span class="text-6xl">🛒</span>
            <h2 class="text-xl font-bold text-brand-dark">Your cart is empty</h2>
            <p class="text-sm text-slate-500">Looks like you haven't added anything yet.</p>
            <a href="{{ route('home') }}"
               class="rounded-full bg-brand-teal px-8 py-3.5 text-sm font-bold text-white hover:bg-teal-600 transition-colors">
                Start Shopping
            </a>
        </div>
        @else
        <div class="grid gap-8 lg:grid-cols-3">

            {{-- Line items --}}
            <div class="col-span-2">
                <div class="rounded-2xl bg-white ring-1 ring-slate-100 shadow-sm overflow-hidden">
                    @foreach($cartItems as $item)
                    <div class="flex items-start gap-4 border-b border-slate-50 p-5 last:border-0">
                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}"
                             class="h-20 w-20 flex-shrink-0 rounded-xl object-cover bg-slate-100" />
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-semibold uppercase tracking-wide text-brand-teal">{{ $item['brand'] }}</p>
                            <p class="font-semibold text-brand-dark line-clamp-1">{{ $item['name'] }}</p>
                            @if($item['attrs'] ?? false)
                            <p class="text-xs text-slate-400 mt-0.5">{{ implode(' · ', $item['attrs']) }}</p>
                            @endif
                            <div class="mt-3 flex items-center gap-4">
                                {{-- Qty stepper --}}
                                <div class="flex h-9 w-28 overflow-hidden rounded-xl border border-slate-200">
                                    <button type="button" onclick="updateQty('{{ $item['id'] }}', -1)"
                                            class="flex-1 text-slate-500 hover:bg-slate-50 transition-colors">−</button>
                                    <span id="qty-{{ $item['id'] }}" class="flex items-center justify-center w-10 text-sm font-bold border-x border-slate-200">
                                        {{ $item['qty'] }}
                                    </span>
                                    <button type="button" onclick="updateQty('{{ $item['id'] }}', 1)"
                                            class="flex-1 text-slate-500 hover:bg-slate-50 transition-colors">+</button>
                                </div>
                                <form action="/cart/{{ $item['id'] }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-xs font-semibold text-slate-400 hover:text-brand-badge transition-colors">Remove</button>
                                </form>
                            </div>
                        </div>
                        <p class="flex-shrink-0 font-extrabold text-brand-dark">AED {{ number_format($item['price'] * $item['qty'], 0) }}</p>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Order Summary --}}
            <div class="flex flex-col gap-5">
                <div class="rounded-2xl bg-white p-6 ring-1 ring-slate-100 shadow-sm">
                    <h2 class="mb-4 text-base font-bold text-brand-dark">Order Summary</h2>

                    {{-- Coupon --}}
                    <form action="/cart/coupon" method="POST" class="mb-5 flex gap-2">
                        @csrf
                        <input type="text" name="coupon" placeholder="Coupon code"
                               class="flex-1 rounded-xl border border-slate-200 px-3 py-2.5 text-sm focus:border-brand-teal focus:outline-none focus:ring-2 focus:ring-brand-teal/20" />
                        <button type="submit"
                                class="rounded-xl bg-brand-dark px-4 text-sm font-semibold text-white hover:bg-slate-800 transition-colors">
                            Apply
                        </button>
                    </form>

                    {{-- Totals --}}
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between text-slate-600">
                            <span>Subtotal</span>
                            <span>AED {{ number_format($subtotal ?? 0, 0) }}</span>
                        </div>
                        @if(($discount ?? 0) > 0)
                        <div class="flex justify-between text-green-600 font-medium">
                            <span>Coupon discount</span>
                            <span>−AED {{ number_format($discount, 0) }}</span>
                        </div>
                        @endif
                        <div class="flex justify-between text-slate-600">
                            <span>Shipping</span>
                            <span>{{ ($shipping ?? 0) > 0 ? 'AED '.number_format($shipping, 0) : '🎉 Free' }}</span>
                        </div>
                        <div class="flex justify-between border-t border-slate-100 pt-3 text-base font-extrabold text-brand-dark">
                            <span>Total</span>
                            <span>AED {{ number_format(($subtotal ?? 0) - ($discount ?? 0) + ($shipping ?? 0), 0) }}</span>
                        </div>
                    </div>

                    <a href="/checkout"
                       class="mt-6 flex w-full items-center justify-center rounded-full bg-brand-teal py-4 text-sm font-bold text-white shadow-lg shadow-brand-teal/30 hover:bg-teal-600 hover:-translate-y-0.5 transition-all">
                        Proceed to Checkout
                        <svg class="ml-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" d="m9 18 6-6-6-6"/></svg>
                    </a>
                    <a href="{{ route('home') }}" class="mt-3 block text-center text-xs font-semibold text-slate-400 hover:text-brand-teal transition-colors">
                        ← Continue Shopping
                    </a>
                </div>

                {{-- Trust --}}
                <div class="rounded-2xl bg-brand-light p-4 text-center">
                    <p class="text-xs text-slate-500">🔒 Secure SSL checkout &nbsp;|&nbsp; 🚚 Free shipping over AED 150</p>
                </div>
            </div>
        </div>
        @endif
    </div>

    <script>
    function updateQty(id, delta) {
        const el  = document.getElementById('qty-' + id);
        const qty = Math.max(1, parseInt(el.textContent) + delta);
        el.textContent = qty;
        fetch('/cart/' + id, {
            method: 'PATCH',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.content ?? '' },
            body: JSON.stringify({ qty })
        }).then(() => location.reload());
    }
    </script>

</x-layouts.app>
