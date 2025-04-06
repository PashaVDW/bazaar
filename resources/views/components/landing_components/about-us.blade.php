@php
    $__inputs = [
        'description' => [
            'label' => 'Company description',
            'type' => 'textarea',
            'placeholder' => 'Tell us about your company...',
        ],
    ];
@endphp
<div class="py-10 px-6 flex flex-col md:flex-row items-center">
    <div class="md:w-1/3 mb-6 md:mb-0">
        @if ($logo)
            <img src="{{ is_array($logo) ? ($logo['logo_base64'] ?? '') : $logo }}">
        @else
            Upload a logo and uncheck and check checkbox to preview
        @endif
    </div>
    <div class="md:ml-8 md:w-2/3">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">About Us</h2>
        <p class="text-gray-600 leading-relaxed">{{ $description ?? 'No description set yet.' }}</p>
    </div>
</div>
