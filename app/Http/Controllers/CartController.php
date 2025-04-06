<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReservationRequest;
use App\Models\Product;
use App\Models\Purchase;
use App\Services\CartService;
use App\Services\ReservationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        $cart = $this->cartService->getCartWithProducts();

        return view('cart.index', compact('cart'));
    }

    public function add(Request $request, Product $product)
    {
        $result = $this->cartService->addProductToCart($request, $product);

        return $result === true
            ? redirect()->back()->with('success', 'Added to cart')
            : $result;
    }

    public function update(Request $request, Product $product)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);
        $updated = $this->cartService->updateQuantity($product, $request->quantity);

        return $updated
            ? redirect()->back()->with('success', 'Quantity updated')
            : redirect()->back()->with('error', 'Product not found in cart');
    }

    public function remove(Product $product)
    {
        $removed = $this->cartService->removeProductFromCart($product);

        return $removed
            ? redirect()->back()->with('success', 'Removed from cart')
            : redirect()->back()->with('error', 'Product not found in cart');
    }

    public function checkout(ReservationService $reservationService)
    {
        $cart = $this->cartService->getCart();
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Your cart is empty');
        }

        $purchase = Purchase::create([
            'user_id' => Auth::id(),
            'purchased_at' => now(),
        ]);

        foreach ($cart as $item) {
            $product = $item['product'];
            $quantity = $item['quantity'];

            if (in_array($product->type, ['sale', 'auction'])) {
                if ($product->stock < $quantity) {
                    return redirect()->back()->with('error', "Not enough stock for {$product->name}. Only {$product->stock} left.");
                }

                $product->decrement('stock', $quantity);

                $purchase->products()->attach($product->id, ['quantity' => $quantity]);
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

                $purchase->products()->attach($product->id, ['quantity' => $quantity]);
            }
        }

        session()->forget('cart');

        return redirect()->route('home')->with('success', 'Purchase completed');
    }
}
