<!doctype html>
<html lang="en">
    <x-shared.head />
    @php
        $primaryColor = Auth::check() && Auth::user()->business?->primary_color
            ? Auth::user()->business->primary_color
            : '#F97316';
    @endphp
    <style>
        :root {
            --tw-color-primary: {{ $primaryColor }};
            --tw-font-sans: '{{ $business->font_family ?? 'Instrument Sans' }}', ui-sans-serif, system-ui, sans-serif;
            }
    </style>

    <body class="font-sans antialiased text-gray-900 bg-gray-100">
            <x-profile.profile-navbar />
             @yield('content')
    </body>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans&family=Inter&family=Poppins&family=Roboto&family=Open+Sans&display=swap" rel="stylesheet">

</html>

