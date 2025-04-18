@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    {{-- Toasts --}}
    @if (session('success'))
        <x-shared.toast type="success" :message="session('success')" />
    @endif

    @if (session('error'))
        <x-shared.toast type="error" :message="session('error')" />
    @endif

    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-2">Your Cart</h1>
        <p class="text-gray-500 text-sm">You have {{ count($cart) }} {{ Str::plural('item', count($cart)) }} in your cart</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-6">
            @php $total = 0; @endphp
            @forelse ($cart as $item)
                @php
                    $product = $item['product'];
                    $qty = $item['quantity'];
                    $price = $product->price * $qty;
                    $total += $price;
                @endphp

                <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5 flex flex-col sm:flex-row gap-4 sm:gap-6 items-center relative">
                    <img src="{{ asset('storage/' . $product->ad->image) }}"
                         alt="{{ $product->name }}"
                         class="w-24 h-24 object-cover rounded-md border border-gray-200">

                    <div class="flex-1 w-full">
                        <div class="flex items-start justify-between">
                            <div>
                                <h2 class="text-lg font-semibold text-gray-800">{{ $product->name }}</h2>
                                <p class="text-sm text-gray-500">Type: {{ ucfirst($product->type) }}</p>
                            </div>

                            <form method="POST" action="{{ route('cart.remove', $product) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="Remove"
                                        class="text-gray-400 hover:text-red-600 transition">
                                    <i class="fas fa-xmark text-lg"></i>
                                </button>
                            </form>
                        </div>

                        <div class="mt-4 flex items-center justify-between">
                            <form action="{{ route('cart.update', $product) }}" method="POST" class="flex items-center gap-3">
                                @csrf
                                <label class="text-sm text-gray-600 font-medium">Qty</label>
                                <input type="number" name="quantity" value="{{ $qty }}" min="1"
                                       class="w-16 px-3 py-2 border border-gray-300 text-center rounded-md text-gray-700 focus:ring-primary focus:border-primary transition shadow-sm">
                                <button type="submit" class="text-sm text-primary hover:underline">Update</button>
                            </form>

                            <span class="text-lg font-semibold text-primary whitespace-nowrap">
                                €{{ number_format($price, 2, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white p-6 rounded-xl text-center text-gray-500 border border-gray-200 shadow-sm">
                    Your cart is currently empty.
                </div>
            @endforelse
        </div>

        <div>
            <div class="bg-white border border-gray-200 rounded-xl shadow-md p-6 sticky top-10">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Order Summary</h2>

                <div class="space-y-4 text-sm text-gray-700">
                    <div class="flex justify-between">
                        <span>Subtotal</span>
                        <span>€{{ number_format($total, 2, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Service Fee</span>
                        <span>€10,00</span>
                    </div>
                    <div class="border-t border-gray-200 pt-4 flex justify-between text-base font-semibold text-gray-900">
                        <span>Total</span>
                        <span>€{{ number_format($total + 10, 2, ',', '.') }}</span>
                    </div>
                </div>

                <form method="POST" action="{{ route('cart.checkout') }}" class="mt-6">
                    @csrf
                    <button type="submit"
                            class="w-full py-3 bg-primary hover:bg-orange-600 text-white font-medium rounded-lg transition">
                        Proceed to Checkout
                    </button>
                </form>

                <a href="{{ route('home') }}"
                   class="block text-center mt-4 text-sm text-gray-500 hover:text-gray-700 transition">
                    ← Back to Shop
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
