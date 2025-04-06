<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Models\Ad;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('ad')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('products.index', compact('products'));
    }

    public function create()
    {
        $ads = Ad::where('user_id', auth()->id())->get();

        return view('products.create', compact('ads'));
    }

    public function store(StoreProductRequest $request)
    {
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create(
            $request->safe()->merge([
                'user_id' => auth()->id(),
                'image' => $imagePath,
            ])->all()
        );

        return redirect()->route('products.index')->with('success', 'Product created.');
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $ads = Ad::where('user_id', auth()->id())->get();

        return view('products.edit', compact('product', 'ads'));
    }

    public function update(StoreProductRequest $request, Product $product)
    {
        $product->update($request->validated());

        return redirect()->route('products.index')->with('success', 'Product updated.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted.');
    }
}
