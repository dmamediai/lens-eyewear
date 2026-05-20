<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with('category')
            ->when($request->search, fn($q) => $q->where('name', 'like', "%{$request->search}%")
                                                   ->orWhere('brand', 'like', "%{$request->search}%"))
            ->when($request->category, fn($q) => $q->where('category_id', $request->category))
            ->when($request->status === 'active',   fn($q) => $q->where('active', true))
            ->when($request->status === 'inactive', fn($q) => $q->where('active', false))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $categories = Category::all();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'           => 'required|string|max:255',
            'brand'          => 'required|string|max:100',
            'category_id'    => 'required|exists:categories,id',
            'price'          => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'stock'          => 'required|integer|min:0',
            'badge'          => 'nullable|string|max:50',
            'description'    => 'nullable|string',
            'is_bogo'        => 'boolean',
            'featured'       => 'boolean',
            'active'         => 'boolean',
        ]);

        $data['slug']    = Str::slug($data['name']) . '-' . Str::random(4);
        $data['images']  = ['/images/placeholder.jpg'];
        $data['colors']  = [];
        $data['specs']   = [];
        $data['is_bogo'] = $request->boolean('is_bogo');
        $data['featured']= $request->boolean('featured');
        $data['active']  = $request->boolean('active', true);

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Product created.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name'           => 'required|string|max:255',
            'brand'          => 'required|string|max:100',
            'category_id'    => 'required|exists:categories,id',
            'price'          => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'stock'          => 'required|integer|min:0',
            'badge'          => 'nullable|string|max:50',
            'description'    => 'nullable|string',
            'is_bogo'        => 'boolean',
            'featured'       => 'boolean',
            'active'         => 'boolean',
        ]);

        $data['is_bogo'] = $request->boolean('is_bogo');
        $data['featured']= $request->boolean('featured');
        $data['active']  = $request->boolean('active');

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Product updated.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return back()->with('success', 'Product deleted.');
    }
}
