@extends('layouts.app')

@section('content')
    <div class="fixed top-5 right-5 z-[9999] space-y-2">
        @if (session('success'))
            <div id="toast-success" class="flex items-center w-full max-w-xs p-4 text-gray-700 bg-white border border-green-200 rounded-lg shadow-sm transition-opacity duration-500" role="alert">
                <div class="inline-flex items-center justify-center w-8 h-8 text-green-500 bg-green-100 rounded-lg">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                    </svg>
                </div>
                <div class="ms-3 text-sm font-medium">{{ session('success') }}</div>
                <button type="button" class="ms-auto text-gray-400 hover:text-gray-900 rounded-lg p-1.5 hover:bg-gray-100" data-dismiss-target="#toast-success" aria-label="Close">
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
            </div>
        @endif

        @if (session('error'))
            <div id="toast-danger" class="flex items-center w-full max-w-xs p-4 text-red-600 bg-white border border-red-200 rounded-lg shadow-sm" role="alert">
                <div class="inline-flex items-center justify-center w-8 h-8 text-red-500 bg-red-100 rounded-lg">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z"/>
                    </svg>
                </div>
                <div class="ms-3 text-sm font-medium">{{ session('error') }}</div>
                <button type="button" class="ms-auto text-gray-400 hover:text-gray-900 rounded-lg p-1.5 hover:bg-gray-100" data-dismiss-target="#toast-danger" aria-label="Close">
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
            </div>
        @endif
    </div>

    <section class="pt-12 pb-24 overflow-hidden bg-blueGray-100">
        <div class="container px-4 mx-auto">
            <ul class="flex flex-wrap items-center mb-10 xl:mb-0">
                <li class="mr-6">
                    <a class="flex items-center text-sm font-medium text-gray-400 hover:text-gray-500" href="{{ route('home') }}">
                        <span>Home</span>
                        <svg class="ml-6" width="4" height="7" viewBox="0 0 4 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0.15 0.9C-0.05 0.69 -0.05 0.36 0.15 0.15C0.35 -0.05 0.67 -0.05 0.87 0.15L3.74 3.13C3.94 3.33 3.94 3.67 3.74 3.87L0.87 6.85C0.68 7.05 0.35 7.05 0.15 6.85C-0.05 6.64 -0.05 6.31 0.15 6.10L2.5 3.5L0.15 0.9Z" fill="currentColor" />
                        </svg>
                    </a>
                </li>
                <li><a class="text-sm font-medium text-indigo-500 hover:text-indigo-600" href="#">Your cart</a></li>
            </ul>

            <div class="mb-8 pb-8 border-b border-gray-200 border-opacity-40">
                <h1 class="text-center text-6xl md:text-7xl xl:text-8xl font-heading font-medium">Your cart</h1>
            </div>

            <div class="flex flex-wrap -mx-4 mb-14 xl:mb-24">
                <div class="w-full md:w-8/12 xl:w-9/12 px-4 mb-14 md:mb-0">
                    <div class="py-12 px-8 md:px-12 bg-white rounded-3xl">
                        <span class="inline-block mb-10 text-darkBlueGray-300 font-medium">{{ count($cart) }} products</span>
                        <div class="xl:px-10">
                            @php $total = 0; @endphp
                            @forelse($cart as $item)
                                @php
                                    $product = $item['product'];
                                    $qty = $item['quantity'];
                                    $price = $product->price * $qty;
                                    $total += $price;
                                @endphp
                                <div class="relative flex flex-wrap items-center xl:justify-between -mx-4 mb-8 pb-8 border-b border-gray-200 border-opacity-40">
                                    <div class="relative w-full md:w-auto px-4 mb-6 xl:mb-0">
                                        <a class="block mx-auto max-w-max" href="#">
                                            <img class="h-28 object-cover" src="{{ asset('storage/' . $product->ad->image) }}" alt="{{ $product->name }}">
                                        </a>
                                    </div>
                                    <div class="w-full md:w-auto px-4 mb-6 xl:mb-0">
                                        <a class="block mb-5 text-xl font-heading font-medium hover:underline" href="#">{{ $product->name }}</a>
                                        <p class="text-sm text-gray-400">Type: {{ ucfirst($product->type) }}</p>
                                    </div>
                                    <div class="w-full xl:w-auto px-4 mb-6 xl:mb-0 mt-6 xl:mt-0">
                                        <form action="{{ route('cart.update', $product) }}" method="POST" class="flex items-center">
                                            @csrf
                                            <h4 class="mr-4 font-heading font-medium">Qty:</h4>
                                            <input type="number" name="quantity" value="{{ $qty }}" min="1"
                                                   class="w-16 px-3 py-2 text-center placeholder-gray-400 text-gray-700 bg-blue-50 border-2 border-blue-400 outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 rounded-xl" />
                                            <button type="submit" class="ml-2 text-sm text-blue-600 hover:underline">Update</button>
                                        </form>
                                    </div>
                                    <div class="w-full xl:w-auto px-4">
                                        <span class="text-xl font-heading font-medium text-blue-500">
                                            €{{ number_format($price, 2, ',', '.') }}
                                        </span>
                                    </div>
                                    <form action="{{ route('cart.remove', $product) }}" method="POST" class="absolute top-0 right-0 lg:mt-6 lg:-mr-4">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-gray-300 hover:text-gray-500" title="Verwijderen">
                                            <svg width="28" height="28" fill="none" viewBox="0 0 28 28">
                                                <rect x="0.5" y="0.5" width="27" height="27" rx="13.5" stroke="currentColor"/>
                                                <line x1="20.5" y1="8.5" x2="8.5" y2="20.5" stroke="currentColor" stroke-width="1.4"/>
                                                <line x1="19.5" y1="20.5" x2="7.5" y2="8.5" stroke="currentColor" stroke-width="1.4"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            @empty
                                <p class="text-gray-600">Je winkelwagen is leeg.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="w-full md:w-4/12 xl:w-3/12 px-4">
                    <div class="mb-14">
                        <h2 class="mb-7 md:mt-6 text-3xl font-heading font-medium">Cart totals</h2>
                        <div class="flex items-center justify-between py-4 px-10 mb-3 bg-white bg-opacity-50 font-heading font-medium rounded-3xl">
                            <span>Subtotal</span>
                            <span class="flex items-center text-xl"><span class="mr-2 text-base">€</span><span>{{ number_format($total, 2, ',', '.') }}</span></span>
                        </div>
                        <div class="flex items-center justify-between py-4 px-10 mb-6 bg-white font-heading font-medium rounded-3xl">
                            <span>Total</span>
                            <span class="flex items-center text-xl text-blue-500"><span class="mr-2 text-base">€</span><span>{{ number_format($total + 10, 2, ',', '.') }}</span></span>
                        </div>
                        <form method="POST" action="{{ route('cart.checkout') }}">
                            @csrf
                            <button type="submit" class="inline-block w-full py-5 px-10 text-xl text-white font-medium text-center bg-blue-500 hover:bg-blue-600 rounded-xl transition">
                                Checkout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="md:w-96">
                <a class="block py-5 px-10 w-full text-xl font-medium text-center bg-white hover:bg-gray-50 rounded-xl transition" href="{{ route('home') }}">Back to shop</a>
            </div>
        </div>
    </section>
@endsection
