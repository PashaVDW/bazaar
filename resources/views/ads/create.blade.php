@extends('layouts.profile')

@section('title', __('messages.create_advertisement'))

@section('content')
    <div class="w-full max-w-2xl mx-auto px-6 py-10">
        <div class="text-center mb-6">
            <h3 class="text-2xl font-semibold">{{ __('messages.create_advertisement') }}</h3>
            <p class="text-sm text-gray-500">{{ __('messages.create_advertisement_subtext') }}</p>
        </div>

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 text-red-600 rounded text-sm">
                <strong>{{ __('messages.errors') }}</strong>
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('advertisements.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-5">
                <input class="w-full p-3 text-sm bg-gray-50 outline-none rounded"
                       type="text"
                       name="title"
                       placeholder="{{ __('messages.title') }}"
                       value="{{ old('title') }}"
                       required>
                @error('title')
                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <textarea class="w-full p-3 text-sm bg-gray-50 outline-none rounded"
                          name="description"
                          placeholder="{{ __('messages.description') }}"
                          rows="4"
                          required>{{ old('description') }}</textarea>
                @error('description')
                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label for="image" class="flex items-center justify-between w-full p-3 bg-gray-50 rounded cursor-pointer text-sm text-gray-600 hover:bg-gray-100 transition">
                    <span id="file-name">{{ __('messages.upload_image') }}</span>
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
                        <p class="text-sm text-yellow-600 mt-2">{{ __('messages.please_reselect_image') }}</p>
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
                <label class="block mb-2 text-sm font-medium text-gray-700">{{ __('messages.main_product') }}</label>
                <select name="main_product_id" class="w-full p-3 text-sm bg-gray-50 outline-none rounded" required>
                    <option value="" disabled {{ old('main_product_id') ? '' : 'selected' }}>{{ __('messages.select_a_product') }}</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}" {{ old('main_product_id') == $product->id ? 'selected' : '' }}>
                            {{ $product->name }}
                        </option>
                    @endforeach
                </select>
                @error('main_product_id')
                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label class="block mb-2 text-sm font-medium text-gray-700">{{ __('messages.sub_products_optional') }}</label>
                <select name="sub_product_ids[]" multiple
                        class="w-full p-3 text-sm bg-gray-50 outline-none rounded h-40 overflow-y-auto">
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}"
                            {{ (collect(old('sub_product_ids'))->contains($product->id)) ? 'selected' : '' }}>
                            {{ $product->name }}
                        </option>
                    @endforeach
                </select>
                @error('sub_product_ids')
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
                <label for="is_active" class="text-sm text-gray-700">{{ __('messages.activate_immediately') }}</label>
                @error('is_active')
                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                    class="w-full py-3 bg-green-600 hover:bg-green-700 rounded text-sm font-bold text-white transition">
                {{ __('messages.create') }}
            </button>

            <p class="mt-4 text-sm text-center text-gray-500">
                <a href="{{ route('advertisements.index') }}" class="text-green-600 hover:underline">{{ __('messages.back_to_overview') }}</a>
            </p>
        </form>
    </div>

    <script>
        function updateFileName(input) {
            const label = document.getElementById('file-name');
            if (input.files.length > 0) {
                label.textContent = input.files[0].name;
            } else {
                label.textContent = '{{ __('messages.upload_image') }}';
            }
        }
    </script>
@endsection
