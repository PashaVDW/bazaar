@extends('layouts.profile')

@section('content')
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow">
        <h2 class="text-2xl font-semibold mb-6">Return Product: {{ $reservation->product->name }}</h2>

        <form method="POST" action="{{ route('reservations.return.submit', $reservation) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Upload photo of product</label>
                <input type="file" name="photo" required class="block w-full border border-gray-300 rounded-md shadow-sm file:bg-gray-100 file:border-none file:px-4 file:py-2">
                @error('photo')
                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-6 rounded-md">
                Submit Return
            </button>
        </form>
    </div>
@endsection
