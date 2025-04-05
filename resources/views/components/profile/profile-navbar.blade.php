<nav class="bg-white shadow-sm text-center">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 py-4 flex items-center justify-between">
        {{-- Left section --}}
        <div class="flex items-center space-x-4">
            <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition">
                <i class="fa-solid fa-arrow-left mr-2"></i>
                Back
            </a>
        </div>

        <div class="lg:hidden">
            <button id="nav-toggle" class="text-gray-600 focus:outline-none">
                <i class="fa-solid fa-bars text-xl"></i>
            </button>
        </div>

        <div class="hidden lg:flex items-center space-x-6">
            <x-shared.nav-link route="profile.index" icon="fa-house" label="Dashboard" />
            <x-shared.nav-link route="advertisements.index" icon="fa-rectangle-ad" label="Advertisements" />
            <x-shared.nav-link route="profile.purchaseHistory" icon="fa-receipt" label="Purchases" />
            <x-shared.nav-link route="profile.contract" icon="fa-file-contract" label="Contract" />
            <x-shared.nav-link route="landing.index" icon="fa-rocket" label="Landing" />
        </div>

      <div class="relative ml-4">
        <button id="user-menu-button" type="button"
            class="flex items-center gap-2 text-sm rounded-full"
            aria-expanded="false" aria-haspopup="true">
            <img class="w-8 h-8 rounded-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random&color=fff" alt="Avatar">
            <span class="hidden sm:block text-gray-700 font-medium">{{ Auth::user()->name }}</span>
            <i class="fa-solid fa-caret-down text-xs ml-1 text-gray-500"></i>
        </button>

    <div id="user-dropdown"
        class="hidden absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg z-20">
        <div class="px-4 py-3 text-sm text-gray-700 border-b border-gray-100">
            <div class="font-semibold">{{ Auth::user()->name }}</div>
            <div class="text-gray-500">{{ Auth::user()->email }}</div>
        </div>
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

    {{-- Mobile menu --}}
    <div id="mobile-nav" class="lg:hidden hidden px-4 pb-4">
        <div class="grid grid-cols-2 gap-4">
            <x-shared.nav-link route="profile.index" icon="fa-house" label="Dashboard" />
            <x-shared.nav-link route="advertisements.index" icon="fa-rectangle-ad" label="Ads" />
            <x-shared.nav-link route="profile.purchaseHistory" icon="fa-receipt" label="Purchases" />
            <x-shared.nav-link route="profile.contract" icon="fa-file-contract" label="Contract" />
            <x-shared.nav-link route="landing.index" icon="fa-rocket" label="Landing" />
        </div>
    </div>
</nav>
<script>
    document.getElementById('nav-toggle')?.addEventListener('click', () => {
        const mobileNav = document.getElementById('mobile-nav');
        mobileNav.classList.toggle('hidden');
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const btn = document.getElementById('user-menu-button');
        const dropdown = document.getElementById('user-dropdown');

        if (btn && dropdown) {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                dropdown.classList.toggle('hidden');
            });

            document.addEventListener('click', (e) => {
                if (!dropdown.contains(e.target)) {
                    dropdown.classList.add('hidden');
                }
            });
        }
    });
</script>
