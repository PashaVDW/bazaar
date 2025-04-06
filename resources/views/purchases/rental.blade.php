@extends('layouts.profile')

@section('content')
    <div class="max-w-7xl mx-auto mt-8">
        <x-shared.view-switch
        left-label="Rentals Overview"
        right-label="Rentals Calendar"
        left-route="profile.rentalHistory"
        right-route="profile.rentalCalendar"
        switch-key="switch"
        />
    </div>
    <div class="max-w-7xl mx-auto mt-8 space-y-16">
        <x-shared.table title="{{ __('messages.your_rentals') }}">
            <div class="overflow-x-auto rounded-lg shadow">
                <table class="w-full text-left table-auto">
                    <thead>
                    <tr class="text-gray-500 text-sm uppercase bg-gray-50">
                        <th class="px-6 py-4">{{ __('messages.reservation_id') }}</th>
                        <th class="px-6 py-4">{{ __('messages.product') }}</th>
                        <th class="px-6 py-4">{{ __('messages.user') }}</th>
                        <th class="px-6 py-4">{{ __('messages.period') }}</th>
                        <th class="px-6 py-4">{{ __('messages.return_request') }}</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y">
                    @forelse($ownedReservations as $reservation)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $reservation->id }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $reservation->product?->name ?? __('messages.product_deleted') }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $reservation->user->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ \Carbon\Carbon::parse($reservation->start_time)->format('d M Y H:i') }}
                                –
                                {{ \Carbon\Carbon::parse($reservation->end_time)->format('d M Y H:i') }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                @if ($reservation->returned_at)
                                    <span class="inline-flex items-center px-3 py-1 text-sm font-medium text-green-700 bg-green-100 rounded-full">
                                        {{ __('messages.finalized') }}
                                    </span>
                                @elseif ($reservation->returnRequest)
                                    <a href="{{ route('return.review', $reservation->id) }}"
                                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700 transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        {{ __('messages.review_return') }}
                                    </a>
                                @else
                                    <span class="text-gray-400 italic">{{ __('messages.none') }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-6 text-center text-gray-500">{{ __('messages.no_rentals_found') }}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </x-shared.table>

        <x-shared.table title="{{ __('messages.rental_history') }}">
            <div class="overflow-x-auto rounded-lg shadow">
                <table class="w-full text-left table-auto">
                    <thead>
                    <tr class="text-gray-500 text-sm uppercase bg-gray-50">
                        <th class="px-6 py-4">{{ __('messages.rental_id') }}</th>
                        <th class="px-6 py-4">{{ __('messages.product') }}</th>
                        <th class="px-6 py-4">{{ __('messages.period') }}</th>
                        <th class="px-6 py-4">{{ __('messages.reserved_at') }}</th>
                        <th class="px-6 py-4">{{ __('messages.return') }}</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y">
                    @forelse($reservations as $reservation)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $reservation->id }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $reservation->product?->name ?? __('messages.product_deleted') }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ \Carbon\Carbon::parse($reservation->start_time)->format('d M Y H:i') }}
                                –
                                {{ \Carbon\Carbon::parse($reservation->end_time)->format('d M Y H:i') }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ \Carbon\Carbon::parse($reservation->created_at)->format('d M Y H:i') }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                @if ($reservation->returned_at)
                                    <span class="inline-flex items-center px-3 py-1 text-sm font-medium text-green-700 bg-green-100 rounded-full">
                                        {{ __('messages.finalized') }}
                                    </span>
                                @elseif ($reservation->returnRequest)
                                    <span class="inline-flex items-center px-3 py-1 text-sm font-medium text-blue-700 bg-blue-100 rounded-full">
                                        {{ __('messages.request_submitted') }}
                                    </span>
                                @else
                                    <a href="{{ route('reservations.return.form', $reservation->id) }}"
                                       class="inline-block px-3 py-1 text-sm bg-indigo-600 hover:bg-indigo-700 text-white rounded-md transition">
                                        {{ __('messages.return') }}
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-6 text-center text-gray-500">{{ __('messages.no_rentals_found') }}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            @if ($reservations->hasPages())
                <div class="mt-6 flex justify-center">
                    {{ $reservations->links('pagination::tailwind') }}
                </div>
            @endif
        </x-shared.table>
    </div>
@endsection
