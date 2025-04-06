@extends('layouts.profile')

@section('title', __('messages.edit_product'))

@section('content')
    <div class="w-full max-w-2xl mx-auto px-6 py-10">
        <div class="text-center mb-6">
            <div class="mt-2">
                <h3 class="text-2xl font-semibold">{{ __('messages.edit_product') }}</h3>
                <p class="text-sm text-gray-500">{{ __('messages.update_your_product_below') }}</p>
            </div>
        </div>

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 text-red-600 rounded text-sm">
                <strong>{{ __('messages.errors') }}:</strong>
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-5">
                <input class="w-full p-3 text-sm bg-gray-50 outline-none rounded"
                       type="text"
                       name="name"
                       placeholder="{{ __('messages.product_name') }}"
                       value="{{ old('name', $product->name) }}"
                       required>
                @error('name')
                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <textarea class="w-full p-3 text-sm bg-gray-50 outline-none rounded"
                          name="description"
                          placeholder="{{ __('messages.description') }}"
                          rows="4"
                          required>{{ old('description', $product->description) }}</textarea>
                @error('description')
                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label for="image"
                       class="flex items-center justify-between w-full p-3 bg-gray-50 rounded cursor-pointer text-sm text-gray-600 hover:bg-gray-100 transition">
                    <span id="file-name">{{ __('messages.change_image_optional') }}</span>
                    <i class="fa-solid fa-upload ml-2"></i>
                </label>
                <input type="file"
                       id="image"
                       name="image"
                       accept="image/*"
                       class="hidden"
                       onchange="updateFileName(this)">
                @if ($product->image)
                    <p class="text-xs text-gray-400 mt-2">{{ __('messages.current_image') }}</p>
                    <img src="{{ asset('storage/' . $product->image) }}" alt="Current product image" class="w-32 mt-2 rounded shadow">
                @endif
                @error('image')
                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <input class="w-full p-3 text-sm bg-gray-50 outline-none rounded"
                       type="number"
                       step="0.01"
                       min="0"
                       name="price"
                       placeholder="{{ __('messages.price') }}"
                       value="{{ old('price', $product->price) }}"
                       required>
                @error('price')
                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <input class="w-full p-3 text-sm bg-gray-50 outline-none rounded"
                       type="number"
                       min="0"
                       name="stock"
                       placeholder="{{ __('messages.stock_quantity') }}"
                       value="{{ old('stock', $product->stock) }}"
                       required>
                @error('stock')
                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <select name="type" class="w-full p-3 text-sm bg-gray-50 outline-none rounded" required>
                    <option value="" disabled {{ old('type', $product->type) ? '' : 'selected' }}>{{ __('messages.select_type') }}</option>
                    <option value="sale" {{ old('type', $product->type) === 'sale' ? 'selected' : '' }}>{{ __('messages.sale') }}</option>
                    <option value="rental" {{ old('type', $product->type) === 'rental' ? 'selected' : '' }}>{{ __('messages.rental') }}</option>
                    <option value="auction" {{ old('type', $product->type) === 'auction' ? 'selected' : '' }}>{{ __('messages.auction') }}</option>
                </select>
                @error('type')
                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <select name="ad_id" class="w-full p-3 text-sm bg-gray-50 outline-none rounded">
                    <option value="" {{ old('ad_id', $product->ad_id) ? '' : 'selected' }}>{{ __('messages.select_an_advertisement_optional') }}</option>
                    @foreach ($ads as $ad)
                        <option value="{{ $ad->id }}" {{ old('ad_id', $product->ad_id) == $ad->id ? 'selected' : '' }}>
                            {{ $ad->title }}
                        </option>
                    @endforeach
                </select>
                @error('ad_id')
                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                    class="w-full py-3 bg-green-600 hover:bg-green-700 rounded text-sm font-bold text-white transition">
                {{ __('messages.update_product') }}
            </button>

            <p class="mt-4 text-sm text-center text-gray-500">
                <a href="{{ route('products.index') }}" class="text-green-600 hover:underline">{{ __('messages.back_to_overview') }}</a>
            </p>
        </form>
    </div>

    <script>
        function updateFileName(input) {
            const label = document.getElementById('file-name');
            if (input.files.length > 0) {
                label.textContent = input.files[0].name;
            } else {
                label.textContent = '{{ __('messages.change_image_optional') }}';
            }
        }
    </script>
@endsection
