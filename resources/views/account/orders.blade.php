<x-layouts.app title="My Orders — Lens">

    <div class="mx-auto max-w-4xl px-4 py-10 lg:px-8">
        <h1 class="mb-8 text-2xl font-extrabold text-brand-dark">My Orders</h1>

        @forelse($orders ?? [] as $order)
        <a href="/account/orders/{{ $order->id }}"
           class="mb-4 flex flex-col gap-4 rounded-2xl bg-white p-5 ring-1 ring-slate-100 shadow-sm hover:ring-brand-teal/30 hover:shadow-md transition-all sm:flex-row sm:items-center">
            <div class="flex-1">
                <div class="flex items-center gap-2 mb-1">
                    <span class="font-mono text-xs font-bold text-brand-dark">{{ $order->order_number }}</span>
                    <span class="rounded-full px-2.5 py-0.5 text-[11px] font-bold {{ $order->status_color }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
                <p class="text-xs text-slate-400">{{ $order->created_at->format('d M Y') }} &middot; {{ count($order->items) }} item(s)</p>
                <div class="mt-3 flex gap-2 overflow-x-auto">
                    @foreach(array_slice($order->items, 0, 4) as $item)
                    <img src="{{ $item['image'] ?? '/images/placeholder.jpg' }}" alt=""
                         class="h-12 w-12 flex-shrink-0 rounded-lg object-cover bg-slate-100" />
                    @endforeach
                    @if(count($order->items) > 4)
                    <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-lg bg-slate-100 text-xs font-bold text-slate-600">
                        +{{ count($order->items) - 4 }}
                    </div>
                    @endif
                </div>
            </div>
            <div class="text-right flex-shrink-0">
                <p class="text-lg font-extrabold text-brand-dark">AED {{ number_format($order->total, 0) }}</p>
                <p class="text-xs text-brand-teal font-semibold mt-1">View details →</p>
            </div>
        </a>
        @empty
        <div class="flex flex-col items-center gap-5 py-24 text-center">
            <span class="text-6xl">📦</span>
            <h2 class="text-xl font-bold text-brand-dark">No orders yet</h2>
            <p class="text-sm text-slate-500">Your order history will appear here once you make a purchase.</p>
            <a href="{{ route('home') }}" class="rounded-full bg-brand-teal px-8 py-3.5 text-sm font-bold text-white hover:bg-teal-600 transition-colors">
                Start Shopping
            </a>
        </div>
        @endforelse
    </div>

</x-layouts.app>
