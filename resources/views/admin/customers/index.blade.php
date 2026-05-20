<x-layouts.admin title="Customers" active="customers">

    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-xl font-extrabold text-brand-dark">Customers</h2>
            <p class="text-sm text-slate-500">{{ $customers->total() }} registered customers</p>
        </div>
    </div>

    <form method="GET" class="mb-4 flex gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name or email…"
               class="flex-1 rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-brand-teal focus:outline-none focus:ring-2 focus:ring-brand-teal/20" />
        <button type="submit" class="rounded-xl bg-brand-dark px-5 py-2.5 text-sm font-semibold text-white hover:bg-slate-800 transition-colors">Search</button>
        <a href="{{ route('admin.customers.index') }}" class="rounded-xl border border-slate-200 px-5 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition-colors">Clear</a>
    </form>

    <div class="rounded-2xl bg-white ring-1 ring-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">
                        <th class="px-6 py-3">Customer</th>
                        <th class="px-6 py-3">Phone</th>
                        <th class="px-6 py-3">Emirate</th>
                        <th class="px-6 py-3">Orders</th>
                        <th class="px-6 py-3">Total Spent</th>
                        <th class="px-6 py-3">Joined</th>
                        <th class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($customers as $customer)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-full bg-brand-teal/10 text-sm font-bold text-brand-teal">
                                    {{ substr($customer->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-brand-dark">{{ $customer->name }}</p>
                                    <p class="text-xs text-slate-400">{{ $customer->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-600">{{ $customer->phone ?? '—' }}</td>
                        <td class="px-6 py-4 text-slate-600">{{ $customer->emirate ?? '—' }}</td>
                        <td class="px-6 py-4 font-semibold text-brand-dark">{{ $customer->order_count }}</td>
                        <td class="px-6 py-4 font-semibold text-brand-dark">AED {{ number_format($customer->total_spent, 0) }}</td>
                        <td class="px-6 py-4 text-xs text-slate-400">{{ $customer->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.customers.show', $customer) }}"
                               class="text-xs font-semibold text-brand-teal hover:underline">View</a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="px-6 py-16 text-center text-slate-400">No customers found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($customers->hasPages())
        <div class="border-t border-slate-100 px-6 py-4">{{ $customers->links() }}</div>
        @endif
    </div>

</x-layouts.admin>
