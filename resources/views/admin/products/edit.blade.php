<x-layouts.admin title="Edit Product" active="products">

    <div class="mb-6 flex items-center gap-3">
        <a href="{{ route('admin.products.index') }}" class="text-sm text-slate-500 hover:text-brand-teal transition-colors">← Products</a>
        <span class="text-slate-300">/</span>
        <h2 class="text-xl font-extrabold text-brand-dark line-clamp-1">{{ $product->name }}</h2>
    </div>

    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="grid gap-6 lg:grid-cols-3">

            {{-- Left --}}
            <div class="col-span-2 flex flex-col gap-5">
                <div class="rounded-2xl bg-white p-6 ring-1 ring-slate-100 shadow-sm">
                    <h3 class="mb-4 text-sm font-bold text-brand-dark">Product Details</h3>
                    <div class="grid gap-4 md:grid-cols-2">
                        <div class="md:col-span-2">
                            <label class="mb-1.5 block text-xs font-semibold text-slate-600">Product Name *</label>
                            <input type="text" name="name" value="{{ old('name', $product->name) }}" required
                                   class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-brand-teal focus:outline-none focus:ring-2 focus:ring-brand-teal/20" />
                        </div>
                        <div>
                            <label class="mb-1.5 block text-xs font-semibold text-slate-600">Brand *</label>
                            <input type="text" name="brand" value="{{ old('brand', $product->brand) }}" required
                                   class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-brand-teal focus:outline-none focus:ring-2 focus:ring-brand-teal/20" />
                        </div>
                        <div>
                            <label class="mb-1.5 block text-xs font-semibold text-slate-600">Category *</label>
                            <select name="category_id" required
                                    class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-brand-teal focus:outline-none">
                                @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="mb-1.5 block text-xs font-semibold text-slate-600">Price (AED) *</label>
                            <input type="number" name="price" value="{{ old('price', $product->price) }}" min="0" step="0.01" required
                                   class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-brand-teal focus:outline-none focus:ring-2 focus:ring-brand-teal/20" />
                        </div>
                        <div>
                            <label class="mb-1.5 block text-xs font-semibold text-slate-600">Original Price (AED)</label>
                            <input type="number" name="original_price" value="{{ old('original_price', $product->original_price) }}" min="0" step="0.01"
                                   class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-brand-teal focus:outline-none focus:ring-2 focus:ring-brand-teal/20" />
                        </div>
                        <div>
                            <label class="mb-1.5 block text-xs font-semibold text-slate-600">Stock *</label>
                            <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" min="0" required
                                   class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-brand-teal focus:outline-none focus:ring-2 focus:ring-brand-teal/20" />
                        </div>
                        <div>
                            <label class="mb-1.5 block text-xs font-semibold text-slate-600">Badge</label>
                            <input type="text" name="badge" value="{{ old('badge', $product->badge) }}"
                                   class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-brand-teal focus:outline-none focus:ring-2 focus:ring-brand-teal/20"
                                   placeholder="Best Seller, New, Premium…" />
                        </div>
                        <div class="md:col-span-2">
                            <label class="mb-1.5 block text-xs font-semibold text-slate-600">Description</label>
                            <textarea name="description" rows="4"
                                      class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-brand-teal focus:outline-none resize-none">{{ old('description', $product->description) }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Current images --}}
                @if(!empty($product->images))
                <div class="rounded-2xl bg-white p-6 ring-1 ring-slate-100 shadow-sm">
                    <h3 class="mb-4 text-sm font-bold text-brand-dark">Current Images</h3>
                    <div class="flex flex-wrap gap-3">
                        @foreach($product->images as $img)
                        <img src="{{ $img }}" alt="" class="h-20 w-20 rounded-xl object-cover bg-slate-100 ring-1 ring-slate-200" />
                        @endforeach
                    </div>
                    <label class="mt-4 flex cursor-pointer items-center gap-2 text-sm font-semibold text-brand-teal hover:underline">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                        Replace images
                        <input type="file" name="images[]" multiple accept="image/*" class="sr-only" />
                    </label>
                </div>
                @endif
            </div>

            {{-- Right --}}
            <div class="flex flex-col gap-5">
                <div class="rounded-2xl bg-white p-6 ring-1 ring-slate-100 shadow-sm">
                    <h3 class="mb-4 text-sm font-bold text-brand-dark">Visibility</h3>
                    @foreach([
                        ['name'=>'active',   'label'=>'Active',    'sub'=>'Visible in storefront'],
                        ['name'=>'featured', 'label'=>'Featured',  'sub'=>'Shown in Top Picks'],
                        ['name'=>'is_bogo',  'label'=>'B1G1 Free', 'sub'=>'Show Buy 1 Get 1 badge'],
                    ] as $toggle)
                    <label class="flex cursor-pointer items-center justify-between gap-3 py-3 border-b border-slate-50 last:border-0">
                        <div>
                            <p class="text-sm font-semibold text-brand-dark">{{ $toggle['label'] }}</p>
                            <p class="text-xs text-slate-400">{{ $toggle['sub'] }}</p>
                        </div>
                        <div class="relative flex-shrink-0">
                            <input type="checkbox" name="{{ $toggle['name'] }}" value="1" class="sr-only peer"
                                   {{ old($toggle['name'], $product->{$toggle['name']}) ? 'checked' : '' }} />
                            <div class="h-6 w-11 rounded-full bg-slate-200 peer-checked:bg-brand-teal transition-colors"></div>
                            <div class="absolute left-0.5 top-0.5 h-5 w-5 rounded-full bg-white shadow transition-transform peer-checked:translate-x-5"></div>
                        </div>
                    </label>
                    @endforeach
                </div>

                <div class="rounded-2xl bg-white p-6 ring-1 ring-slate-100 shadow-sm">
                    <div class="text-xs text-slate-400 mb-4 space-y-1">
                        <p><span class="font-medium text-slate-600">Rating:</span> {{ $product->rating }} ★ ({{ number_format($product->review_count) }} reviews)</p>
                        <p><span class="font-medium text-slate-600">Created:</span> {{ $product->created_at?->format('d M Y') }}</p>
                    </div>
                    <button type="submit"
                            class="w-full rounded-full bg-brand-teal py-3 text-sm font-bold text-white hover:bg-teal-600 transition-colors">
                        Save Changes
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
