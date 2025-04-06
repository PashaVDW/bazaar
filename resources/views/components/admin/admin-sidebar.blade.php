<aside class="w-64 bg-white shadow-md border-r border-gray-200 hidden md:flex flex-col justify-between">
    <div>
        <div class="p-6 border-b border-gray-100">
            <x-shared.logo class="w-32" />
        </div>

        <nav class="p-4 space-y-2 text-sm font-medium text-gray-700">
            <x-shared.nav-link route="admin.contracts.index" icon="fa-file-contract" :label="__('messages.contracts')" />
        </nav>
    </div>
    <div class="p-4 border-t border-gray-100">
        <div class="flex items-center gap-3">
            <img class="w-10 h-10 rounded-full object-cover"
                 src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random&color=fff"
                 alt="Avatar">
            <div class="flex-1">
                <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button title="{{ __('messages.logout') }}"
                        class="text-gray-500 hover:text-red-500 transition">
                    <i class="fas fa-sign-out-alt text-lg"></i>
                </button>
            </form>
        </div>
    </div>
</aside>
