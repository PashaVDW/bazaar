@extends('layouts.profile')

@section('content')
    {{-- ✅ Toast Notifications Fixed Top Right --}}
    <div class="fixed top-5 right-5 z-[9999] space-y-2">
        @if (session('success'))
            <div id="toast-success" class="flex items-center w-full max-w-xs p-4 text-gray-700 bg-white border border-green-200 rounded-lg shadow-sm transition-opacity duration-500" role="alert">
                <div class="inline-flex items-center justify-center w-8 h-8 text-green-500 bg-green-100 rounded-lg">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                    </svg>
                </div>
                <div class="ms-3 text-sm font-medium">{{ session('success') }}</div>
                <button type="button" class="ms-auto text-gray-400 hover:text-gray-900 rounded-lg p-1.5 hover:bg-gray-100" data-dismiss-target="#toast-success" aria-label="Close">
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
            </div>
            <script>
                setTimeout(() => {
                    const toast = document.getElementById('toast-success');
                    if (toast) {
                        toast.classList.add('opacity-0');
                        setTimeout(() => toast.remove(), 500);
                    }
                }, 3000);
            </script>
        @endif

        @if (session('error'))
            <div id="toast-danger" class="flex items-center w-full max-w-xs p-4 text-red-600 bg-white border border-red-200 rounded-lg shadow-sm" role="alert">
                <div class="inline-flex items-center justify-center w-8 h-8 text-red-500 bg-red-100 rounded-lg">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z"/>
                    </svg>
                </div>
                <div class="ms-3 text-sm font-medium">{{ session('error') }}</div>
                <button type="button" class="ms-auto text-gray-400 hover:text-gray-900 rounded-lg p-1.5 hover:bg-gray-100" data-dismiss-target="#toast-danger" aria-label="Close">
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
            </div>
        @endif
    </div>

    <x-shared.table title="Your Advertisements">
        <x-slot:actions>
            <a href="{{ route('advertisements.create') }}"
               class="inline-block py-4 px-8 text-lg leading-6 text-white font-medium tracking-tighter font-heading text-center bg-purple-500 hover:bg-purple-600 focus:ring-2 focus:ring-purple-500 focus:ring-opacity-50 rounded-xl">
                + Create Advertisement
            </a>
        </x-slot:actions>

        <table class="mb-10 table-auto w-full">
            <thead>
            <tr>
                <th class="pl-10 xl:pl-24 h-20 bg-white text-left text-sm font-semibold uppercase text-gray-500">Image</th>
                <th class="text-left h-20 bg-white text-sm font-semibold uppercase text-gray-500">Title</th>
                <th class="text-left h-20 bg-white text-sm font-semibold uppercase text-gray-500">Hourly Price</th>
                <th class="text-left h-20 bg-white text-sm font-semibold uppercase text-gray-500">Starttime</th>
                <th class="text-left h-20 bg-white text-sm font-semibold uppercase text-gray-500">Endtime</th>
                <th class="text-left h-20 bg-white text-sm font-semibold uppercase text-gray-500">Type</th>
                <th class="text-left h-20 bg-white text-sm font-semibold uppercase text-gray-500">Status</th>
                <th class="text-right h-20 bg-white text-sm font-semibold uppercase text-gray-500 pr-10">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($advertisements as $ad)
                <tr class="group transition hover:bg-gray-100">
                    <td class="pl-10 xl:pl-24 py-4 bg-blueGray-50 cursor-pointer" onclick="window.location='{{ route('advertisements.edit', $ad->id) }}'">
                        <img src="{{ asset('storage/' . $ad->image) }}" alt="{{ $ad->title }}" class="w-16 h-16 object-cover rounded-md shadow-sm group-hover:scale-105 transition">
                    </td>
                    <td class="py-4 bg-blueGray-50 cursor-pointer" onclick="window.location='{{ route('advertisements.edit', $ad->id) }}'">
                        <span class="text-base font-medium text-gray-900">{{ $ad->title }}</span>
                    </td>
                    <td class="py-4 bg-blueGray-50 cursor-pointer" onclick="window.location='{{ route('advertisements.edit', $ad->id) }}'">
                        <span class="text-base text-gray-700">€{{ number_format($ad->hourly_price, 2) }}</span>
                    </td>
                    <td class="py-4 bg-blueGray-50 cursor-pointer" onclick="window.location='{{ route('advertisements.edit', $ad->id) }}'">
                        <span class="text-base text-gray-700">{{ $ad->ads_starttime }}</span>
                    </td>
                    <td class="py-4 bg-blueGray-50 cursor-pointer" onclick="window.location='{{ route('advertisements.edit', $ad->id) }}'">
                        <span class="text-base text-gray-700">{{ $ad->ads_endtime }}</span>
                    </td>
                    <td class="py-4 bg-blueGray-50 cursor-pointer" onclick="window.location='{{ route('advertisements.edit', $ad->id) }}'">
                        <span class="text-base text-gray-700">{{ ucfirst($ad->type) }}</span>
                    </td>
                    <td class="py-4 bg-blueGray-50">
                        @if ($ad->is_active)
                            <span class="py-1 px-3 text-sm text-green-700 bg-green-200 font-medium rounded-full">Active</span>
                        @else
                            <span class="py-1 px-3 text-sm text-red-700 bg-red-200 font-medium rounded-full">Inactive</span>
                        @endif
                    </td>
                    <td class="py-4 bg-blueGray-50 pr-10 text-right">
                        <button dusk="delete-button-{{ $ad->id }}"
                                data-modal-target="delete-modal-{{ $ad->id }}"
                                data-modal-toggle="delete-modal-{{ $ad->id }}"
                                class="text-red-600 hover:text-red-800 transition"
                                type="button"
                                title="Delete">
                            <i class="fas fa-trash-alt text-lg"></i>
                        </button>
                    </td>
                </tr>
                {{-- Delete Modal --}}
                {{-- [Your modal code stays unchanged here] --}}
            @endforeach
            </tbody>
        </table>
    </x-shared.table>

    <script src="https://unpkg.com/flowbite@1.6.5/dist/flowbite.min.js"></script>
@endsection
