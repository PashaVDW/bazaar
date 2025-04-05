<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Show the contents of the cart.
     */
    public function index()
    {
        $cart = session()->get('cart', []);

        return view('cart.index', compact('cart'));
    }

    /**
     * Add an ad to the cart.
     */
    public function add(Request $request, Ad $ad)
    {
        $cart = session()->get('cart', []);

        $cart[$ad->id] = [
            'ad' => $ad,
            'quantity' => ($cart[$ad->id]['quantity'] ?? 0) + 1,
        ];

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Added to cart');
    }

    /**
     * Update the quantity of an ad in the cart.
     */
    public function update(Request $request, Ad $ad)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$ad->id])) {
            $cart[$ad->id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);

            return redirect()->back()->with('success', 'Quantity updated');
        }

        return redirect()->back()->with('error', 'Ad not found in cart');
    }

    /**
     * Remove an ad from the cart.
     */
    public function remove(Ad $ad)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$ad->id])) {
            unset($cart[$ad->id]);
            session()->put('cart', $cart);

            return redirect()->back()->with('success', 'Removed from cart');
        }

        return redirect()->back()->with('error', 'Ad not found in cart');
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
            $purchase->ads()->attach($item['ad']->id, [
                'quantity' => $item['quantity'],
            ]);
        }

        session()->forget('cart');

        return redirect()->route('home')->with('success', 'Purchase completed');
    }
}
