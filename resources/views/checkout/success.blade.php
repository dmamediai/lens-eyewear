<x-layouts.app title="Order Confirmed — Lens">

    <div class="mx-auto max-w-2xl px-4 py-16 text-center lg:px-8">

        {{-- Animated check --}}
        <div class="mx-auto mb-6 flex h-24 w-24 items-center justify-center rounded-full bg-brand-teal/10">
            <svg class="h-12 w-12 text-brand-teal animate-bounce" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" d="M5 13l4 4L19 7"/>
            </svg>
        </div>

        <h1 class="text-3xl font-extrabold text-brand-dark">Order Confirmed!</h1>
        <p class="mt-2 text-slate-500">Thank you for your purchase. Your order is on its way.</p>

        {{-- Order number --}}
        <div class="mt-6 inline-block rounded-2xl bg-brand-teal/5 px-8 py-4 ring-1 ring-brand-teal/20">
            <p class="text-xs font-semibold uppercase tracking-wider text-brand-teal">Order Number</p>
            <p class="mt-1 font-mono text-2xl font-extrabold text-brand-dark">{{ $orderNumber ?? 'ORD-XXXXXX' }}</p>
        </div>

        {{-- Order summary --}}
        @if($order ?? false)
        <div class="mt-8 rounded-2xl bg-white p-6 ring-1 ring-slate-100 shadow-sm text-left">
            <h2 class="mb-4 text-sm font-bold text-brand-dark">What you ordered</h2>
            @foreach($order->items as $item)
            <div class="flex items-center gap-3 py-2 border-b border-slate-50 last:border-0">
                <img src="{{ $item['image'] ?? '/images/placeholder.jpg' }}" alt=""
                     class="h-12 w-12 rounded-lg object-cover bg-slate-100" />
                <div class="flex-1">
                    <p class="text-sm font-medium text-brand-dark">{{ $item['name'] }}</p>
                    <p class="text-xs text-slate-400">Qty: {{ $item['qty'] }}</p>
                </div>
                <p class="text-sm font-semibold">AED {{ number_format($item['price'] * $item['qty'], 0) }}</p>
            </div>
            @endforeach
            <div class="mt-4 flex justify-between text-base font-extrabold text-brand-dark border-t border-slate-100 pt-3">
                <span>Total</span>
                <span>AED {{ number_format($order->total, 0) }}</span>
            </div>
        </div>
        @endif

        {{-- Delivery info --}}
        <div class="mt-6 rounded-2xl bg-slate-50 p-5 text-sm text-slate-600">
            📦 Your order will be delivered within <strong class="text-brand-dark">2–3 business days</strong>.
            A confirmation email has been sent to your inbox.
        </div>

        {{-- CTAs --}}
        <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:justify-center">
            <a href="{{ route('home') }}"
               class="rounded-full bg-brand-teal px-8 py-3.5 text-sm font-bold text-white hover:bg-teal-600 transition-colors">
                Continue Shopping
            </a>
            <a href="/account/orders"
               class="rounded-full border border-slate-200 px-8 py-3.5 text-sm font-bold text-brand-dark hover:border-brand-teal hover:text-brand-teal transition-colors">
                Track My Order
            </a>
        </div>
    </div>

</x-layouts.app>
