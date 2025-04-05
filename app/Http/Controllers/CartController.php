<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        foreach ($cart as $key => $item) {
            if (! isset($item['product']->ad)) {
                $product = Product::with('ad')->find($item['product']->id);
                if ($product && $product->ad) {
                    $cart[$key]['product'] = $product;
                } else {
                    unset($cart[$key]);
                }
            }
        }

        session()->put('cart', $cart);

        return view('cart.index', compact('cart'));
    }

    public function add(Request $request, Product $product)
    {
        $product->load('ad');

        $cart = session()->get('cart', []);

        $cart[$product->id] = [
            'product' => $product,
            'quantity' => ($cart[$product->id]['quantity'] ?? 0) + 1,
        ];

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Added to cart');
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);

            return redirect()->back()->with('success', 'Quantity updated');
        }

        return redirect()->back()->with('error', 'Product not found in cart');
    }

    public function remove(Product $product)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);
            session()->put('cart', $cart);

            return redirect()->back()->with('success', 'Removed from cart');
        }

        return redirect()->back()->with('error', 'Product not found in cart');
    }

    public function checkout()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->back()->with('error', 'Your cart is empty');
        }

        $purchase = Purchase::create([
            'user_id' => Auth::id(),
            'purchased_at' => now(),
        ]);

        foreach ($cart as $item) {
            $purchase->products()->attach($item['product']->id, [
                'quantity' => $item['quantity'],
            ]);
        }

        session()->forget('cart');

        return redirect()->route('home')->with('success', 'Purchase completed');
    }
}
