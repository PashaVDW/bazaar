<nav class="px-4 py-3">
    <div class="max-w-7xl mx-auto flex items-center justify-between">
        <div class="flex items-center space-x-3">
            <x-shared.logo class="w-34" />
        </div>

        <form action="" method="GET" class="flex-1 max-w-md mx-6">
            <label for="search" class="sr-only">Search</label>
            <div class="relative">
                <input type="text" name="search" id="search"
                       class="w-full border border-gray-200 rounded-lg pl-10 pr-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="Search for products...">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
            </div>
        </form>

        <div class="hidden md:flex items-center space-x-6">
            <a class="text-gray-700 hover:text-primary">Home</a>
            <a class="text-gray-700 hover:text-primary">Categories</a>
            <a class="text-gray-700 hover:text-primary">Products</a>
            <a class="text-gray-700 hover:text-primary">
                <i class="fas fa-shopping-cart"></i>
            </a>
            @auth


                @role('Super Admin')
                    <a href="{{ route('admin.contracts.index') }}" class="text-gray-700 hover:text-primary">
                        <i class="fas fa-user-shield"></i>
                        <span class="ml-1">Admin</span>
                    </a>
                @elserole('business_advertiser')
                    <a href="{{ route('profile.index')  }}" class="text-gray-700 hover:text-primary">
                        <i class="fas fa-building"></i>
                        <span class="ml-1">Business</span>
                    </a>
                @elserole('private_advertiser')
                    <a href="{{ route('profile.index') }}" class="text-gray-700 hover:text-primary">
                        <i class="fas fa-user"></i>
                        <span class="ml-1">Profile</span>
                    </a>
                @elserole('customer')
                    <a href="{{ route('profile.index') }}" class="text-gray-700 hover:text-primary">
                        <i class="fas fa-box"></i>
                        <span class="ml-1">My Orders</span>
                    </a>
                @endrole

                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-gray-700 hover:text-red-600">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
                <form id="logout-form" method="POST" action="{{ route('logout') }}" class="hidden">
                    @csrf
                </form>


            @else
                <a href="{{ route('login') }}" class="text-gray-700 hover:text-primary">
                    <i class="fas fa-user-circle"></i>
                </a>
            @endauth
        </div>
    </div>
</nav>
