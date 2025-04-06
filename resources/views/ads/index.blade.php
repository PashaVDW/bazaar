@extends('layouts.profile')

@section('content')
<div class="max-w-7xl mx-auto mt-8">
    @if (session('success'))
        <x-shared.toast type="success" :message="session('success')" />
    @endif

    @if (session('error'))
        <x-shared.toast type="error" :message="session('error')" />
    @endif

    <x-shared.table title="Your Advertisements">
        <x-slot:actions>
            <a href="{{ route('advertisements.create') }}"
               class="inline-block px-6 py-3 bg-primary text-white text-sm font-medium rounded-lg hover:bg-orange-600 transition">
                <i class="fa-solid fa-plus mr-1"></i> Create Advertisement
            </a>
        </x-slot:actions>

        <table class="w-full text-left table-auto">
            <thead>
            <tr>
                <th class="pl-10 xl:pl-24 h-20 bg-white text-left text-sm font-semibold uppercase text-gray-500">Image</th>
                <th class="text-left h-20 bg-white text-sm font-semibold uppercase text-gray-500">Title</th>
                <th class="text-left h-20 bg-white text-sm font-semibold uppercase text-gray-500">Starttime</th>
                <th class="text-left h-20 bg-white text-sm font-semibold uppercase text-gray-500">Endtime</th>
                <th class="text-left h-20 bg-white text-sm font-semibold uppercase text-gray-500">Status</th>
                <th class="text-right h-20 bg-white text-sm font-semibold uppercase text-gray-500 pr-10">Actions</th>
            </tr>
            </thead>
            <tbody class="bg-white divide-y">
            @foreach ($advertisements as $ad)
                <tr class="hover:bg-gray-50 border-u border-gray-100 transition cursor-pointer group" onclick="window.location='{{ route('advertisements.edit', $ad->id) }}'">
                    <td class="px-6 py-4">
                        <img src="{{ asset('storage/' . $ad->image) }}"
                             alt="{{ $ad->title }}"
                             class="w-14 h-14 object-cover rounded">
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $ad->title }}</td>
                    <td class="px-6 py-4 text-gray-700">{{ $ad->ads_starttime }}</td>
                    <td class="px-6 py-4 text-gray-700">{{ $ad->ads_endtime }}</td>
                    <td class="px-6 py-4">
                        @if ($ad->is_active)
                            <span class="px-3 py-1 text-xs bg-green-100 text-green-700 rounded-full font-medium">Active</span>
                        @else
                            <span class="px-3 py-1 text-xs bg-red-100 text-red-700 rounded-full font-medium">Inactive</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right" onclick="event.stopPropagation()">
                        <a href="{{ route('advertisements.edit', $ad->id) }}" class="text-primary hover:text-primary transition" title="Edit">
                            <i class="fas fa-edit text-lg px-2"></i>
                        </a>
                        <a data-modal-target="delete-modal-{{ $ad->id }}" data-modal-toggle="delete-modal-{{ $ad->id }}" class="text-red-600 hover:text-red-800 transition" title="Delete">
                            <i class="fas fa-trash-alt text-lg"></i>
                        </a>
                    </td>
                </tr>
                <x-shared.delete-modal
                    :id="'delete-modal-' . $ad->id"
                    :title="'Delete ' . $ad->title . '?'"
                    message="Are you sure you want to permanently delete this advertisement?"
                    :action="route('advertisements.destroy', $ad->id)"
                />
            @endforeach
            </tbody>
        </table>
    </x-shared.table>
</div>
@endsection
