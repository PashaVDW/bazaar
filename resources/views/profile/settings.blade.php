@extends('layouts.profile')

@section('content')
<div class="max-w-4xl mx-auto mt-12">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Customize Look & Feel</h1>

    @if (session('success'))
        <x-shared.toast type="success" :message="session('success')" />
    @endif

    <form id="settings-form" action="{{ route('profile.settings.update') }}" method="POST" enctype="multipart/form-data"
          class="bg-white rounded-2xl shadow p-8 space-y-10">
        @csrf
        @method('PUT')

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Company Logo</label>

            <label id="logo-dropzone"
                for="logo"
                class="relative flex flex-col items-center justify-center border-2 border-dashed border-gray-300 rounded-xl p-8 cursor-pointer hover:bg-gray-50 transition text-center bg-white shadow-sm">
                <img id="logo-preview" src="{{ $business->logo_path ? Storage::url($business->logo_path) : '' }}"
                    class="hidden h-24 mx-auto object-contain rounded border border-gray-200 mb-2"
                    alt="Preview" />

                <span id="logo-placeholder" class="text-gray-500 text-sm {{ $business->logo_path ? 'hidden' : '' }}">
                    Drop your logo or click to upload
                </span>

                <input type="file" id="logo" name="logo" class="hidden" accept="image/*">
            </label>

            <p id="logo-filename" class="text-sm text-gray-600 mt-2 text-center hidden">
                Selected: <span class="font-medium text-gray-800"></span>
            </p>
        </div>


        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Primary Color</label>
            @php
                $colors = ['#F97316', '#3B82F6', '#10B981', '#EF4444', '#8B5CF6'];
                $selected = old('primary_color', $business->primary_color ?? '#F97316');
            @endphp
            <div class="flex gap-4">
                @foreach ($colors as $color)
                    <label class="relative">
                        <input type="radio" name="primary_color" value="{{ $color }}"
                            class="sr-only peer" {{ $color === $selected ? 'checked' : '' }}>
                        <div class="w-10 h-10 rounded-full border-2 border-gray-300 shadow-inner cursor-pointer transition
                            peer-checked:ring-4 peer-checked:ring-offset-2 peer-checked:ring-primary"
                            style="background-color: {{ $color }}"></div>
                    </label>
                @endforeach
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-4">Font</label>
            @php
                $fonts = [
                    'Instrument Sans' => 'The quick brown fox jumps over the lazy dog',
                    'Inter' => 'The quick brown fox jumps over the lazy dog',
                    'Poppins' => 'The quick brown fox jumps over the lazy dog',
                    'Roboto' => 'The quick brown fox jumps over the lazy dog',
                    'Open Sans' => 'The quick brown fox jumps over the lazy dog',
                ];
                $selectedFont = old('font_family', $business->font_family ?? 'Instrument Sans');
            @endphp
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                @foreach ($fonts as $font => $example)
                    <label class="block cursor-pointer">
                        <input type="radio" name="font_family" value="{{ $font }}" class="sr-only peer"
                            {{ $font === $selectedFont ? 'checked' : '' }}>
                        <div class="rounded-xl border border-gray-200 px-5 py-6 bg-white shadow-sm hover:shadow-md transition
                                    peer-checked:ring-2 peer-checked:ring-primary peer-checked:bg-primary/10"
                            style="font-family: '{{ $font }}', sans-serif">
                            <span class="text-base md:text-lg block text-gray-800">{{ $font }}</span>
                            <p class="mt-2 text-sm md:text-base text-gray-600">{{ $example }}</p>
                        </div>
                    </label>
                @endforeach
            </div>
        </div>


        <div id="preview" class="rounded-xl border border-gray-200 p-6 bg-gray-50 shadow-inner transition-all">
            <h2 class="text-xl font-bold mb-2">Live Preview</h2>
            <div class="h-2 w-32 rounded-full mb-4" id="preview-color" style="background-color: {{ $selected }}"></div>
            <p id="preview-text" class="text-gray-700" style="font-family: '{{ $selectedFont }}', sans-serif">Your style will look like this.</p>
        </div>

        <div class="pt-2">
            <button type="submit"
                    class="inline-flex items-center px-6 py-3 bg-primary text-white text-sm font-medium rounded-lg shadow hover:bg-primary/80 transition">
                <i class="fa-solid fa-floppy-disk mr-2"></i> Save Settings
            </button>
        </div>
    </form>
</div>
@endsection
   