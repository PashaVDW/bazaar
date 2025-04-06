@extends('layouts.profile')

@section('content')
    <div class="max-w-7xl mx-auto mt-8">
        @if (session('success'))
            <x-shared.toast type="success" :message="session('success')" />
        @endif

        @if (session('error'))
            <x-shared.toast type="error" :message="session('error')" />
        @endif
        @role('business_advertiser')
            <x-shared.view-switch
                :left-label="__('messages.ads') . ' ' . __('messages.overview')"
                :right-label="__('messages.ads') . ' ' . __('messages.calendar')"
                left-route="advertisements.index"
                right-route="advertisements.ad-calendar"
                switch-key="switch"
            />
        @endrole
        <x-shared.table :title="__('messages.your_advertisements')">
            <x-slot:actions>
                <a href="{{ route('advertisements.create') }}"
                   class="inline-block px-6 py-3 bg-primary text-white text-sm font-medium rounded-lg hover:bg-primary/80 transition">
                    <i class="fa-solid fa-plus mr-1"></i> {{ __('messages.create_advertisement') }}
                </a>
                @role('business_advertiser')
                <form id="import-csv-form" method="POST" action="{{ route('advertisements.import') }}" enctype="multipart/form-data" class="inline-block ml-3">
                    @csrf
                    <label for="csv-upload" class="inline-block px-6 py-3 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition cursor-pointer">
                        <i class="fa-solid fa-upload mr-1"></i> {{ __('messages.import_csv') }}
                    </label>
                    <input id="csv-upload" name="csv_file" type="file" accept=".csv" class="hidden" onchange="document.getElementById('import-csv-form').submit()">
                </form>
                @endrole
            </x-slot:actions>

            <table class="w-full text-left table-auto">
                <thead>
                <tr>
                    <th class="pl-10 xl:pl-24 h-20 bg-white text-left text-sm font-semibold uppercase text-gray-500">{{ __('messages.image') }}</th>
                    <th class="text-left h-20 bg-white text-sm font-semibold uppercase text-gray-500">{{ __('messages.title') }}</th>
                    <th class="text-left h-20 bg-white text-sm font-semibold uppercase text-gray-500">{{ __('messages.start_date') }}</th>
                    <th class="text-left h-20 bg-white text-sm font-semibold uppercase text-gray-500">{{ __('messages.end_date') }}</th>
                    <th class="text-left h-20 bg-white text-sm font-semibold uppercase text-gray-500">{{ __('messages.status') }}</th>
                    <th class="text-left h-20 bg-white text-sm font-semibold uppercase text-gray-500">{{ __('messages.qr_code') }}</th>
                    <th class="text-right h-20 bg-white text-sm font-semibold uppercase text-gray-500 pr-10">{{ __('messages.actions') }}</th>
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
                                <span class="px-3 py-1 text-xs bg-green-100 text-green-700 rounded-full font-medium">{{ __('messages.active') }}</span>
                            @else
                                <span class="px-3 py-1 text-xs bg-red-100 text-red-700 rounded-full font-medium">{{ __('messages.inactive') }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if (!empty($ad->qr_svg))
                                <div class="w-10 h-10">
                                    <div class="w-full h-full [&>svg]:w-full [&>svg]:h-full [&>svg]:block">
                                        {!! $ad->qr_svg !!}
                                    </div>
                                </div>
                            @else
                                <span class="text-sm text-gray-400">{{ __('messages.not_available') }}</span>
                            @endif
                        </td>

                        <td class="px-6 py-4 text-right" onclick="event.stopPropagation()">
                            <a href="{{ route('advertisements.edit', $ad->id) }}" class="text-primary hover:text-primary/80 transition" title="{{ __('messages.edit') }}">
                                <i class="fas fa-edit text-lg px-2"></i>
                            </a>
                            <a data-modal-target="delete-modal-{{ $ad->id }}" data-modal-toggle="delete-modal-{{ $ad->id }}" class="text-red-600 hover:text-red-800 transition" title="{{ __('messages.delete') }}">
                                <i class="fas fa-trash-alt text-lg"></i>
                            </a>
                        </td>
                    </tr>
                    <x-shared.delete-modal
                        :id="'delete-modal-' . $ad->id"
                        :title="__('messages.delete') . ' ' . $ad->title . '?'"
                        :message="__('messages.confirm_delete_advertisement')"
                        :action="route('advertisements.destroy', $ad->id)"
                    />
                @endforeach
                </tbody>
            </table>
        </x-shared.table>
    </div>
@endsection
