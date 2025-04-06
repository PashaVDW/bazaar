<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'De Bazaar')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://kit.fontawesome.com/bb073b0d89.js" crossorigin="anonymous"></script>
</head>
