<nav class="bg-white border-b border-gray-100 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 lg:px-8 py-4 flex flex-wrap items-center justify-between gap-4">
        
        {{-- Logo --}}
        <div class="flex items-center space-x-3">
            <a href="/" class="flex items-center">
                <x-shared.logo class="w-28 sm:w-36" />
            </a>
        </div>

        {{-- Searchbar --}}
        <div class="w-full md:flex-1 md:max-w-md">
            <form action="" method="GET">
                <div class="relative">
                    <input type="text" name="search" id="search"
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-xl shadow-sm text-sm focus:outline-none focus:ring-2 focus:ring-primary"
                        placeholder="Search products..." />
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                </div>
            </form>
        </div>

        {{-- Navigation Links --}}
        <div class="hidden lg:flex items-center space-x-6 text-sm text-gray-700">
            <a href="#" class="hover:text-primary transition">Home</a>
            <a href="#" class="hover:text-primary transition">Categories</a>
            <a href="#" class="hover:text-primary transition">Products</a>
            <a href="{{ route('cart.index') }}" class="hover:text-primary transition relative">
                <i class="fas fa-shopping-cart text-lg"></i>
            </a>
        </div>

        {{-- User Section --}}
        <div class="flex items-center gap-4">
            @auth
                @role('Super Admin')
                    <a href="{{ route('admin.contracts.index') }}"
                       class="px-3 py-1 text-sm border border-gray-300 rounded-md hover:bg-gray-50 transition flex items-center gap-1">
                        <i class="fas fa-user-shield text-xs"></i>
                        Admin
                    </a>
                @elserole('business_advertiser')
                    <a href="{{ route('profile.index') }}"
                       class="px-3 py-1 text-sm border border-gray-300 rounded-md hover:bg-gray-50 transition flex items-center gap-1">
                        <i class="fas fa-building text-xs"></i>
                        Business
                    </a>
                @elserole('private_advertiser')
                    <a href="{{ route('profile.index') }}"
                       class="px-3 py-1 text-sm border border-gray-300 rounded-md hover:bg-gray-50 transition flex items-center gap-1">
                        <i class="fas fa-user text-xs"></i>
                        Profile
                    </a>
                @elserole('customer')
                    <a href="{{ route('profile.index') }}"
                       class="px-3 py-1 text-sm border border-gray-300 rounded-md hover:bg-gray-50 transition flex items-center gap-1">
                        <i class="fas fa-box text-xs"></i>
                        Orders
                    </a>
                @endrole

                {{-- Logout --}}
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                   class="text-gray-600 hover:text-red-600 transition" title="Logout">
                    <i class="fas fa-sign-out-alt text-lg"></i>
                </a>
                <form id="logout-form" method="POST" action="{{ route('logout') }}" class="hidden">@csrf</form>
            @else
                <a href="{{ route('login') }}" class="text-gray-600 hover:text-primary transition">
                    <i class="fas fa-user-circle text-xl"></i>
                </a>
            @endauth
        </div>
    </div>
</nav>
