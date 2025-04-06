@props(['action' => request()->url()])

<form action="{{ $action }}" method="GET" class="w-full mb-6">
    <div class="bg-white border border-gray-200 rounded-xl px-6 py-5 shadow-sm grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-5">

        <div class="flex flex-col">
            <label for="search" class="text-sm font-medium text-gray-700 mb-1">{{ __('messages.search') }}</label>
            <input type="text" name="search" id="search" value="{{ request('search') }}"
                   class="rounded-md border border-gray-300 text-sm shadow-sm focus:ring-primary focus:border-primary px-3 py-2"
                   placeholder="{{ __('messages.search_placeholder') }}" />
        </div>

        <div class="flex flex-col">
            <label for="type" class="text-sm font-medium text-gray-700 mb-1">{{ __('messages.type') }}</label>
            <select name="type" id="type"
                    class="rounded-md border border-gray-300 text-sm shadow-sm focus:ring-primary focus:border-primary px-3 py-2">
                <option value="">{{ __('messages.all_types') }}</option>
                <option value="sale" @selected(request('type') === 'sale')>{{ __('messages.sale') }}</option>
                <option value="rental" @selected(request('type') === 'rental')>{{ __('messages.rental') }}</option>
                <option value="auction" @selected(request('type') === 'auctions')>{{ __('messages.auctions') }}</option>
            </select>
        </div>

        <div class="flex flex-col">
            <label for="sort" class="text-sm font-medium text-gray-700 mb-1">{{ __('messages.sort_by') }}</label>
            <select name="sort" id="sort"
                    class="rounded-md border border-gray-300 text-sm shadow-sm focus:ring-primary focus:border-primary px-3 py-2">
                <option value="latest" @selected(request('sort') === 'latest')>{{ __('messages.latest') }}</option>
                <option value="price_low_high" @selected(request('sort') === 'price_low_high')>{{ __('messages.price_low_high') }}</option>
                <option value="price_high_low" @selected(request('sort') === 'price_high_low')>{{ __('messages.price_high_low') }}</option>
            </select>
        </div>

        <div class="flex flex-col space-y-1">
            <label class="text-sm font-medium text-gray-700">{{ __('messages.price_euro') }}</label>
            <div class="flex gap-2">
                <input type="number" step="0.01" name="price_min" value="{{ request('price_min') }}"
                       class="w-1/2 rounded-md border border-gray-300 text-sm shadow-sm focus:ring-primary focus:border-primary px-3 py-2"
                       placeholder="{{ __('messages.min') }}" />
                <input type="number" step="0.01" name="price_max" value="{{ request('price_max') }}"
                       class="w-1/2 rounded-md border border-gray-300 text-sm shadow-sm focus:ring-primary focus:border-primary px-3 py-2"
                       placeholder="{{ __('messages.max') }}" />
            </div>
        </div>

        <div class="flex items-end md:col-span-2 lg:col-span-1 xl:col-span-1">
            <button type="submit"
                    class="w-full bg-primary hover:bg-primary-hover text-white text-sm font-medium px-4 py-2.5 rounded-md shadow transition">
                <i class="fa-solid fa-filter mr-2"></i> {{ __('messages.apply_filters') }}
            </button>
        </div>
    </div>
</form>
