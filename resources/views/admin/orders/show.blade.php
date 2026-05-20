<x-layouts.admin title="Order {{ $order->order_number }}" active="orders">

    <div class="mb-6 flex items-center gap-3">
        <a href="{{ route('admin.orders.index') }}" class="text-sm text-slate-500 hover:text-brand-teal transition-colors">← Orders</a>
        <span class="text-slate-300">/</span>
        <h2 class="text-xl font-extrabold text-brand-dark font-mono">{{ $order->order_number }}</h2>
        <span class="rounded-full px-3 py-1 text-xs font-bold {{ $order->status_color }}">{{ ucfirst($order->status) }}</span>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">

        {{-- Left: Items + Timeline --}}
        <div class="col-span-2 flex flex-col gap-6">

            {{-- Order Items --}}
            <div class="rounded-2xl bg-white p-6 ring-1 ring-slate-100 shadow-sm">
                <h3 class="mb-4 text-sm font-bold text-brand-dark">Order Items</h3>
                <div class="flex flex-col divide-y divide-slate-50">
                    @foreach($order->items as $item)
                    <div class="flex items-center gap-4 py-3 first:pt-0 last:pb-0">
                        <img src="{{ $item['image'] ?? '/images/placeholder.jpg' }}" alt=""
                             class="h-14 w-14 rounded-xl object-cover bg-slate-100 flex-shrink-0" />
                        <div class="flex-1">
                            <p class="font-semibold text-brand-dark">{{ $item['name'] }}</p>
                            <p class="text-xs text-slate-400">Qty: {{ $item['qty'] }}</p>
                        </div>
                        <p class="font-semibold text-brand-dark">AED {{ number_format($item['price'] * $item['qty'], 0) }}</p>
                    </div>
                    @endforeach
                </div>
                <div class="mt-4 border-t border-slate-100 pt-4 space-y-2">
                    <div class="flex justify-between text-sm text-slate-600"><span>Subtotal</span><span>AED {{ number_format($order->subtotal, 0) }}</span></div>
                    @if($order->discount > 0)
                    <div class="flex justify-between text-sm text-green-600"><span>Discount</span><span>−AED {{ number_format($order->discount, 0) }}</span></div>
                    @endif
                    <div class="flex justify-between text-sm text-slate-600"><span>Shipping</span><span>{{ $order->shipping > 0 ? 'AED '.number_format($order->shipping, 0) : 'Free' }}</span></div>
                    <div class="flex justify-between text-base font-extrabold text-brand-dark border-t border-slate-100 pt-2 mt-2">
                        <span>Total</span><span>AED {{ number_format($order->total, 0) }}</span>
                    </div>
                </div>
            </div>

            {{-- Status Timeline --}}
            <div class="rounded-2xl bg-white p-6 ring-1 ring-slate-100 shadow-sm">
                <h3 class="mb-5 text-sm font-bold text-brand-dark">Order Timeline</h3>
                <div class="flex items-center">
                    @foreach(['pending','processing','shipped','delivered'] as $i => $step)
                    @php $reached = array_search($order->status, ['pending','processing','shipped','delivered','cancelled']) >= $i; @endphp
                    <div class="flex flex-col items-center flex-1">
                        <div class="flex h-8 w-8 items-center justify-center rounded-full text-xs font-bold
                                    {{ $reached ? 'bg-brand-teal text-white' : 'bg-slate-100 text-slate-400' }}">
                            {{ $i + 1 }}
                        </div>
                        <p class="mt-1.5 text-[10px] font-medium capitalize {{ $reached ? 'text-brand-teal' : 'text-slate-400' }}">{{ $step }}</p>
                    </div>
                    @if($i < 3)
                    <div class="flex-1 h-0.5 {{ $reached ? 'bg-brand-teal' : 'bg-slate-100' }} -mt-5"></div>
                    @endif
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Right: Customer + Update Status --}}
        <div class="flex flex-col gap-6">

            {{-- Customer info --}}
            <div class="rounded-2xl bg-white p-6 ring-1 ring-slate-100 shadow-sm">
                <h3 class="mb-4 text-sm font-bold text-brand-dark">Customer</h3>
                <div class="flex items-center gap-3 mb-4">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-brand-teal/10 text-brand-teal font-bold">
                        {{ substr($order->customer->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="font-semibold text-brand-dark">{{ $order->customer->name }}</p>
                        <p class="text-xs text-slate-400">{{ $order->customer->email }}</p>
                    </div>
                </div>
                <div class="space-y-2 text-sm text-slate-600">
                    <p><span class="font-medium">Phone:</span> {{ $order->customer->phone ?? '—' }}</p>
                    <p><span class="font-medium">Orders:</span> {{ $order->customer->order_count }}</p>
                    <p><span class="font-medium">Spent:</span> AED {{ number_format($order->customer->total_spent, 0) }}</p>
                </div>
                <a href="{{ route('admin.customers.show', $order->customer) }}"
                   class="mt-4 block text-center text-xs font-semibold text-brand-teal hover:underline">
                    View customer profile →
                </a>
            </div>

            {{-- Shipping address --}}
            <div class="rounded-2xl bg-white p-6 ring-1 ring-slate-100 shadow-sm">
                <h3 class="mb-3 text-sm font-bold text-brand-dark">Shipping Address</h3>
                <div class="text-sm text-slate-600 space-y-1">
                    <p class="font-semibold text-brand-dark">{{ $order->shipping_address['name'] ?? '' }}</p>
                    <p>{{ $order->shipping_address['phone'] ?? '' }}</p>
                    <p>{{ $order->shipping_address['address'] ?? '' }}</p>
                    <p>{{ $order->shipping_address['emirate'] ?? '' }}, UAE</p>
                </div>
            </div>

            {{-- Update status --}}
            <div class="rounded-2xl bg-white p-6 ring-1 ring-slate-100 shadow-sm">
                <h3 class="mb-4 text-sm font-bold text-brand-dark">Update Status</h3>
                <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                    @csrf @method('PUT')
                    <select name="status"
                            class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm mb-3 focus:border-brand-teal focus:outline-none">
                        @foreach(\App\Models\Order::$statuses as $s)
                        <option value="{{ $s }}" {{ $order->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                    <button type="submit"
                            class="w-full rounded-full bg-brand-teal py-2.5 text-sm font-bold text-white hover:bg-teal-600 transition-colors">
                        Update Order
                    </button>
                </form>
            </div>
        </div>
    </div>

</x-layouts.admin>
