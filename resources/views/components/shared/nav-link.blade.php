@props(['route', 'icon', 'label'])

@php
    $isActive = request()->routeIs($route);
@endphp

<a href="{{ route($route) }}"
   class="flex items-center gap-2 px-2 py-1 text-sm font-medium rounded-md transition {{ $isActive ? 'text-primary font-semibold' : 'text-gray-600 hover:text-primary' }}">
    <i class="fa-solid {{ $icon }}"></i>
    <span>{{ $label }}</span>
</a>
