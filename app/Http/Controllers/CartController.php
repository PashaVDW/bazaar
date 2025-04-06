<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use App\Services\ReservationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

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

        $cart = array_map(function ($item) {
            $product = $item['product'];

            return [
                ...$item,
                'image_url' => $product->image ? asset('storage/'.$product->image) : null,
                'type' => ucfirst($product->type),
                'name' => $product->name,
                'price_each' => $product->price,
                'total_price' => $product->price * $item['quantity'],
            ];
        }, $cart);

        $total = array_sum(array_column($cart, 'total_price'));

        return view('cart.index', compact('cart', 'total'));
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

    public function checkout(ReservationService $reservationService)
    {
        $cart = $this->cartService->getCart();

        if (empty($cart)) {
            return redirect()->back()->with('error', 'Your cart is empty');
        }

        $validationResult = $this->cartService->validateCartBeforeCheckout($cart, $reservationService);

        if ($validationResult !== true) {
            return $validationResult;
        }

        $this->cartService->processCheckout($cart, $reservationService);

        session()->forget('cart');

        return redirect()->route('home')->with('success', 'Purchase completed');
    }
}
