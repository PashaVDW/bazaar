@props([
    'action',
    'method' => 'POST',
    'landingPage' => null,
    'components',
    'componentInputDefinitions' => [],
])

<form id="component-form" action="{{ $action }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <strong class="font-bold">{{ __('messages.whoops') }}</strong>
            <span class="block">{{ __('messages.problems_with_input') }}</span>
        </div>
    @endif

    <div class="mb-4">
        <label for="slug" class="block font-medium">{{ __('messages.custom_url') }}</label>
        <input type="text" name="slug" id="slug"
               value="{{ old('slug', $landingPage?->slug) }}"
               class="w-full border {{ $errors->has('slug') ? 'border-red-500' : 'border-gray-300' }} rounded p-2 mt-1"
               placeholder="{{ __('messages.example_slug') }}">
        <span class="text-sm text-gray-500">{{ __('messages.slug_description') }}</span>
        @error('slug')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-4">
        <label for="logo" class="block font-medium">{{ __('messages.upload_logo') }}</label>
        <input type="file" name="logo" id="logo"
               class="w-full mt-1 rounded p-2 {{ $errors->has('logo') ? 'border-red-500' : '' }}"
               accept="image/*">
        <div class="mt-2" id="logo-preview">
            @if ($landingPage?->logo_path)
                <img src="{{ Storage::url($landingPage->logo_path) }}" class="h-16">
            @endif
        </div>
        @error('logo')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-4">
        <label for="color" class="block font-medium">{{ __('messages.primary_color') }}</label>
        <input type="color" name="color" id="color"
               value="{{ old('color', $landingPage->primary_color ?? '#f97316') }}"
               class="w-full h-10 {{ $errors->has('color') ? 'border-red-500' : 'border-gray-300' }}">
        @error('color')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <h3 class="font-semibold mb-2">{{ __('messages.available_components') }}</h3>
    <p class="text-sm text-gray-500 mb-4">{{ __('messages.select_components') }}</p>

    <input type="hidden" name="ordered_components" id="ordered-components">

    <div id="sortable-components" class="space-y-4">
        @foreach ($components as $index => $component)
            @php
                $id = $component->id;
                $selected = $landingPage?->components->contains($component) ?? false;
                $settings = $landingPage?->components->firstWhere('id', $id)?->pivot->settings ?? [];
                $settings = is_string($settings) ? json_decode($settings, true) : ($settings ?: []);
            @endphp

            <div class="component-item bg-white p-4 rounded" data-id="{{ $id }}">
                <label class="flex items-center mb-2">
                    <input type="checkbox"
                           name="components[{{ $index }}][id]"
                           value="{{ $id }}"
                           class="mr-2 component-toggle"
                           data-component-id="{{ $id }}"
                        {{ $selected ? 'checked' : '' }}>
                    <span class="font-medium">{{ $component->name }}</span>
                </label>

                <div class="component-inputs {{ $selected ? '' : 'hidden' }}" id="inputs-{{ $id }}">
                    @foreach ($componentInputDefinitions[$id] ?? [] as $field => $config)
                        <label class="block font-medium mt-2">{{ $config['label'] ?? ucfirst($field) }}</label>

                        @if (($config['type'] ?? 'text') === 'textarea')
                            <textarea name="components[{{ $index }}][settings][{{ $field }}]"
                                      class="w-full border border-gray-300 p-2 rounded"
                                      placeholder="{{ $config['placeholder'] ?? '' }}">{{ $settings[$field] ?? '' }}</textarea>
                        @else
                            <input type="{{ $config['type'] ?? 'text' }}"
                                   name="components[{{ $index }}][settings][{{ $field }}]"
                                   class="w-full border border-gray-300 p-2 rounded"
                                   placeholder="{{ $config['placeholder'] ?? '' }}"
                                   value="{{ $settings[$field] ?? '' }}">
                        @endif
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    <button type="submit" class="mt-6 bg-primary text-white px-4 py-2 rounded hover:bg-orange-600">
        {{ $method === 'POST' ? __('messages.create_page') : __('messages.update_page') }}
    </button>
</form>
