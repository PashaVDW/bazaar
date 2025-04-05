<div class="bg-white py-10 px-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Our Offers</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($ads->take(4) as $ad)
            <div class="bg-gray-100 p-4 rounded-lg">
                <img src="{{ Storage::url($ad->image) }}" alt="{{ $ad->title }}" class="w-full h-40 object-cover rounded">
                <h3 class="text-lg font-semibold mt-2">{{ $ad->title }}</h3>
                <p class="text-sm text-gray-600">{{ Str::limit($ad->description, 80) }}</p>
                <p class="text-orange-600 font-semibold mt-2">€{{ number_format($ad->hourly_price, 2) }} / hour</p>
            </div>
        @endforeach
    </div>
</div>