@extends('layouts.profile')

@section('content')
    <div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
        <h2 class="text-xl font-semibold mb-4">Review Return Request</h2>

        <div class="mb-6">
            <p class="text-gray-700 font-medium mb-2">Return Photo:</p>
            <img src="{{ asset('storage/' . $reservation->returnRequest->photo_path) }}" alt="Return photo" class="w-full max-w-sm rounded border">
        </div>

        <form method="POST" action="{{ route('return.finalize', $reservation->id) }}">
            @csrf
            <div class="mb-4">
                <label for="wear_percentage" class="block text-gray-700 font-medium mb-1">Wear Percentage</label>
                <input type="number" name="wear_percentage" id="wear_percentage" step="0.1" min="0" max="100"
                       class="w-full px-4 py-2 border rounded focus:outline-none focus:ring"
                       required>
            </div>

            <div class="mt-6">
                <button type="submit"
                        class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded">
                    Finalize Return
                </button>
            </div>
        </form>
    </div>
@endsection
