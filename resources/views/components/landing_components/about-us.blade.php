@php
    $__inputs = [
        'description' => [
            'label' => __('messages.company_description'),
            'type' => 'textarea',
            'placeholder' => __('messages.company_description_placeholder'),
        ],
    ];
@endphp
<div class="py-10 px-6 flex flex-col md:flex-row items-center">
    <div class="md:w-1/3 mb-6 md:mb-0">
        @if ($logo)
            <img src="{{ is_array($logo) ? ($logo['logo_base64'] ?? '') : $logo }}">
        @else
            {{ __('messages.upload_logo_and_preview') }}
        @endif
    </div>
    <div class="md:ml-8 md:w-2/3">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">{{ __('messages.about_us') }}</h2>
        <p class="text-gray-600 leading-relaxed">{{ $description ?? __('messages.no_description_set') }}</p>
    </div>
</div>
