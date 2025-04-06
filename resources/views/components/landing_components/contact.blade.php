<div class="bg-white py-10 px-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">{{ __('messages.contact_us') }}</h2>
    <form class="space-y-4">
        <input type="text" placeholder="{{ __('messages.name') }}" class="w-full border border-gray-300 rounded px-4 py-2">
        <input type="email" placeholder="{{ __('messages.email') }}" class="w-full border border-gray-300 rounded px-4 py-2">
        <textarea placeholder="{{ __('messages.message') }}" class="w-full border border-gray-300 rounded px-4 py-2 h-32"></textarea>
        <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-lg">{{ __('messages.send') }}</button>
    </form>
</div>
