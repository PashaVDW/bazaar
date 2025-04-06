@props([
    'leftLabel' => 'Active',
    'rightLabel' => 'Archived',
    'leftRoute',
    'rightRoute',
    'switchKey' => 'switch'
])

@php
    $isRightActive = request($switchKey);
@endphp

<div class="flex items-center space-x-4 mb-6">
    <a href="{{ route($leftRoute, array_merge(request()->except($switchKey), [$switchKey => null])) }}"
       class="{{ !$isRightActive ? 'bg-primary text-white' : 'text-gray-500 bg-gray-100 hover:bg-gray-200' }} px-4 py-2 text-sm font-medium rounded-lg transition">
        {{ $leftLabel }}
    </a>

    <a href="{{ route($rightRoute, array_merge(request()->except($switchKey), [$switchKey => true])) }}"
       class="{{ $isRightActive ? 'bg-primary text-white' : 'text-gray-500 bg-gray-100 hover:bg-gray-200' }} px-4 py-2 text-sm font-medium rounded-lg transition">
        {{ $rightLabel }}
    </a>
</div>
