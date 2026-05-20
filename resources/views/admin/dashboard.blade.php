<x-layouts.admin title="Dashboard" active="dashboard">

    {{-- KPI Cards --}}
    <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">
        @foreach([
            ['label'=>'Revenue (30d)',      'value'=>'AED '.number_format($revenue30d,0),  'change'=>'+12.4%','trend'=>'up',  'icon'=>'💰','color'=>'bg-brand-teal/10 text-brand-teal'],
            ['label'=>'Orders (30d)',       'value'=>$orders30d,                            'change'=>'+8.1%', 'trend'=>'up',  'icon'=>'📦','color'=>'bg-blue-50 text-blue-600'],
            ['label'=>'New Customers',      'value'=>$newCustomers,                         'change'=>'+5.3%', 'trend'=>'up',  'icon'=>'👤','color'=>'bg-purple-50 text-purple-600'],
            ['label'=>'Active Products',    'value'=>$activeProds,                          'change'=>'−2',    'trend'=>'down','icon'=>'👓','color'=>'bg-amber-50 text-amber-600'],
        ] as $kpi)
        <div class="rounded-2xl bg-white p-5 ring-1 ring-slate-100 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="flex h-10 w-10 items-center justify-center rounded-xl text-xl {{ $kpi['color'] }}">
                    {{ $kpi['icon'] }}
                </span>
                <span class="flex items-center gap-1 text-xs font-semibold {{ $kpi['trend'] === 'up' ? 'text-green-600' : 'text-red-500' }}">
                    {{ $kpi['trend'] === 'up' ? '↑' : '↓' }} {{ $kpi['change'] }}
                </span>
            </div>
            <p class="mt-4 text-2xl font-extrabold text-brand-dark">{{ $kpi['value'] }}</p>
            <p class="mt-1 text-xs text-slate-500">{{ $kpi['label'] }}</p>
        </div>
        @endforeach
    </div>

    {{-- Chart + Low Stock --}}
    <div class="mt-6 grid gap-6 lg:grid-cols-3">

        {{-- Revenue Chart --}}
        <div class="col-span-2 rounded-2xl bg-white p-6 ring-1 ring-slate-100 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-base font-bold text-brand-dark">Revenue — Last 7 Days</h2>
                <span class="rounded-full bg-brand-teal/10 px-3 py-1 text-xs font-semibold text-brand-teal">AED</span>
            </div>
            <canvas id="revenueChart" height="180"></canvas>
        </div>

        {{-- Low Stock Alerts --}}
        <div class="rounded-2xl bg-white p-6 ring-1 ring-slate-100 shadow-sm">
            <h2 class="mb-4 text-base font-bold text-brand-dark">Low Stock Alerts</h2>
            @forelse($lowStock as $p)
            <div class="flex items-center justify-between border-b border-slate-50 py-3 last:border-0">
                <div>
                    <p class="text-sm font-medium text-brand-dark line-clamp-1">{{ $p->name }}</p>
                    <p class="text-xs text-slate-400">{{ $p->brand }}</p>
                </div>
                <div class="text-right">
                    <span class="rounded-full bg-red-100 px-2.5 py-1 text-xs font-bold text-red-600">{{ $p->stock }} left</span>
                </div>
            </div>
            @empty
            <p class="text-sm text-slate-400">All products are well-stocked.</p>
            @endforelse
        </div>
    </div>

    {{-- Recent Orders --}}
    <div class="mt-6 rounded-2xl bg-white ring-1 ring-slate-100 shadow-sm">
        <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4">
            <h2 class="text-base font-bold text-brand-dark">Recent Orders</h2>
            <a href="{{ route('admin.orders.index') }}" class="text-sm font-semibold text-brand-teal hover:underline">View all</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">
                        <th class="px-6 py-3">Order</th>
                        <th class="px-6 py-3">Customer</th>
                        <th class="px-6 py-3">Items</th>
                        <th class="px-6 py-3">Total</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Date</th>
                        <th class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($recentOrders as $order)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 font-mono text-xs font-bold text-brand-dark">{{ $order->order_number }}</td>
                        <td class="px-6 py-4">
                            <p class="font-medium text-brand-dark">{{ $order->customer->name }}</p>
                            <p class="text-xs text-slate-400">{{ $order->customer->email }}</p>
                        </td>
                        <td class="px-6 py-4 text-slate-600">{{ count($order->items) }} item(s)</td>
                        <td class="px-6 py-4 font-semibold text-brand-dark">AED {{ number_format($order->total, 0) }}</td>
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
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('revenueChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($chartData->pluck('label')) !!},
                datasets: [{
                    label: 'Revenue (AED)',
                    data: {!! json_encode($chartData->pluck('revenue')) !!},
                    backgroundColor: 'rgba(10, 191, 184, 0.15)',
                    borderColor: '#0abfb8',
                    borderWidth: 2,
                    borderRadius: 8,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { display: false }, ticks: { font: { size: 12 } } },
                    y: { grid: { color: '#f1f5f9' }, ticks: { font: { size: 12 },
                         callback: v => 'AED ' + v.toLocaleString() } }
                }
            }
        });
    });
    </script>

</x-layouts.admin>
