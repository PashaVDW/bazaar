 <aside class="w-64 bg-white shadow-md hidden md:block">
        <div class="p-4">
            <x-logo />
        </div>
        <nav class="p-4 space-y-2 text-gray-700">
            <a href="#" class="flex items-center space-x-2 px-4 py-2 rounded hover:bg-gray-100">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('admin.contracts.index') }}" class="flex items-center space-x-2 px-4 py-2 rounded hover:bg-gray-100">
                <i class="fas fa-file-contract"></i>
                <span>Contracts</span>
            </a>
            <a href="#" class="flex items-center space-x-2 px-4 py-2 rounded hover:bg-gray-100">
                <i class="fas fa-users"></i>
                <span>Users</span>
            </a>

            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="flex items-center space-x-2 px-4 py-2 rounded text-red-600 hover:bg-red-100">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
            <form id="logout-form" method="POST" action="{{ route('logout') }}" class="hidden">
                @csrf
            </form>

        </nav>
    </aside>
