<nav class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 py-4 flex items-center justify-between">
        <div class="flex items-center space-x-3">
            <a href="{{ route('home') }}">
                @if(Auth::user()?->business?->logo_path)
                    <img src="{{ Storage::url(Auth::user()->business->logo_path) }}"
                         alt="Company Logo"
                         class="h-10 w-auto object-contain max-w-[140px]">
                @else
                    <x-shared.logo class="h-8 w-auto" />
                @endif
            </a>
        </div>

        <div class="lg:hidden">
            <button id="nav-toggle" class="text-gray-600 focus:outline-none">
                <i class="fa-solid fa-bars text-xl"></i>
            </button>
        </div>

        <div class="hidden lg:flex items-center space-x-6">
            <x-shared.nav-link route="profile.index" icon="fa-house" label="Dashboard" />
            <x-shared.nav-link route="advertisements.index" icon="fa-rectangle-ad" label="Ads" />
            <x-shared.nav-link route="profile.purchaseHistory" icon="fa-receipt" label="Purchases" />
            <x-shared.nav-link route="products.index" icon="fa-cube" label="Products" />
            <x-shared.nav-link route="profile.contract" icon="fa-file-contract" label="Contract" />
            <x-shared.nav-link route="landing.index" icon="fa-rocket" label="Landing" />
        </div>

        <div class="relative ml-4">
            <button id="user-menu-button" type="button"
                    class="flex items-center gap-2 text-sm rounded-full"
                    aria-expanded="false" aria-haspopup="true">
                <img class="w-8 h-8 rounded-full object-cover"
                     src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random&color=fff"
                     alt="Avatar">
                <span class="hidden sm:block text-gray-700 font-medium">{{ Auth::user()->name }}</span>
                <i class="fa-solid fa-caret-down text-xs ml-1 text-gray-500"></i>
            </button>

            <div id="user-dropdown"
                 class="hidden absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg z-20">
                <div class="px-4 py-3 text-sm text-gray-700 border-b border-gray-100">
                    <div class="font-semibold">{{ Auth::user()->name }}</div>
                    <div class="text-gray-500">{{ Auth::user()->email }}</div>
                </div>
                <a href="{{ route('profile.settings') }}"
                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                   <i class="fa-solid fa-palette mr-2"></i> Style settings
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-b-lg">
                        <i class="fa-solid fa-sign-out-alt mr-2"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div id="mobile-nav" class="lg:hidden hidden px-4 pb-4">
        <div class="grid grid-cols-2 gap-4">
            <x-shared.nav-link route="profile.index" icon="fa-house" label="Dashboard" />
            <x-shared.nav-link route="advertisements.index" icon="fa-rectangle-ad" label="Ads" />
            <x-shared.nav-link route="profile.purchaseHistory" icon="fa-receipt" label="Purchases" />
            <x-shared.nav-link route="products.index" icon="fa-cube" label="Products" />
            <x-shared.nav-link route="profile.contract" icon="fa-file-contract" label="Contract" />
            <x-shared.nav-link route="landing.index" icon="fa-rocket" label="Landing" />
        </div>
    </div>
</nav>