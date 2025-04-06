@extends('layouts.app')

@section('content')

    <section x-data="{ showContent: false }">
        <div class="pt-12 pb-24 2xl:pb-44 bg-blueGray-100">
            <div class="container px-4 mx-auto">

                <div class="pb-9 text-center relative">
                    <h2 class="mb-5 md:mb-0 text-4xl md:text-5xl lg:text-6xl leading-tight font-heading font-semibold text-center">
                        {{ __('messages.ads') }}
                    </h2>
                    <x-shared.horizontal-filter :action="route('home')" />

                    <span class="md:absolute md:right-0 md:bottom-3 text-sm text-gray-400 font-medium">
                    {{ $ads->total() }} {{ Str::plural(__('messages.ad'), $ads->total()) }} {{ __('messages.found') }}
                </span>
                </div>

                <div class="grid grid-cols-12 gap-6">
                    <div class="col-span-12 lg:col-span-2 md:col-span-3">
                        <form method="GET" action="{{ route('home') }}">
                            <div class="rounded-xl border border-gray-300 bg-white p-4 w-full">
                                <label for="type" class="block mb-2 text-sm font-medium text-gray-600">{{ __('messages.type') }}</label>
                                <select id="type" name="type" class="mb-4 h-10 border border-gray-300 rounded-full block w-full px-3 bg-white">
                                    <option value="">{{ __('messages.all') }}</option>
                                    <option value="sale" @selected(request('type') === 'sale')>{{ __('messages.sale') }}</option>
                                    <option value="rental" @selected(request('type') === 'rental')>{{ __('messages.rental') }}</option>
                                    <option value="auction" @selected(request('type') === 'auction')>{{ __('messages.auction') }}</option>
                                </select>

                                <label for="sort" class="block mb-2 text-sm font-medium text-gray-600">{{ __('messages.sort_by') }}</label>
                                <select id="sort" name="sort" class="mb-4 h-10 border border-gray-300 rounded-full block w-full px-3 bg-white">
                                    <option value="latest" @selected(request('sort') === 'latest')>{{ __('messages.latest') }}</option>
                                    <option value="price_low_high" @selected(request('sort') === 'price_low_high')>{{ __('messages.price_low_high') }}</option>
                                    <option value="price_high_low" @selected(request('sort') === 'price_high_low')>{{ __('messages.price_high_low') }}</option>
                                </select>

                                <label class="block mb-2 text-sm font-medium text-gray-600">{{ __('messages.price_range') }}</label>
                                <div class="flex space-x-2 mb-4">
                                    <input type="number" step="0.01" name="price_min" placeholder="{{ __('messages.min') }}" value="{{ request('price_min') }}" class="h-10 border border-gray-300 rounded-full w-1/2 px-3 bg-white">
                                    <input type="number" step="0.01" name="price_max" placeholder="{{ __('messages.max') }}" value="{{ request('price_max') }}" class="h-10 border border-gray-300 rounded-full w-1/2 px-3 bg-white">
                                </div>

                                <label class="block mb-2 text-sm font-medium text-gray-600">{{ __('messages.date_range') }}</label>
                                <div class="mb-4 space-y-2">
                                    <input type="date" name="date_start" value="{{ request('date_start') }}" class="h-10 border border-gray-300 rounded-full w-full px-3 bg-white">
                                    <input type="date" name="date_end" value="{{ request('date_end') }}" class="h-10 border border-gray-300 rounded-full w-full px-3 bg-white">
                                </div>

                                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white rounded-full py-2 px-4 transition duration-300">
                                    {{ __('messages.apply_filters') }}
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="col-span-12 lg:col-span-10 md:col-span-9">
                        @if ($ads->count() > 0)
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                                @foreach ($ads as $ad)
                                    @php
                                        $product = $ad->products->first();
                                        $reviews = $ad->products->flatMap->reviews;
                                        $avgRating = $reviews->count() ? round($reviews->avg('rating'), 1) : null;
                                    @endphp

                                    <div class="bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition duration-200 flex flex-col h-full">
                                        <a href="{{ route('ads.show', $ad) }}" class="block">
                                            <div class="w-full h-44 overflow-hidden rounded-t-xl">
                                                <img src="{{ asset('storage/' . $ad->image) }}" alt="{{ $ad->title }}" class="w-full h-full object-cover" />
                                            </div>
                                            <div class="p-4 space-y-2">
                                                <h5 class="text-base font-semibold text-gray-800 truncate">{{ $ad->title }}</h5>

                                                @if ($product && $product->stock < 5)
                                                    <p class="text-xs text-red-600 font-medium">({{ $product->stock }} {{ __('messages.left') }})</p>
                                                @endif

                                                <div class="flex items-center justify-between mt-2">
                                                    <div class="flex items-center gap-1">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <svg class="w-4 h-4 {{ $i <= round($avgRating) ? 'text-yellow-400' : 'text-gray-200' }}"
                                                                 fill="currentColor" viewBox="0 0 20 20">
                                                                <path d="M10 15l-5.878 3.09 1.122-6.545L.489 6.91l6.561-.955L10 0l2.95 5.955 6.561.955-4.755 4.635 1.122 6.545z"/>
                                                            </svg>
                                                        @endfor
                                                    </div>
                                                    @if ($avgRating)
                                                        <span class="text-xs bg-blue-100 text-blue-800 font-semibold px-2 py-0.5 rounded">{{ $avgRating }}</span>
                                                    @else
                                                        <span class="text-xs text-gray-400">{{ __('messages.no_reviews_yet') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </a>

                                        @if ($product)
                                            <form method="POST" action="{{ route('cart.add', $product) }}" class="p-4 pt-0 mt-auto">
                                                @csrf
                                                <button type="submit"
                                                        class="w-full text-sm bg-primary hover:bg-primary-hover text-white py-2 px-4 rounded-md transition">
                                                    <i class="fas fa-cart-plus mr-1"></i> {{ __('messages.add_to_cart') }}
                                                </button>
                                            </form>
                                        @endif

                                        <div class="px-5 pb-5">
                                            <button data-modal-target="modal-{{ $ad->id }}" data-modal-toggle="modal-{{ $ad->id }}"
                                                    class="w-full text-sm border border-gray-300 bg-gray-100 hover:bg-gray-300 text-gray-600 py-2 rounded-md transition">
                                                <i class="fas fa-share-alt mr-2"></i> {{ __('messages.share') }}
                                            </button>
                                        </div>

                                        <div id="modal-{{ $ad->id }}" tabindex="-1" aria-hidden="true"
                                             class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto h-[100vh] bg-black/50">
                                            <div class="relative w-full max-w-lg mx-auto mt-24">
                                                <div class="bg-white rounded-2xl shadow-lg p-6">
                                                    <div class="flex items-start justify-between pb-4">
                                                        <h3 class="text-xl font-semibold text-gray-900">{{ __('messages.share_qr_code') }}</h3>
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
                                {{ __('messages.no_ads_found_for_your_filters') }}
                            </div>
                        @endif

                        @if ($ads->hasPages())
                            <x-shared.pagination :paginator="$ads" />
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
