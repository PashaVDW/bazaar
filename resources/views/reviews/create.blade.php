@extends('layouts.profile')

@section('title', 'Write a Review')

@section('content')
    <div class="w-full max-w-2xl mx-auto px-6 py-10">
        <div class="text-center mb-6">
            <div class="mt-2">
                <h3 class="text-2xl font-semibold">Write a Review</h3>
                <p class="text-sm text-gray-500">Leave a review for <strong>{{ $ad->title }}</strong></p>
            </div>
        </div>

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 text-red-600 rounded text-sm">
                <strong>Error(s):</strong>
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('review.store') }}">
            @csrf

            <input type="hidden" name="ad_id" value="{{ $ad->id }}">

            <div class="mb-5">
                <input class="w-full p-3 text-sm bg-gray-50 outline-none rounded"
                       type="text"
                       name="title"
                       placeholder="Review title"
                       value="{{ old('title', $review->title ?? '') }}"
                       required>
                @error('title')
                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <textarea class="w-full p-3 text-sm bg-gray-50 outline-none rounded"
                          name="content"
                          placeholder="Your review..."
                          rows="5"
                          required>{{ old('content', $review->content ?? '') }}</textarea>
                @error('content')
                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <div class="flex flex-row-reverse justify-end items-center space-x-reverse space-x-1">
                    @for ($i = 5; $i >= 1; $i--)
                        <input id="rating-{{ $i }}" type="radio" name="rating" value="{{ $i }}"
                               class="peer hidden" {{ old('rating', $review->rating ?? '') == $i ? 'checked' : '' }}>
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
                Submit Review
            </button>

            <p class="mt-4 text-sm text-center text-gray-500">
                <a href="{{ route('profile.purchaseHistory') }}" class="text-green-600 hover:underline">&larr; Back to history</a>
            </p>
        </form>
    </div>
@endsection
