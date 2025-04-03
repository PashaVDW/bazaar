<x-head />
<div class="flex min-h-screen bg-gray-100">
   <x-admin-sidebar/>
    <main class="flex-1 p-6">
        @yield('content')
    </main>
</div>
<x-end />
