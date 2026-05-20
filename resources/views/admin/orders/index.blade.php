<x-layouts.admin title="Orders" active="orders">

    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-xl font-extrabold text-brand-dark">Orders</h2>
            <p class="text-sm text-slate-500">{{ $orders->total() }} total orders</p>
        </div>
    </div>

    {{-- Status tabs --}}
    <div class="mb-4 flex gap-2 overflow-x-auto pb-1">
        @foreach(['all' => 'All', 'pending' => 'Pending', 'processing' => 'Processing', 'shipped' => 'Shipped', 'delivered' => 'Delivered', 'cancelled' => 'Cancelled'] as $key => $label)
        <a href="{{ route('admin.orders.index', array_merge(request()->query(), ['status' => $key])) }}"
           class="flex-none rounded-full px-4 py-2 text-sm font-medium transition-colors
                  {{ request('status', 'all') === $key
                     ? 'bg-brand-teal text-white'
                     : 'bg-white text-slate-600 ring-1 ring-slate-200 hover:bg-slate-50' }}">
            {{ $label }}
            <span class="ml-1 text-xs opacity-70">{{ $counts[$key] ?? 0 }}</span>
        </a>
        @endforeach
    </div>

    {{-- Search --}}
    <form method="GET" class="mb-4 flex gap-3">
        <input type="hidden" name="status" value="{{ request('status') }}" />
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search order # or customer…"
               class="flex-1 rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-brand-teal focus:outline-none focus:ring-2 focus:ring-brand-teal/20" />
        <button type="submit" class="rounded-xl bg-brand-dark px-5 py-2.5 text-sm font-semibold text-white hover:bg-slate-800 transition-colors">Search</button>
    </form>

    {{-- Table --}}
    <div class="rounded-2xl bg-white ring-1 ring-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">
                        <th class="px-6 py-3">Order</th>
                        <th class="px-6 py-3">Customer</th>
                        <th class="px-6 py-3">Items</th>
                        <th class="px-6 py-3">Total</th>
                        <th class="px-6 py-3">Payment</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Date</th>
                        <th class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($orders as $order)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 font-mono text-xs font-bold text-brand-dark">{{ $order->order_number }}</td>
                        <td class="px-6 py-4">
                            <p class="font-medium text-brand-dark">{{ $order->customer->name }}</p>
                            <p class="text-xs text-slate-400">{{ $order->customer->email }}</p>
                        </td>
                        <td class="px-6 py-4 text-slate-600">{{ count($order->items) }}</td>
                        <td class="px-6 py-4 font-semibold text-brand-dark">AED {{ number_format($order->total, 0) }}</td>
                        <td class="px-6 py-4">
                            <span class="text-xs capitalize text-slate-600">{{ str_replace('_', ' ', $order->payment_method) }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="rounded-full px-2.5 py-1 text-xs font-bold {{ $order->status_color }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-400">{{ $order->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.orders.show', $order) }}"
                               class="text-xs font-semibold text-brand-teal hover:underline">View</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-16 text-center text-slate-400">No orders found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($orders->hasPages())
        <div class="border-t border-slate-100 px-6 py-4">{{ $orders->links() }}</div>
        @endif
    </div>

</x-layouts.admin>
