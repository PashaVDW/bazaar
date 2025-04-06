@extends('layouts.app')

@section('content')
    <section class="pt-24 pb-20 bg-gray-100">
        <div class="max-w-5xl mx-auto px-6">
            <div class="bg-white rounded-3xl shadow-xl p-10 md:p-14">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div class="flex justify-center">
                        @if ($mainProduct)
                            <img src="{{ asset('storage/' . $mainProduct->image) }}"
                                 alt="{{ $mainProduct->name }}"
                                 class="rounded-2xl w-full object-cover shadow-md max-h-[400px] mx-auto">
                        @else
                            <p class="text-lg text-gray-500">{{ __('messages.no_main_product_found') }}</p>
                        @endif
                    </div>

                    <div>
                        @if ($mainProduct)
                            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4 leading-tight">
                                {{ $mainProduct->name }}
                            </h1>

                            @if ($reviews->isNotEmpty())
                                <div class="flex items-center mb-6">
                                    <div class="flex text-yellow-400">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <svg class="w-6 h-6 {{ $i <= $averageRating ? '' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.975a1 1 0 00.95.69h4.2c.969 0 1.371 1.24.588 1.81l-3.4 2.475a1 1 0 00-.364 1.118l1.287 3.974c.3.922-.755 1.688-1.538 1.118l-3.4-2.474a1 1 0 00-1.176 0l-3.4 2.474c-.783.57-1.838-.196-1.538-1.118l1.287-3.974a1 1 0 00-.364-1.118l-3.4-2.475c-.783-.57-.38-1.81.588-1.81h4.2a1 1 0 00.95-.69l1.286-3.975z" />
                                            </svg>
                                        @endfor
                                    </div>
                                    <span class="ml-3 text-sm text-gray-600">{{ $reviews->count() }} {{ __('messages.reviews') }}</span>
                                </div>
                            @endif

                            <p class="text-lg text-gray-700 leading-relaxed mb-8">
                                {{ $mainProduct->description }}
                            </p>

                            <form method="POST" action="{{ route('cart.add', $mainProduct->id) }}">
                                @csrf

                                @if ($mainProduct->type === 'rental')
                                    <div class="mb-4">
                                        <label for="start_date_{{ $mainProduct->id }}" class="block mb-2 text-sm font-medium text-gray-700">{{ __('messages.start_date') }}</label>
                                        <input type="datetime-local" name="start_date" id="start_date_{{ $mainProduct->id }}" required
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                    </div>

                                    <div class="mb-6">
                                        <label for="end_date_{{ $mainProduct->id }}" class="block mb-2 text-sm font-medium text-gray-700">{{ __('messages.end_date') }}</label>
                                        <input type="datetime-local" name="end_date" id="end_date_{{ $mainProduct->id }}" required
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                    </div>
                                @endif

                                <button type="submit"
                                        class="inline-flex items-center justify-center px-6 py-3 text-base font-medium text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 transition w-full sm:w-auto">
                                    <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" stroke-width="2"
                                         viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 9h14l-2-9M10 21a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm8 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
                                    </svg>
                                    {{ __('messages.add_to_cart') }}
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            @if ($subProducts->isNotEmpty())
                <div class="mt-16">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-6">{{ __('messages.other_products_in_this_ad') }}</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($subProducts as $product)
                            <div class="bg-white p-4 rounded-xl shadow">
                                <img src="{{ asset('storage/' . $product->image) }}"
                                     alt="{{ $product->name }}"
                                     class="rounded-lg h-40 w-full object-cover mb-4">
                                <h3 class="text-lg font-bold text-gray-800 mb-2">{{ $product->name }}</h3>
                                <p class="text-sm text-gray-600 mb-3">{{ $product->description }}</p>

                                <form method="POST" action="{{ route('cart.add', $product->id) }}">
                                    @csrf

                                    @if ($product->type === 'rental')
                                        <div class="mb-2">
                                            <label class="block text-xs text-gray-500">{{ __('messages.start_date') }}</label>
                                            <input type="datetime-local" name="start_date" required
                                                   class="w-full px-3 py-2 border border-gray-300 rounded mb-2 text-sm">
                                            <label class="block text-xs text-gray-500">{{ __('messages.end_date') }}</label>
                                            <input type="datetime-local" name="end_date" required
                                                   class="w-full px-3 py-2 border border-gray-300 rounded mb-3 text-sm">
                                        </div>
                                    @endif

                                    <button type="submit"
                                            class="w-full py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition text-sm font-medium">
                                        {{ __('messages.add_to_cart') }}
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="mt-16 bg-white rounded-2xl shadow p-8">
                <h2 class="text-2xl font-semibold text-gray-900 mb-6">{{ __('messages.product_reviews') }}</h2>
                <div class="space-y-4">
                    @forelse ($reviews as $review)
                        <div class="border p-5 rounded-lg bg-gray-50">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="text-lg font-medium text-gray-800">{{ $review->title }}</h3>
                                <span class="text-sm text-gray-500">{{ __('messages.rating') }}: {{ $review->rating }}/5</span>
                            </div>
                            <p class="text-gray-600">{{ $review->content }}</p>
                        </div>
                    @empty
                        <p class="text-gray-500">{{ __('messages.no_reviews_yet') }}</p>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
@endsection
