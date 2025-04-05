@extends('layouts.app')

@section('content')
    <section x-data="{ showContent: false }">
        <div class="pt-12 pb-24 2xl:pb-44 bg-blueGray-100">
            <div class="container px-4 mx-auto">

                <!-- Header -->
                <div class="pb-9 text-center relative">
                    <h2 class="mb-5 md:mb-0 text-4xl md:text-5xl lg:text-6xl leading-tight font-heading font-semibold text-center">
                        Products
                    </h2>
                    <span class="md:absolute md:right-0 md:bottom-3 text-sm text-gray-400 font-medium">
                        {{ $ads->total() }} {{ Str::plural('product', $ads->total()) }} found
                    </span>
                </div>

                <div class="grid grid-cols-12 gap-6">

                    <!-- LEFT SIDEBAR FILTER (Updated with Price & Date Ranges) -->
                    <div class="col-span-12 lg:col-span-2 md:col-span-3">
                        <form method="GET" action="{{ route('home') }}">
                            <div class="rounded-xl border border-gray-300 bg-white p-4 w-full">
                                <!-- Type Filter -->
                                <label for="type" class="block mb-2 text-sm font-medium text-gray-600">Type</label>
                                <select id="type" name="type"
                                        class="mb-4 h-10 border border-gray-300 rounded-full block w-full px-3 bg-white">
                                    <option value="">All</option>
                                    <option value="sale" @if(request('type')==='sale')selected @endif>Sale</option>
                                    <option value="rental" @if(request('type')==='rental')selected @endif>Rental</option>
                                    <option value="auction" @if(request('type')==='auction')selected @endif>Auction</option>
                                </select>

                                <!-- Sort Filter -->
                                <label for="sort" class="block mb-2 text-sm font-medium text-gray-600">Sort by</label>
                                <select id="sort" name="sort"
                                        class="mb-4 h-10 border border-gray-300 rounded-full block w-full px-3 bg-white">
                                    <option value="latest" @if(request('sort')==='latest')selected @endif>Latest</option>
                                    <option value="price_low_high" @if(request('sort')==='price_low_high')selected @endif>Price: Low → High</option>
                                    <option value="price_high_low" @if(request('sort')==='price_high_low')selected @endif>Price: High → Low</option>
                                </select>

                                <!-- Price Range -->
                                <label class="block mb-2 text-sm font-medium text-gray-600">Price range</label>
                                <div class="flex space-x-2 mb-4">
                                    <input type="number" step="0.01" name="price_min" placeholder="Min" value="{{ request('price_min') }}"
                                           class="h-10 border border-gray-300 rounded-full w-1/2 px-3 bg-white">
                                    <input type="number" step="0.01" name="price_max" placeholder="Max" value="{{ request('price_max') }}"
                                           class="h-10 border border-gray-300 rounded-full w-1/2 px-3 bg-white">
                                </div>

                                <!-- Date Range -->
                                <label class="block mb-2 text-sm font-medium text-gray-600">Date range</label>
                                <div class="mb-4 space-y-2">
                                    <input type="date" name="date_start" value="{{ request('date_start') }}"
                                           class="h-10 border border-gray-300 rounded-full w-full px-3 bg-white">
                                    <input type="date" name="date_end" value="{{ request('date_end') }}"
                                           class="h-10 border border-gray-300 rounded-full w-full px-3 bg-white">
                                </div>

                                <!-- Apply Filters Button -->
                                <button type="submit"
                                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white rounded-full py-2 px-4 transition duration-300">
                                    Apply Filters
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- PRODUCT GRID (expanded width) -->
                    <div class="col-span-12 lg:col-span-10 md:col-span-9">
                        @if ($ads->count() > 0)
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                                @foreach ($ads as $ad)
                                    <div class="bg-white border border-gray-200 rounded-3xl shadow-md overflow-hidden flex flex-col">
                                        <figure class="w-full h-48 overflow-hidden">
                                            <img src="{{ asset('storage/' . $ad->image) }}"
                                                 alt="{{ $ad->title }}"
                                                 class="w-full h-full object-cover"/>
                                        </figure>
                                        <div class="px-5 py-4 flex-1 flex flex-col justify-between">
                                            <div>
                                                <h5 class="text-lg font-semibold text-gray-900 mb-2">
                                                    {{ $ad->title }}
                                                </h5>

                                                <!-- RATINGS -->
                                                <div class="flex items-center mb-4">
                                                    <div class="flex items-center space-x-1">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <svg class="w-4 h-4 {{ $i <= 4 ? 'text-yellow-300' : 'text-gray-200' }}"
                                                                 xmlns="http://www.w3.org/2000/svg"
                                                                 fill="currentColor" viewBox="0 0 22 20">
                                                                <path d="M20.924 7.625a1.523 1.523 0 00-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 00-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 001.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 002.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 002.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 00.387-1.575z"/>
                                                            </svg>
                                                        @endfor
                                                    </div>
                                                    <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded-sm ml-3">4.0</span>
                                                </div>
                                            </div>

                                            <div class="flex items-center justify-between mt-auto">
                                                <span class="text-xl font-bold text-gray-900">
                                                    €{{ number_format($ad->hourly_price, 2, ',', '.') }}
                                                    @if ($ad->type === 'rental')
                                                        <span class="text-sm text-gray-500 font-normal">/hour</span>
                                                    @endif
                                                </span>
                                                <a href="#"
                                                   class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-4 py-2 transition">
                                                    {{ $ad->type === 'rental' ? 'Reserve' : 'Add to cart' }}
                                                </a>
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
                                    <nav class="flex space-x-1" role="navigation" aria-label="Pagination Navigation">
                                        {{-- Previous Page Link --}}
                                        @if ($ads->onFirstPage())
                                            <span class="px-3 py-2 text-gray-400 select-none">Previous</span>
                                        @else
                                            <a href="{{ $ads->previousPageUrl() }}"
                                               class="px-3 py-2 text-gray-600 hover:text-indigo-600 transition">Previous</a>
                                        @endif

                                        {{-- Page Number Links --}}
                                        @foreach ($ads->links()->elements[0] ?? [] as $page => $url)
                                            @if ($page == $ads->currentPage())
                                                <span class="px-3 py-2 bg-indigo-600 text-white rounded-full">{{ $page }}</span>
                                            @else
                                                <a href="{{ $url }}"
                                                   class="px-3 py-2 text-gray-600 hover:text-indigo-600 transition">{{ $page }}</a>
                                            @endif
                                        @endforeach

                                        {{-- Next Page Link --}}
                                        @if ($ads->hasMorePages())
                                            <a href="{{ $ads->nextPageUrl() }}"
                                               class="px-3 py-2 text-gray-600 hover:text-indigo-600 transition">Next</a>
                                        @else
                                            <span class="px-3 py-2 text-gray-400 select-none">Next</span>
                                        @endif
                                    </nav>
                                </div>
                            @endif


                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
