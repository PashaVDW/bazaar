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

    {{-- Slug --}}
    <div class="mb-4">
        <label for="slug" class="block font-medium">Custom URL (slug)</label>
        <input type="text" name="slug" id="slug"
               value="{{ old('slug', $landingPage?->slug) }}"
               class="w-full border rounded p-2 mt-1" placeholder="e.g. company-x">
    </div>

    {{-- Logo --}}
    <div class="mb-4">
        <label for="logo" class="block font-medium">Upload Logo</label>
        <input type="file" name="logo" id="logo" class="w-full mt-1">
        <div class="mt-2" id="logo-preview">
            @if ($landingPage?->logo_path)
                <img src="{{ Storage::url($landingPage->logo_path) }}" class="h-16">
            @endif
        </div>
    </div>

    {{-- Primary Color --}}
    <div class="mb-4">
        <label for="color" class="block font-medium">Primary Color</label>
        <input type="color" name="color" id="color"
               value="{{ old('color', $landingPage->primary_color ?? '#f97316') }}"
               class="w-full h-10">
    </div>

    <h3 class="font-semibold mb-2">Available Components</h3>
    <input type="hidden" name="ordered_components" id="ordered-components">

    <div id="sortable-components" class="space-y-4">
        @foreach ($components as $index => $component)
            @php
                $id = $component->id;
                $selected = $landingPage?->components->contains($component) ?? false;
                $settings = $landingPage?->components->firstWhere('id', $id)?->pivot->settings ?? [];
                $settings = is_string($settings) ? json_decode($settings, true) : ($settings ?: []);
            @endphp

            <div class="component-item bg-white p-4 rounded border" data-id="{{ $id }}">
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
                                      class="w-full border p-2 rounded"
                                      placeholder="{{ $config['placeholder'] ?? '' }}">{{ $settings[$field] ?? '' }}</textarea>
                        @else
                            <input type="{{ $config['type'] ?? 'text' }}"
                                   name="components[{{ $index }}][settings][{{ $field }}]"
                                   class="w-full border p-2 rounded"
                                   placeholder="{{ $config['placeholder'] ?? '' }}"
                                   value="{{ $settings[$field] ?? '' }}">
                        @endif
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    <button type="submit" class="mt-6 bg-primary text-white px-4 py-2 rounded hover:bg-orange-600">
        {{ $method === 'POST' ? 'Create Page' : 'Update Page' }}
    </button>
</form>
