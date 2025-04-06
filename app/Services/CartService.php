<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartService
{
    public function getCart(): array
    {
        return Session::get('cart', []);
    }

    public function getCartWithProducts(): array
    {
        $cart = $this->getCart();

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

        Session::put('cart', $cart);

        return $cart;
    }

    public function addProductToCart(Request $request, Product $product): bool|\Illuminate\Http\RedirectResponse
    {
        $product->load('ad');
        $cart = $this->getCart();

        $entry = [
            'product' => $product,
            'quantity' => ($cart[$product->id]['quantity'] ?? 0) + 1,
        ];

        if ($product->type === 'rental') {
            $validated = $request->validate([
                'start_date' => 'required|date|after_or_equal:now',
                'end_date' => 'required|date|after:start_date',
            ]);

            $entry['start_date'] = $validated['start_date'];
            $entry['end_date'] = $validated['end_date'];
        }

        $cart[$product->id] = $entry;

        Session::put('cart', $cart);

        return true;
    }

    public function updateQuantity(Product $product, int $quantity): bool
    {
        $cart = $this->getCart();

        if (! isset($cart[$product->id])) {
            return false;
        }

        $cart[$product->id]['quantity'] = $quantity;
        Session::put('cart', $cart);

        return true;
    }

    public function removeProductFromCart(Product $product): bool
    {
        $cart = $this->getCart();

        if (! isset($cart[$product->id])) {
            return false;
        }

        unset($cart[$product->id]);
        Session::put('cart', $cart);

        return true;
    }
}
