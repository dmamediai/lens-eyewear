<x-layouts.admin title="Settings" active="settings">

    <div class="mb-6">
        <h2 class="text-xl font-extrabold text-brand-dark">Store Settings</h2>
        <p class="text-sm text-slate-500">Configure your store information and preferences</p>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="grid gap-6 lg:grid-cols-3">
            <div class="col-span-2 flex flex-col gap-6">

                {{-- Store Info --}}
                <div class="rounded-2xl bg-white p-6 ring-1 ring-slate-100 shadow-sm">
                    <h3 class="mb-4 text-sm font-bold text-brand-dark">Store Information</h3>
                    <div class="grid gap-4 md:grid-cols-2">
                        <div class="md:col-span-2">
                            <label class="mb-1.5 block text-xs font-semibold text-slate-600">Store Name</label>
                            <input type="text" name="store_name" value="{{ config('app.name', 'Lens') }}"
                                   class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-brand-teal focus:outline-none focus:ring-2 focus:ring-brand-teal/20" />
                        </div>
                        <div>
                            <label class="mb-1.5 block text-xs font-semibold text-slate-600">Contact Email</label>
                            <input type="email" name="contact_email" value="hello@lens.ae"
                                   class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-brand-teal focus:outline-none focus:ring-2 focus:ring-brand-teal/20" />
                        </div>
                        <div>
                            <label class="mb-1.5 block text-xs font-semibold text-slate-600">Contact Phone</label>
                            <input type="text" name="contact_phone" value="+971 4 000 0000"
                                   class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-brand-teal focus:outline-none focus:ring-2 focus:ring-brand-teal/20" />
                        </div>
                    </div>
                </div>

                {{-- Currency & Tax --}}
                <div class="rounded-2xl bg-white p-6 ring-1 ring-slate-100 shadow-sm">
                    <h3 class="mb-4 text-sm font-bold text-brand-dark">Currency & Tax</h3>
                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <label class="mb-1.5 block text-xs font-semibold text-slate-600">Currency</label>
                            <select name="currency" class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-brand-teal focus:outline-none">
                                <option value="AED" selected>AED — UAE Dirham</option>
                                <option value="SAR">SAR — Saudi Riyal</option>
                                <option value="USD">USD — US Dollar</option>
                            </select>
                        </div>
                        <div>
                            <label class="mb-1.5 block text-xs font-semibold text-slate-600">VAT Rate (%)</label>
                            <input type="number" name="vat_rate" value="5" min="0" max="100" step="0.1"
                                   class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-brand-teal focus:outline-none focus:ring-2 focus:ring-brand-teal/20" />
                        </div>
                    </div>
                </div>

                {{-- Shipping --}}
                <div class="rounded-2xl bg-white p-6 ring-1 ring-slate-100 shadow-sm">
                    <h3 class="mb-4 text-sm font-bold text-brand-dark">Shipping</h3>
                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <label class="mb-1.5 block text-xs font-semibold text-slate-600">Flat Rate (AED)</label>
                            <input type="number" name="shipping_flat" value="15" min="0" step="0.01"
                                   class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-brand-teal focus:outline-none focus:ring-2 focus:ring-brand-teal/20" />
                        </div>
                        <div>
                            <label class="mb-1.5 block text-xs font-semibold text-slate-600">Free Shipping Threshold (AED)</label>
                            <input type="number" name="shipping_free_threshold" value="150" min="0" step="1"
                                   class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-brand-teal focus:outline-none focus:ring-2 focus:ring-brand-teal/20" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-6">
                <div class="rounded-2xl bg-white p-6 ring-1 ring-slate-100 shadow-sm">
                    <h3 class="mb-4 text-sm font-bold text-brand-dark">Store Logo</h3>
                    <label class="flex cursor-pointer flex-col items-center gap-3 rounded-2xl border-2 border-dashed border-slate-200 p-6 text-center hover:border-brand-teal hover:bg-brand-teal/5 transition-colors">
                        <span class="text-3xl">🏪</span>
                        <p class="text-xs text-slate-500">Upload logo (PNG, SVG)</p>
                        <input type="file" name="logo" accept="image/*" class="sr-only" />
                    </label>
                </div>

                <div class="rounded-2xl bg-white p-6 ring-1 ring-slate-100 shadow-sm">
                    <h3 class="mb-4 text-sm font-bold text-brand-dark">Notifications</h3>
                    @foreach(['New order received', 'Low stock alert (≤5)', 'New customer registered'] as $notif)
                    <label class="flex items-center justify-between py-2.5 border-b border-slate-50 last:border-0 cursor-pointer">
                        <span class="text-sm text-brand-dark">{{ $notif }}</span>
                        <div class="relative">
                            <input type="checkbox" checked class="sr-only peer" />
                            <div class="h-5 w-9 rounded-full bg-slate-200 peer-checked:bg-brand-teal transition-colors"></div>
                            <div class="absolute left-0.5 top-0.5 h-4 w-4 rounded-full bg-white shadow transition-transform peer-checked:translate-x-4"></div>
                        </div>
                    </label>
                    @endforeach
                </div>

                <button type="submit"
                        class="w-full rounded-full bg-brand-teal py-3 text-sm font-bold text-white hover:bg-teal-600 transition-colors shadow-lg shadow-brand-teal/20">
                    Save Settings
                </button>
            </div>
        </div>
    </form>

</x-layouts.admin>
