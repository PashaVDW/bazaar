@extends('layouts.profile')

@section('title', 'Create Advertisement')

@section('content')
    <div class="w-full max-w-2xl mx-auto px-6 py-10">
        <div class="text-center mb-6">
            <div class="mt-2">
                <h3 class="text-2xl font-semibold">Create Advertisement</h3>
                <p class="text-sm text-gray-500">Fill in the details below to publish your ad or upload a CSV to import multiple ads at once.</p>
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

        <!-- CSV Upload Form -->
        <form method="POST" action="{{ route('advertisements.import') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-5">
                <label for="csv_file" class="block text-sm font-medium text-gray-600">Upload CSV file</label>
                <input type="file" id="csv_file" name="csv_file" accept=".csv" class="w-full p-3 text-sm bg-gray-50 outline-none rounded" required>
            </div>
            <button type="submit" class="w-full py-3 bg-blue-600 hover:bg-blue-700 rounded text-sm font-bold text-white transition">Upload CSV</button>
        </form>

        <div class="my-10">
            <!-- Advertisement Creation Form -->
            <form method="POST" action="{{ route('advertisements.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="mb-5">
                    <input class="w-full p-3 text-sm bg-gray-50 outline-none rounded"
                           type="text"
                           name="title"
                           placeholder="Title"
                           value="{{ old('title') }}"
                           required>
                    @error('title')
                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <textarea class="w-full p-3 text-sm bg-gray-50 outline-none rounded"
                              name="description"
                              placeholder="Description"
                              rows="4"
                              required>{{ old('description') }}</textarea>
                    @error('description')
                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="image" class="flex items-center justify-between w-full p-3 bg-gray-50 rounded cursor-pointer text-sm text-gray-600 hover:bg-gray-100 transition">
                        <span id="file-name">Upload an image</span>
                        <i class="fa-solid fa-upload ml-2"></i>
                    </label>
                    <input type="file"
                           id="image"
                           name="image"
                           accept="image/*"
                           class="hidden"
                           onchange="updateFileName(this)">
                    @error('image')
                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                    @else
                        @if (old('_token'))
                            <p class="text-sm text-yellow-600 mt-2">Please reselect the image</p>
                        @endif
                        @enderror
                </div>

                <div class="mb-5">
                    <input class="w-full p-3 text-sm bg-gray-50 outline-none rounded"
                           type="datetime-local"
                           name="ads_starttime"
                           min="{{ now()->format('Y-m-d\TH:i') }}"
                           max="{{ now()->addMonths(3)->format('Y-m-d\TH:i') }}"
                           value="{{ old('ads_starttime') }}"
                           required>
                    @error('ads_starttime')
                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <input class="w-full p-3 text-sm bg-gray-50 outline-none rounded"
                           type="datetime-local"
                           name="ads_endtime"
                           min="{{ now()->format('Y-m-d\TH:i') }}"
                           max="{{ now()->addMonths(6)->format('Y-m-d\TH:i') }}"
                           value="{{ old('ads_endtime') }}"
                           required>
                    @error('ads_endtime')
                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <select name="product_id" class="w-full p-3 text-sm bg-gray-50 outline-none rounded" required>
                        <option value="" disabled {{ old('product_id') ? '' : 'selected' }}>Select a product</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('product_id')
                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5 flex items-center space-x-2">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox"
                           name="is_active"
                           id="is_active"
                           value="1"
                           class="accent-green-600"
                        {{ old('is_active') ? 'checked' : '' }}>
                    <label for="is_active" class="text-sm text-gray-700">Activate immediately</label>
                    @error('is_active')
                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                        class="w-full py-3 bg-green-600 hover:bg-green-700 rounded text-sm font-bold text-white transition">
                    Create Advertisement
                </button>

                <p class="mt-4 text-sm text-center text-gray-500">
                    <a href="{{ route('advertisements.index') }}" class="text-green-600 hover:underline">← Back to overview</a>
                </p>
            </form>
        </div>

        <script>
            function updateFileName(input) {
                const label = document.getElementById('file-name');
                if (input.files.length > 0) {
                    label.textContent = input.files[0].name;
                } else {
                    label.textContent = 'Upload an image';
                }
            }
        </script>
    </div>
@endsection
