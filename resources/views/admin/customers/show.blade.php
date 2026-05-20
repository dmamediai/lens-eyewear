<x-layouts.admin title="{{ $customer->name }}" active="customers">

    <div class="mb-6 flex items-center gap-3">
        <a href="{{ route('admin.customers.index') }}" class="text-sm text-slate-500 hover:text-brand-teal transition-colors">← Customers</a>
        <span class="text-slate-300">/</span>
        <h2 class="text-xl font-extrabold text-brand-dark">{{ $customer->name }}</h2>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">

        {{-- Profile card --}}
        <div class="flex flex-col gap-6">
            <div class="rounded-2xl bg-white p-6 ring-1 ring-slate-100 shadow-sm text-center">
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-brand-teal/10 text-2xl font-extrabold text-brand-teal mb-3">
                    {{ substr($customer->name, 0, 1) }}
                </div>
                <h3 class="text-base font-bold text-brand-dark">{{ $customer->name }}</h3>
                <p class="text-sm text-slate-400">{{ $customer->email }}</p>
                <p class="text-xs text-slate-400 mt-1">Member since {{ $customer->created_at->format('M Y') }}</p>

                <div class="mt-5 grid grid-cols-2 gap-3 text-center border-t border-slate-100 pt-5">
                    <div>
                        <p class="text-xl font-extrabold text-brand-dark">{{ $customer->order_count }}</p>
                        <p class="text-xs text-slate-400">Orders</p>
                    </div>
                    <div>
                        <p class="text-xl font-extrabold text-brand-dark">AED {{ number_format($customer->total_spent, 0) }}</p>
                        <p class="text-xs text-slate-400">Spent</p>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl bg-white p-6 ring-1 ring-slate-100 shadow-sm">
                <h3 class="mb-3 text-sm font-bold text-brand-dark">Contact Info</h3>
                <div class="space-y-2 text-sm text-slate-600">
                    <p><span class="font-medium text-brand-dark">Email:</span> {{ $customer->email }}</p>
                    <p><span class="font-medium text-brand-dark">Phone:</span> {{ $customer->phone ?? '—' }}</p>
                    <p><span class="font-medium text-brand-dark">Emirate:</span> {{ $customer->emirate ?? '—' }}</p>
                    <p><span class="font-medium text-brand-dark">Address:</span> {{ $customer->address ?? '—' }}</p>
                </div>
            </div>
        </div>

        {{-- Order history --}}
        <div class="col-span-2">
            <div class="rounded-2xl bg-white ring-1 ring-slate-100 shadow-sm overflow-hidden">
                <div class="border-b border-slate-100 px-6 py-4">
                    <h3 class="text-sm font-bold text-brand-dark">Order History</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-slate-100 bg-slate-50 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">
                                <th class="px-6 py-3">Order</th>
                                <th class="px-6 py-3">Items</th>
                                <th class="px-6 py-3">Total</th>
                                <th class="px-6 py-3">Status</th>
                                <th class="px-6 py-3">Date</th>
                                <th class="px-6 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($orders as $order)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 font-mono text-xs font-bold text-brand-dark">{{ $order->order_number }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ count($order->items) }}</td>
                                <td class="px-6 py-4 font-semibold text-brand-dark">AED {{ number_format($order->total, 0) }}</td>
                                <td class="px-6 py-4">
                                    <span class="rounded-full px-2.5 py-1 text-xs font-bold {{ $order->status_color }}">{{ ucfirst($order->status) }}</span>
                                </td>
                                <td class="px-6 py-4 text-xs text-slate-400">{{ $order->created_at->format('d M Y') }}</td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="text-xs font-semibold text-brand-teal hover:underline">View</a>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="6" class="px-6 py-10 text-center text-slate-400">No orders yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($orders->hasPages())
                <div class="border-t border-slate-100 px-6 py-4">{{ $orders->links() }}</div>
                @endif
            </div>
        </div>
    </div>

</x-layouts.admin>
