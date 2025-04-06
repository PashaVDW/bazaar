@props(['type' => 'success', 'message'])

<div
    id="toast-{{ uniqid() }}"
    class="fixed top-5 right-5 z-50 flex items-center p-4 max-w-xs w-full text-sm rounded-lg shadow-md border mb-4
        {{ $type === 'success' ? 'bg-green-50 text-green-800 border-green-200' : 'bg-red-50 text-red-800 border-red-200' }}"
    role="alert"
>
    <div class="flex items-center space-x-3">
        <i class="fa-solid {{ $type === 'success' ? 'fa-circle-check text-green-600' : 'fa-circle-xmark text-red-600' }}"></i>
        <span class="font-medium">{{ $message }}</span>
    </div>
</div>
