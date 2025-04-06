@props([
    'id',
    'title' => __('messages.are_you_sure'),
    'message' => __('messages.this_action_cannot_be_undone'),
    'action',
])

<div id="{{ $id }}" class="fixed inset-0 z-50 hidden bg-black/30 backdrop-blur-sm flex items-center justify-center">
    <div class="bg-white rounded-2xl shadow-xl max-w-md w-full p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-2">{{ $title }}</h2>
        <p class="text-sm text-gray-600 mb-6">{{ $message }}</p>

        <form method="POST" action="{{ $action }}">
            @csrf
            @method('DELETE')

            <div class="flex gap-4">
                <button type="submit"
                        class="w-1/2 py-2 px-4 bg-red-600 text-white text-sm font-semibold rounded-lg hover:bg-red-700 transition">
                    {{ __('messages.yes_delete') }}
                </button>
                <button type="button"
                        class="w-1/2 py-2 px-4 bg-gray-100 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-200 transition"
                        data-modal-hide="{{ $id }}">
                    {{ __('messages.cancel') }}
                </button>
            </div>
        </form>
    </div>
</div>
