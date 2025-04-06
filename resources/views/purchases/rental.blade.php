@extends('layouts.profile')

@section('content')
    <div class="max-w-7xl mx-auto mt-8 space-y-16">
        <x-shared.table title="Your Rentals">
            <div class="overflow-x-auto rounded-lg shadow">
                <table class="w-full text-left table-auto">
                    <thead>
                    <tr class="text-gray-500 text-sm uppercase bg-gray-50">
                        <th class="px-6 py-4">Reservation ID</th>
                        <th class="px-6 py-4">Product</th>
                        <th class="px-6 py-4">User</th>
                        <th class="px-6 py-4">Period</th>
                        <th class="px-6 py-4">Return Request</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y">
                    @forelse($ownedReservations as $reservation)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $reservation->id }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $reservation->product?->name ?? 'Deleted' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $reservation->user->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ \Carbon\Carbon::parse($reservation->start_time)->format('d M Y H:i') }}
                                –
                                {{ \Carbon\Carbon::parse($reservation->end_time)->format('d M Y H:i') }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                @if ($reservation->returned_at)
                                    <span class="inline-flex items-center px-3 py-1 text-sm font-medium text-green-700 bg-green-100 rounded-full">
                                    Finalized
                                </span>
                                @elseif ($reservation->returnRequest)
                                    <a href="{{ route('return.review', $reservation->id) }}"
                                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700 transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Review Return
                                    </a>
                                @else
                                    <span class="text-gray-400 italic">None</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-6 text-center text-gray-500">No rentals found.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </x-shared.table>

        <x-shared.table title="Rental History">
            <div class="overflow-x-auto rounded-lg shadow">
                <table class="w-full text-left table-auto">
                    <thead>
                    <tr class="text-gray-500 text-sm uppercase bg-gray-50">
                        <th class="px-6 py-4">Rental ID</th>
                        <th class="px-6 py-4">Product</th>
                        <th class="px-6 py-4">Period</th>
                        <th class="px-6 py-4">Reserved At</th>
                        <th class="px-6 py-4">Return</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y">
                    @forelse($reservations as $reservation)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $reservation->id }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $reservation->product?->name ?? 'Product deleted' }}</td>
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
                                    Finalized
                                </span>
                                @elseif ($reservation->returnRequest)
                                    <span class="inline-flex items-center px-3 py-1 text-sm font-medium text-blue-700 bg-blue-100 rounded-full">
                                    Request Submitted
                                </span>
                                @else
                                    <a href="{{ route('reservations.return.form', $reservation->id) }}"
                                       class="inline-block px-3 py-1 text-sm bg-indigo-600 hover:bg-indigo-700 text-white rounded-md transition">
                                        Return
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-6 text-center text-gray-500">No rentals found.</td>
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
