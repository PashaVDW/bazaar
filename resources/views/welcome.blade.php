@extends('layouts.app')

@section('content')
    <section x-data="{ showContent: false }">
        <div class="pt-12 pb-24 2xl:pb-44 bg-blueGray-100">
            <div class="container px-4 mx-auto">
                <div class="pb-9 text-center relative">
                    <h2 class="mb-5 md:mb-0 text-4xl md:text-5xl lg:text-6xl leading-tight font-heading font-semibold text-center">
                        Ads
                    </h2>
                    <span class="md:absolute md:right-0 md:bottom-3 text-sm text-gray-400 font-medium">
                    {{ $ads->total() }} {{ Str::plural('ad', $ads->total()) }} gevonden
                </span>
                </div>

                <div class="grid grid-cols-12 gap-6">
                    <div class="col-span-12 lg:col-span-2 md:col-span-3">
                        <form method="GET" action="{{ route('home') }}">
                            <div class="rounded-xl border border-gray-300 bg-white p-4 w-full">
                                <label for="type" class="block mb-2 text-sm font-medium text-gray-600">Type</label>
                                <select id="type" name="type" class="mb-4 h-10 border border-gray-300 rounded-full block w-full px-3 bg-white">
                                    <option value="">All</option>
                                    <option value="sale" @selected(request('type') === 'sale')>Sale</option>
                                    <option value="rental" @selected(request('type') === 'rental')>Rental</option>
                                    <option value="auction" @selected(request('type') === 'auction')>Auction</option>
                                </select>

                                <label for="sort" class="block mb-2 text-sm font-medium text-gray-600">Sort by</label>
                                <select id="sort" name="sort" class="mb-4 h-10 border border-gray-300 rounded-full block w-full px-3 bg-white">
                                    <option value="latest" @selected(request('sort') === 'latest')>Latest</option>
                                    <option value="price_low_high" @selected(request('sort') === 'price_low_high')>Price: Low → High</option>
                                    <option value="price_high_low" @selected(request('sort') === 'price_high_low')>Price: High → Low</option>
                                </select>

                                <label class="block mb-2 text-sm font-medium text-gray-600">Price range</label>
                                <div class="flex space-x-2 mb-4">
                                    <input type="number" step="0.01" name="price_min" placeholder="Min" value="{{ request('price_min') }}" class="h-10 border border-gray-300 rounded-full w-1/2 px-3 bg-white">
                                    <input type="number" step="0.01" name="price_max" placeholder="Max" value="{{ request('price_max') }}" class="h-10 border border-gray-300 rounded-full w-1/2 px-3 bg-white">
                                </div>

                                <label class="block mb-2 text-sm font-medium text-gray-600">Date range</label>
                                <div class="mb-4 space-y-2">
                                    <input type="date" name="date_start" value="{{ request('date_start') }}" class="h-10 border border-gray-300 rounded-full w-full px-3 bg-white">
                                    <input type="date" name="date_end" value="{{ request('date_end') }}" class="h-10 border border-gray-300 rounded-full w-full px-3 bg-white">
                                </div>

                                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white rounded-full py-2 px-4 transition duration-300">
                                    Apply Filters
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="col-span-12 lg:col-span-10 md:col-span-9">
                        @if ($ads->count() > 0)
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                                @foreach ($ads as $ad)
                                    <div class="relative bg-white border border-gray-200 rounded-3xl shadow-md overflow-hidden hover:shadow-lg transition-all duration-200">
                                        <a href="{{ route('ads.show', $ad) }}">
                                            <figure class="w-full h-48 overflow-hidden">
                                                <img src="{{ asset('storage/' . $ad->image) }}" alt="{{ $ad->title }}" class="w-full h-full object-cover" />
                                            </figure>
                                            <div class="px-5 py-4">
                                                <h5 class="text-lg font-semibold text-gray-900 mb-2">{{ $ad->title }}</h5>
                                                @php
                                                    $product = $ad->products->first();
                                                @endphp
                                                @if ($product && $product->stock < 5)
                                                    <p class="text-xs text-red-600 font-medium mb-1">({{ $product->stock }} left)</p>
                                                @endif
                                                <div class="flex items-center mb-3">
                                                    <div class="flex items-center space-x-1">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <svg class="w-4 h-4 {{ $i <= 4 ? 'text-yellow-300' : 'text-gray-200' }}" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                                                <path d="M20.924 7.625a1.523 1.523 0 00-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 00-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 001.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 002.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 002.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 00.387-1.575z"/>
                                                            </svg>
                                                        @endfor
                                                    </div>
                                                    <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded-sm ml-3">4.0</span>
                                                </div>
                                            </div>
                                        </a>

                                        <div class="px-5 pb-5">
                                            <button data-modal-target="modal-{{ $ad->id }}" data-modal-toggle="modal-{{ $ad->id }}"
                                                    class="w-full text-sm bg-indigo-600 hover:bg-indigo-700 text-white py-2 rounded-full transition">
                                                Share
                                            </button>
                                        </div>

                                        <div id="modal-{{ $ad->id }}" tabindex="-1" aria-hidden="true"
                                             class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto h-[100vh] bg-black/50">
                                            <div class="relative w-full max-w-lg mx-auto mt-24">
                                                <div class="bg-white rounded-2xl shadow-lg p-6">
                                                    <div class="flex items-start justify-between pb-4">
                                                        <h3 class="text-xl font-semibold text-gray-900">
                                                            Share QR Code
                                                        </h3>
                                                        <button type="button"
                                                                class="text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                                                data-modal-hide="modal-{{ $ad->id }}">
                                                            <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                 viewBox="0 0 14 14">
                                                                <path stroke="currentColor" stroke-linecap="round"
                                                                      stroke-linejoin="round" stroke-width="2"
                                                                      d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                    <div class="mt-6 flex justify-center items-center">
                                                        <div class="w-48 h-48 flex justify-center items-center">
                                                            {!! Storage::disk('public')->get(str_replace('storage/', '', $ad->qr_code_path)) !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center text-gray-500 text-lg mt-20 mb-40">
                                No ads found for your filters.
                            </div>
                        @endif

                        @if ($ads->hasPages())
                            <div class="flex justify-center mt-12">
                                {{ $ads->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
