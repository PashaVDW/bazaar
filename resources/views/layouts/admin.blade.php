<!doctype html>
<html lang="en">
    <x-shared.head />
    <body class="font-sans antialiased text-gray-900 bg-gray-100">
        <div class="flex min-h-screen bg-gray-100">
            <x-admin.admin-sidebar/>
            <main class="flex-1 p-6">
                @yield('content')
            </main>
        </div>
    </body>
</html>
