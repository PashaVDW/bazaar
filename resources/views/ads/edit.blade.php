@extends('layouts.profile')

@section('title', __('messages.edit_advertisement'))

@section('content')
    <div class="w-full max-w-2xl mx-auto px-6 py-10">
        <div class="text-center mb-6">
            <div class="mt-2">
                <h3 class="text-2xl font-semibold">{{ __('messages.edit_advertisement') }}</h3>
                <p class="text-sm text-gray-500">{{ __('messages.update_your_advertisement_below') }}</p>
            </div>
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

        <form method="POST" action="{{ route('advertisements.update', $ad->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-5">
                <input class="w-full p-3 text-sm bg-gray-50 outline-none rounded"
                       type="text"
                       name="title"
                       placeholder="{{ __('messages.title') }}"
                       value="{{ old('title', $ad->title) }}"
                       required>
            </div>

            <div class="mb-5">
                <textarea class="w-full p-3 text-sm bg-gray-50 outline-none rounded"
                          name="description"
                          placeholder="{{ __('messages.description') }}"
                          rows="4"
                          required>{{ old('description', $ad->description) }}</textarea>
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
                <p class="text-xs text-gray-400 mt-2">{{ __('messages.current_image') }}</p>
                <img src="{{ asset('storage/' . $ad->image) }}" alt="Current ad image" class="w-32 mt-2 rounded shadow">
            </div>

            <div class="mb-5">
                <input class="w-full p-3 text-sm bg-gray-50 outline-none rounded"
                       type="datetime-local"
                       name="ads_starttime"
                       value="{{ old('ads_starttime', \Carbon\Carbon::parse($ad->ads_starttime)->format('Y-m-d\TH:i')) }}"
                       min="{{ old('ads_starttime', \Carbon\Carbon::parse($ad->ads_starttime)->format('Y-m-d\TH:i')) }}"
                       max="{{ old('ads_starttime', \Carbon\Carbon::parse($ad->ads_starttime)->addMonths(3)->format('Y-m-d\TH:i')) }}"
                       required>
            </div>

            <div class="mb-5">
                <input class="w-full p-3 text-sm bg-gray-50 outline-none rounded"
                       type="datetime-local"
                       name="ads_endtime"
                       value="{{ old('ads_endtime', \Carbon\Carbon::parse($ad->ads_endtime)->format('Y-m-d\TH:i')) }}"
                       min="{{ old('ads_endtime', \Carbon\Carbon::parse($ad->ads_starttime)->format('Y-m-d\TH:i')) }}"
                       max="{{ old('ads_endtime', \Carbon\Carbon::parse($ad->ads_endtime)->addMonths(6)->format('Y-m-d\TH:i')) }}"
                       required>
            </div>

            <div class="mb-5">
                <select name="product_id" class="w-full p-3 text-sm bg-gray-50 outline-none rounded" required>
                    <option value="" disabled {{ old('product_id') ? '' : 'selected' }}>{{ __('messages.select_a_product') }}</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}" {{ old('product_id', $ad->product->id ?? '') == $product->id ? 'selected' : '' }}>
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
                    {{ old('is_active', $ad->is_active) ? 'checked' : '' }}>
                <label for="is_active" class="text-sm text-gray-700">{{ __('messages.activate_immediately') }}</label>
            </div>

            <button type="submit"
                    class="w-full py-3 bg-purple-600 hover:bg-purple-700 rounded text-sm font-bold text-white transition">
                {{ __('messages.update_advertisement') }}
            </button>

            <p class="mt-4 text-sm text-center text-gray-500">
                <a href="{{ route('advertisements.index') }}" class="text-purple-600 hover:underline">← {{ __('messages.back_to_overview') }}</a>
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
