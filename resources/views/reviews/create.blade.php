@extends('layouts.profile')

@section('title', __('write_a_review'))

@section('content')
    <div class="w-full max-w-2xl mx-auto px-6 py-10"
         x-data="reviewSelect({{ json_encode([
            'product' => isset($productReview),
            'advertiser' => isset($advertiserReview)
         ]) }})">
        <div class="text-center mb-6">
            <h3 class="text-2xl font-semibold">{{ __('write_a_review') }}</h3>
            <p class="text-sm text-gray-500">
                {{ __('choose_who_to_review') }} <strong>{{ $product->name }}</strong> {{ __('and_or_the_advertiser') }}
            </p>
        </div>

        <form method="POST" action="{{ route('review.store') }}">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="advertiser_id" value="{{ $product->user_id }}">

            <div class="mb-5">
                <label class="block mb-2 text-sm font-medium text-gray-700">{{ __('review_target') }}</label>
                <div class="relative">
                    <button type="button" @click="open = !open"
                            class="relative w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                        <span x-text="selectedLabels().join(', ') || '{{ __('select') }}'" class="truncate block"></span>
                        <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.25a.75.75 0 01-1.06 0L5.23 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    </button>

                    <div x-show="open" @click.outside="open = false"
                         class="absolute z-10 mt-1 w-full bg-white border border-gray-200 rounded-md shadow-lg max-h-60 overflow-auto focus:outline-none text-sm">
                        <label class="block px-4 py-2 hover:bg-gray-50 cursor-pointer">
                            <input type="checkbox" value="product" name="review_type[]" x-model="selected" class="mr-2"> Product
                        </label>
                        <label class="block px-4 py-2 hover:bg-gray-50 cursor-pointer">
                            <input type="checkbox" value="advertiser" name="review_type[]" x-model="selected" class="mr-2"> Advertiser
                        </label>
                    </div>
                </div>
                @error('review_type')
                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <input class="w-full p-3 text-sm bg-gray-50 outline-none rounded"
                       type="text"
                       name="title"
                       placeholder="{{ __('review_title') }}"
                       value="{{ old('title', $productReview->title ?? $advertiserReview->title ?? '') }}"
                       required>
                @error('title')
                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <textarea class="w-full p-3 text-sm bg-gray-50 outline-none rounded"
                          name="content"
                          placeholder="{{ __('your_review') }}"
                          rows="5"
                          required>{{ old('content', $productReview->content ?? $advertiserReview->content ?? '') }}</textarea>
                @error('content')
                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <div class="flex flex-row-reverse justify-end items-center space-x-reverse space-x-1">
                    @for ($i = 5; $i >= 1; $i--)
                        <input id="rating-{{ $i }}" type="radio" name="rating" value="{{ $i }}"
                               class="peer hidden"
                            {{ old('rating', $productReview->rating ?? $advertiserReview->rating ?? '') == $i ? 'checked' : '' }}>
                        <label for="rating-{{ $i }}" class="text-gray-300 peer-checked:text-yellow-400 cursor-pointer">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.946a1 1 0 00.95.69h4.15c.969 0 1.371 1.24.588 1.81l-3.36 2.44a1 1 0 00-.364 1.118l1.287 3.946c.3.921-.755 1.688-1.54 1.118l-3.36-2.44a1 1 0 00-1.176 0l-3.36 2.44c-.784.57-1.838-.197-1.539-1.118l1.287-3.946a1 1 0 00-.364-1.118l-3.36-2.44c-.783-.57-.38-1.81.588-1.81h4.15a1 1 0 00.95-.69l1.286-3.946z" />
                            </svg>
                        </label>
                    @endfor
                </div>
                @error('rating')
                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                    class="w-full py-3 bg-green-600 hover:bg-green-700 rounded text-sm font-bold text-white transition">
                {{ __('submit_review') }}
            </button>

            <p class="mt-4 text-sm text-center text-gray-500">
                <a href="{{ route('profile.purchaseHistory') }}" class="text-green-600 hover:underline">&larr; {{ __('back_to_history') }}</a>
            </p>
        </form>
    </div>

    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        function reviewSelect(existing) {
            return {
                open: false,
                selected: [
                    ...(existing.product ? ['product'] : []),
                    ...(existing.advertiser ? ['advertiser'] : []),
                ],
                selectedLabels() {
                    return this.selected.map(val => val.charAt(0).toUpperCase() + val.slice(1));
                }
            }
        }
    </script>
@endsection
