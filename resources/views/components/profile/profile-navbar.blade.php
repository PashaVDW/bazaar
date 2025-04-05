<div class="px-12 py-6 flex items-center gap-x-6 gap-y-2 justify-between">
    <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 bg-gray-50 border border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-100 hover:text-gray-900 transition">
        <i class="fa-solid fa-arrow-left mr-2"></i>
        Back
    </a>

    <div class="flex flex-wrap items-center justify-center gap-x-6 gap-y-2">
        <a href="{{ route('profile.index') }}"
           class="flex items-center gap-2 {{ request()->routeIs('profile.index') ? 'text-primary' : 'text-gray-600 hover:text-primary' }} transition">
            <i class="fa-solid fa-house"></i>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('advertisements.index') }}"
           class="flex items-center gap-2 {{ request()->routeIs('advertisements.index') ? 'text-primary' : 'text-gray-600 hover:text-primary' }} transition">
            <i class="fa-solid fa-rectangle-ad"></i>
            <span>Advertisements</span>
        </a>

        <a href="#" class="flex items-center gap-2 text-gray-600 hover:text-primary transition">
            <i class="fa-solid fa-bookmark"></i>
            <span>Bookings</span>
        </a>

        <a href="{{ route('profile.contract') }}" class="flex items-center gap-2 text-gray-600 hover:text-primary transition">
            <i class="fa-solid fa-file-contract"></i>
            <span>Contract</span>
        </a>

        <a href="{{ route('landing.index')}}" class="flex items-center gap-2 text-gray-600 hover:text-primary transition">
            <i class="fa-solid fa-chart-line"></i>
            <span>Earnings</span>
        </a>

        <a href="#" class="flex items-center gap-2 text-gray-600 hover:text-primary transition">
            <i class="fa-regular fa-star"></i>
            <span>Reviews</span>
        </a>

        <a href="#" class="flex items-center gap-2 text-gray-600 hover:text-primary transition">
            <i class="fa-solid fa-gear"></i>
            <span>Settings</span>
        </a>
    </div>

    <div class="relative group">
        <button class="flex items-center gap-2 text-gray-600 hover:text-primary transition focus:outline-none">
            <p class="text-sm line-clamp-1">{{ Auth::user()->name }}</p>
            <i class="fa-solid fa-caret-down text-xs ml-1"></i>
        </button>
        <div class="absolute hidden group-hover:block bg-white border-grey-400 shadow-md rounded-md mt-2 p-2 min-w-[160px]">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded">
                    Logout
                </button>
            </form>
        </div>
    </div>
</div>
