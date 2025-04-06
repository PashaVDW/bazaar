<!doctype html>
<html lang="en">
    <x-shared.head />
    <body class="font-sans antialiased bg-gray-100 text-gray-900">
        <div class="flex min-h-screen">
            <x-admin.admin-sidebar />
            <main class="flex-1 p-6 bg-gray-50">
                @yield('content')
            </main>
        </div>
    </body>
</html>
