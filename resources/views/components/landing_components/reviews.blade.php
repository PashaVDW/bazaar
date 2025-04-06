<div class="bg-white py-10 px-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Customer Reviews</h2>
    <div class="space-y-4">
        @foreach($reviews as $review)
            <div class="border border-gray-200 rounded p-4">
                <p class="text-gray-600 italic">"{{ $review->message }}"</p>
                <div class="text-sm text-gray-500 mt-2">- {{ $review->author }}, {{ $review->created_at->format('d M Y') }}</div>
            </div>
        @endforeach
    </div>
</div>