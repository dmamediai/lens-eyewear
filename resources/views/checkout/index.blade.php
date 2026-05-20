<x-layouts.app title="Checkout — Lens">

    <div class="mx-auto max-w-6xl px-4 py-10 lg:px-8">

        {{-- Step indicator --}}
        <div class="mb-10 flex items-center justify-center">
            @foreach([['num'=>1,'label'=>'Cart'],['num'=>2,'label'=>'Details'],['num'=>3,'label'=>'Payment'],['num'=>4,'label'=>'Confirm']] as $i => $step)
            <div class="flex items-center">
                <div class="flex flex-col items-center">
                    <div class="flex h-8 w-8 items-center justify-center rounded-full text-xs font-bold
                                {{ $step['num'] === 2 ? 'bg-brand-teal text-white' : ($step['num'] < 2 ? 'bg-brand-teal/20 text-brand-teal' : 'bg-slate-100 text-slate-400') }}">
                        {{ $step['num'] < 2 ? '✓' : $step['num'] }}
                    </div>
                    <span class="mt-1 text-[11px] font-medium {{ $step['num'] <= 2 ? 'text-brand-teal' : 'text-slate-400' }}">{{ $step['label'] }}</span>
                </div>
                @if($i < 3)
                <div class="mx-3 h-0.5 w-12 {{ $step['num'] < 2 ? 'bg-brand-teal' : 'bg-slate-200' }} -mt-5"></div>
                @endif
            </div>
            @endforeach
        </div>

        <div class="grid gap-8 lg:grid-cols-3">

            {{-- Checkout Form --}}
            <form action="/checkout/process" method="POST" class="col-span-2 flex flex-col gap-6">
                @csrf

                {{-- Delivery Details --}}
                <div class="rounded-2xl bg-white p-6 ring-1 ring-slate-100 shadow-sm">
                    <h2 class="mb-5 text-base font-bold text-brand-dark">Delivery Details</h2>
                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <label class="mb-1.5 block text-xs font-semibold text-slate-600">Full Name *</label>
                            <input type="text" name="name" required
                                   class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-brand-teal focus:outline-none focus:ring-2 focus:ring-brand-teal/20" />
                        </div>
                        <div>
                            <label class="mb-1.5 block text-xs font-semibold text-slate-600">Email *</label>
                            <input type="email" name="email" required
                                   class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-brand-teal focus:outline-none focus:ring-2 focus:ring-brand-teal/20" />
                        </div>
                        <div>
                            <label class="mb-1.5 block text-xs font-semibold text-slate-600">Phone *</label>
                            <input type="tel" name="phone" placeholder="+971 5X XXX XXXX" required
                                   class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-brand-teal focus:outline-none focus:ring-2 focus:ring-brand-teal/20" />
                        </div>
                        <div>
                            <label class="mb-1.5 block text-xs font-semibold text-slate-600">Emirate *</label>
                            <select name="emirate" required
                                    class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-brand-teal focus:outline-none">
                                @foreach(['Dubai','Abu Dhabi','Sharjah','Ajman','Ras Al Khaimah','Fujairah','Umm Al Quwain'] as $em)
                                <option>{{ $em }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label class="mb-1.5 block text-xs font-semibold text-slate-600">Address *</label>
                            <input type="text" name="address" placeholder="Building, street, area" required
                                   class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-brand-teal focus:outline-none focus:ring-2 focus:ring-brand-teal/20" />
                        </div>
                        <div class="md:col-span-2">
                            <label class="mb-1.5 block text-xs font-semibold text-slate-600">Delivery Notes</label>
                            <textarea name="notes" rows="2" placeholder="Any special instructions for delivery…"
                                      class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-brand-teal focus:outline-none resize-none"></textarea>
                        </div>
                    </div>
                </div>

                {{-- Payment Method --}}
                <div class="rounded-2xl bg-white p-6 ring-1 ring-slate-100 shadow-sm">
                    <h2 class="mb-5 text-base font-bold text-brand-dark">Payment Method</h2>
                    <div class="grid gap-3 md:grid-cols-2">
                        @foreach([
                            ['value'=>'card',       'label'=>'Credit / Debit Card', 'icon'=>'💳', 'sub'=>'Visa, Mastercard, Amex'],
                            ['value'=>'apple_pay',  'label'=>'Apple Pay',           'icon'=>'🍎', 'sub'=>'Fast & secure'],
                            ['value'=>'cash',       'label'=>'Cash on Delivery',    'icon'=>'💵', 'sub'=>'Pay when you receive'],
                            ['value'=>'tabby',      'label'=>'Tabby',               'icon'=>'⚡', 'sub'=>'Pay in 4 installments'],
                        ] as $pm)
                        <label class="flex cursor-pointer items-center gap-3 rounded-2xl border border-slate-200 p-4 hover:border-brand-teal transition-colors has-[:checked]:border-brand-teal has-[:checked]:bg-brand-teal/5">
                            <input type="radio" name="payment_method" value="{{ $pm['value'] }}"
                                   class="text-brand-teal focus:ring-brand-teal" {{ $loop->first ? 'checked' : '' }} />
                            <span class="text-2xl">{{ $pm['icon'] }}</span>
                            <div>
                                <p class="text-sm font-semibold text-brand-dark">{{ $pm['label'] }}</p>
                                <p class="text-xs text-slate-400">{{ $pm['sub'] }}</p>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                <button type="submit"
                        class="w-full rounded-full bg-brand-teal py-4 text-sm font-bold text-white shadow-lg shadow-brand-teal/30 hover:bg-teal-600 hover:-translate-y-0.5 transition-all">
                    Place Order
                </button>
            </form>

            {{-- Order Summary (sticky) --}}
            <div class="lg:sticky lg:top-24 self-start">
                <div class="rounded-2xl bg-white p-6 ring-1 ring-slate-100 shadow-sm">
                    <h2 class="mb-4 text-base font-bold text-brand-dark">Order Summary</h2>
                    @foreach(session('cart', []) as $item)
                    <div class="flex items-center gap-3 py-2 border-b border-slate-50 last:border-0">
                        <img src="{{ $item['image'] ?? '/images/placeholder.jpg' }}" alt=""
                             class="h-12 w-12 rounded-lg object-cover bg-slate-100 flex-shrink-0" />
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-medium text-brand-dark line-clamp-1">{{ $item['name'] }}</p>
                            <p class="text-xs text-slate-400">Qty: {{ $item['qty'] }}</p>
                        </div>
                        <p class="text-sm font-semibold text-brand-dark">AED {{ number_format($item['price'] * $item['qty'], 0) }}</p>
                    </div>
                    @endforeach
                    <div class="mt-4 border-t border-slate-100 pt-4 space-y-2 text-sm">
                        <div class="flex justify-between text-slate-600"><span>Subtotal</span><span>AED {{ number_format(session('cart_subtotal', 0), 0) }}</span></div>
                        <div class="flex justify-between text-slate-600"><span>Shipping</span><span>Free</span></div>
                        <div class="flex justify-between text-base font-extrabold text-brand-dark pt-2 border-t border-slate-100">
                            <span>Total</span><span>AED {{ number_format(session('cart_subtotal', 0), 0) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-layouts.app>
