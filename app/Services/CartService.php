<?php

namespace App\Services;

use App\Http\Requests\StoreReservationRequest;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

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

    public function validateCartBeforeCheckout(array $cart, ReservationService $reservationService)
    {
        foreach ($cart as $item) {
            $product = $item['product'];
            $quantity = $item['quantity'];

            if (in_array($product->type, ['sale', 'auctions']) && $product->stock < $quantity) {
                return redirect()->back()->with('error', "Not enough stock for {$product->name}. Only {$product->stock} left.");
            }

            if ($product->type === 'rental') {
                $data = [
                    'product_id' => $product->id,
                    'start_time' => $item['start_date'] ?? null,
                    'end_time' => $item['end_date'] ?? null,
                ];

                $validator = Validator::make($data, (new StoreReservationRequest)->rules());

                if ($validator->fails()) {
                    return redirect()->back()
                        ->withErrors($validator)
                        ->with('error', 'Invalid rental reservation data.');
                }

                for ($i = 0; $i < $quantity; $i++) {
                    $result = $reservationService->reserve(
                        $data['product_id'],
                        $data['start_time'],
                        $data['end_time']
                    );

                    if ($result !== true) {
                        return redirect()->back()->with('error', $result);
                    }
                }
            }
        }

        return true;
    }

    public function processCheckout(array $cart, ReservationService $reservationService)
    {
        $purchase = Purchase::create([
            'user_id' => Auth::id(),
            'purchased_at' => now(),
        ]);

        foreach ($cart as $item) {
            $product = $item['product'];
            $quantity = $item['quantity'];

            if (in_array($product->type, ['sale', 'auctions'])) {
                $product->decrement('stock', $quantity);
            }

            $purchase->products()->attach($product->id, ['quantity' => $quantity]);
        }

        return $purchase;
    }
}
