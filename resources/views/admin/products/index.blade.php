<x-layouts.admin title="Products" active="products">

    {{-- Header --}}
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-xl font-extrabold text-brand-dark">Products</h2>
            <p class="text-sm text-slate-500">{{ $products->total() }} total products</p>
        </div>
        <a href="{{ route('admin.products.create') }}"
           class="inline-flex items-center gap-2 rounded-full bg-brand-teal px-5 py-2.5 text-sm font-bold text-white hover:bg-teal-600 transition-colors">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" d="M12 4v16m8-8H4"/></svg>
            New Product
        </a>
    </div>

    {{-- Filters --}}
    <form method="GET" class="mb-4 flex flex-wrap gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name or brand…"
               class="flex-1 min-w-48 rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-brand-teal focus:outline-none focus:ring-2 focus:ring-brand-teal/20" />
        <select name="category" class="rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-brand-teal focus:outline-none">
            <option value="">All Categories</option>
            @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
        </select>
        <select name="status" class="rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-brand-teal focus:outline-none">
            <option value="">All Status</option>
            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
        <button type="submit" class="rounded-xl bg-brand-dark px-5 py-2.5 text-sm font-semibold text-white hover:bg-slate-800 transition-colors">Filter</button>
        <a href="{{ route('admin.products.index') }}" class="rounded-xl border border-slate-200 px-5 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition-colors">Clear</a>
    </form>

    {{-- Table --}}
    <div class="rounded-2xl bg-white ring-1 ring-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">
                        <th class="px-6 py-3">Product</th>
                        <th class="px-6 py-3">Category</th>
                        <th class="px-6 py-3">Price</th>
                        <th class="px-6 py-3">Stock</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Rating</th>
                        <th class="px-6 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($products as $product)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <img src="{{ $product->primary_image }}" alt=""
                                     class="h-10 w-10 rounded-lg object-cover bg-slate-100" />
                                <div>
                                    <p class="font-semibold text-brand-dark line-clamp-1">{{ $product->name }}</p>
                                    <p class="text-xs text-slate-400">{{ $product->brand }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-600">{{ $product->category->name }}</td>
                        <td class="px-6 py-4">
                            <p class="font-semibold text-brand-dark">AED {{ number_format($product->price, 0) }}</p>
                            @if($product->original_price)
                            <p class="text-xs text-slate-400 line-through">AED {{ number_format($product->original_price, 0) }}</p>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-semibold {{ $product->stock <= 5 ? 'text-red-600' : 'text-brand-dark' }}">
                                {{ $product->stock }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="rounded-full px-2.5 py-1 text-xs font-bold
                                         {{ $product->active ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-500' }}">
                                {{ $product->active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-1">
                                <span class="text-amber-400 text-xs">★</span>
                                <span class="text-sm font-medium text-brand-dark">{{ $product->rating }}</span>
                                <span class="text-xs text-slate-400">({{ number_format($product->review_count) }})</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.products.edit', $product) }}"
                                   class="rounded-lg px-3 py-1.5 text-xs font-semibold text-brand-teal ring-1 ring-brand-teal/30 hover:bg-brand-teal hover:text-white transition-colors">
                                    Edit
                                </a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                                      onsubmit="return confirm('Delete this product?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="rounded-lg px-3 py-1.5 text-xs font-semibold text-red-500 ring-1 ring-red-200 hover:bg-red-500 hover:text-white transition-colors">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-16 text-center text-slate-400">
                            No products found. <a href="{{ route('admin.products.create') }}" class="text-brand-teal underline">Add one</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($products->hasPages())
        <div class="border-t border-slate-100 px-6 py-4">
            {{ $products->links() }}
        </div>
        @endif
    </div>

</x-layouts.admin>
