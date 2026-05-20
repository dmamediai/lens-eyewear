<x-layouts.admin title="New Product" active="products">

    <div class="mb-6 flex items-center gap-3">
        <a href="{{ route('admin.products.index') }}" class="text-sm text-slate-500 hover:text-brand-teal transition-colors">← Products</a>
        <span class="text-slate-300">/</span>
        <h2 class="text-xl font-extrabold text-brand-dark">New Product</h2>
    </div>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="grid gap-6 lg:grid-cols-3">

            {{-- Left: Main fields --}}
            <div class="col-span-2 flex flex-col gap-5">

                <div class="rounded-2xl bg-white p-6 ring-1 ring-slate-100 shadow-sm">
                    <h3 class="mb-4 text-sm font-bold text-brand-dark">Product Details</h3>
                    <div class="grid gap-4 md:grid-cols-2">
                        <div class="md:col-span-2">
                            <label class="mb-1.5 block text-xs font-semibold text-slate-600">Product Name *</label>
                            <input type="text" name="name" value="{{ old('name') }}" required
                                   class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-brand-teal focus:outline-none focus:ring-2 focus:ring-brand-teal/20"
                                   placeholder="e.g. FreshLook ColorBlends Blue" />
                            @error('name')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="mb-1.5 block text-xs font-semibold text-slate-600">Brand *</label>
                            <input type="text" name="brand" value="{{ old('brand') }}" required
                                   class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-brand-teal focus:outline-none focus:ring-2 focus:ring-brand-teal/20"
                                   placeholder="e.g. Alcon" />
                        </div>
                        <div>
                            <label class="mb-1.5 block text-xs font-semibold text-slate-600">Category *</label>
                            <select name="category_id" required
                                    class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-brand-teal focus:outline-none focus:ring-2 focus:ring-brand-teal/20">
                                <option value="">Select category</option>
                                @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="mb-1.5 block text-xs font-semibold text-slate-600">Price (AED) *</label>
                            <input type="number" name="price" value="{{ old('price') }}" min="0" step="0.01" required
                                   class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-brand-teal focus:outline-none focus:ring-2 focus:ring-brand-teal/20"
                                   placeholder="0.00" />
                        </div>
                        <div>
                            <label class="mb-1.5 block text-xs font-semibold text-slate-600">Original Price (AED)</label>
                            <input type="number" name="original_price" value="{{ old('original_price') }}" min="0" step="0.01"
                                   class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-brand-teal focus:outline-none focus:ring-2 focus:ring-brand-teal/20"
                                   placeholder="Leave blank for no discount" />
                        </div>
                        <div>
                            <label class="mb-1.5 block text-xs font-semibold text-slate-600">Stock *</label>
                            <input type="number" name="stock" value="{{ old('stock', 0) }}" min="0" required
                                   class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-brand-teal focus:outline-none focus:ring-2 focus:ring-brand-teal/20" />
                        </div>
                        <div>
                            <label class="mb-1.5 block text-xs font-semibold text-slate-600">Badge</label>
                            <input type="text" name="badge" value="{{ old('badge') }}"
                                   class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-brand-teal focus:outline-none focus:ring-2 focus:ring-brand-teal/20"
                                   placeholder="e.g. Best Seller, New, Premium" />
                        </div>
                        <div class="md:col-span-2">
                            <label class="mb-1.5 block text-xs font-semibold text-slate-600">Description</label>
                            <textarea name="description" rows="4"
                                      class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-brand-teal focus:outline-none focus:ring-2 focus:ring-brand-teal/20 resize-none"
                                      placeholder="Product description…">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Image Upload --}}
                <div class="rounded-2xl bg-white p-6 ring-1 ring-slate-100 shadow-sm">
                    <h3 class="mb-4 text-sm font-bold text-brand-dark">Product Images</h3>
                    <label class="flex cursor-pointer flex-col items-center gap-3 rounded-2xl border-2 border-dashed border-slate-200 p-8 text-center hover:border-brand-teal hover:bg-brand-teal/5 transition-colors">
                        <span class="text-3xl">📸</span>
                        <div>
                            <p class="text-sm font-semibold text-brand-dark">Drop images here or click to upload</p>
                            <p class="text-xs text-slate-400 mt-1">PNG, JPG up to 5MB each</p>
                        </div>
                        <input type="file" name="images[]" multiple accept="image/*" class="sr-only" />
                    </label>
                </div>
            </div>

            {{-- Right: Toggles & publish --}}
            <div class="flex flex-col gap-5">
                <div class="rounded-2xl bg-white p-6 ring-1 ring-slate-100 shadow-sm">
                    <h3 class="mb-4 text-sm font-bold text-brand-dark">Visibility</h3>
                    <div class="flex flex-col gap-4">
                        @foreach([
                            ['name'=>'active',   'label'=>'Active',   'sub'=>'Visible in the storefront'],
                            ['name'=>'featured', 'label'=>'Featured', 'sub'=>'Show in Top Picks & homepage'],
                            ['name'=>'is_bogo',  'label'=>'B1G1 Free','sub'=>'Show Buy 1 Get 1 badge'],
                        ] as $toggle)
                        <label class="flex cursor-pointer items-center justify-between gap-3">
                            <div>
                                <p class="text-sm font-semibold text-brand-dark">{{ $toggle['label'] }}</p>
                                <p class="text-xs text-slate-400">{{ $toggle['sub'] }}</p>
                            </div>
                            <div class="relative">
                                <input type="checkbox" name="{{ $toggle['name'] }}" value="1" class="sr-only peer"
                                       {{ old($toggle['name'], $toggle['name'] === 'active' ? '1' : '0') ? 'checked' : '' }} />
                                <div class="h-6 w-11 rounded-full bg-slate-200 peer-checked:bg-brand-teal transition-colors"></div>
                                <div class="absolute left-0.5 top-0.5 h-5 w-5 rounded-full bg-white shadow transition-transform peer-checked:translate-x-5"></div>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                <div class="rounded-2xl bg-white p-6 ring-1 ring-slate-100 shadow-sm">
                    <button type="submit"
                            class="w-full rounded-full bg-brand-teal py-3 text-sm font-bold text-white hover:bg-teal-600 transition-colors">
                        Create Product
                    </button>
                    <a href="{{ route('admin.products.index') }}"
                       class="mt-3 flex w-full items-center justify-center rounded-full border border-slate-200 py-3 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition-colors">
                        Cancel
                    </a>
                </div>
            </div>
        </div>
    </form>

</x-layouts.admin>
