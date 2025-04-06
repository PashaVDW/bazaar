    <div class="max-w-7xl mx-auto px-6">
        <div class="bg-white rounded-3xl shadow-md p-8 border border-gray-200">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                <h2 class="text-2xl font-semibold text-gray-800 tracking-tight">
                    {{ $title ?? 'Table Title' }}
                </h2>

                @isset($actions)
                    <div class="mt-4 md:mt-0">
                        {{ $actions }}
                    </div>
                @endisset
            </div>

            <div class="overflow-x-auto rounded-xl border border-gray-100">
                {{ $slot }}
            </div>
        </div>
    </div>
