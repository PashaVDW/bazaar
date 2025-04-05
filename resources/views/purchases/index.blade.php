@extends('layouts.profile')

@section('content')
    <x-shared.table title="Recent Orders">
        <table class="mb-10 table-auto w-full">
            <thead>
            <tr>
                <th class="pl-10 xl:pl-24 h-20 bg-white text-left text-sm font-semibold uppercase text-gray-500">Order ID</th>
                <th class="text-left h-20 bg-white text-sm font-semibold uppercase text-gray-500">Date</th>
                <th class="text-left h-20 bg-white text-sm font-semibold uppercase text-gray-500">Quantity</th>
                <th class="text-right h-20 bg-white text-sm font-semibold uppercase text-gray-500 pr-10">Action</th>
            </tr>
            </thead>
            <tbody>
            @forelse($purchases as $purchase)
                <tr class="group transition hover:bg-gray-100">
                    <td class="pl-10 xl:pl-24 py-4 bg-blueGray-50 rounded-l-xl">
                        <div class="text-base font-medium text-gray-900">{{ $purchase->id }}</div>
                        @php
                            $ad = $purchase->ads->first();
                            $review = $ad ? $ad->reviews->firstWhere('user_id', auth()->id()) : null;
                        @endphp
                        @if ($ad)
                            <a href="{{ route('review.create', ['ad' => $ad->id]) }}"
                               class="inline-block mt-2 text-sm font-medium text-indigo-600 hover:underline transition">
                                {{ $review ? 'Edit review' : 'Write a review' }}
                            </a>
                        @endif
                    </td>
                    <td class="py-4 bg-blueGray-50">
                        <span class="text-base text-gray-700">{{ $purchase->purchased_at->format('d M Y H:i') }}</span>
                    </td>
                    <td class="py-4 bg-blueGray-50">
                        <span class="text-base text-gray-700">
                            {{ $purchase->ads->sum(fn($ad) => $ad->pivot->quantity) }}
                        </span>
                    </td>
                    <td class="py-4 bg-blueGray-50 pr-10 text-right">
                        <a href="{{ route('profile.purchases.show', $purchase->id) }}"
                           class="inline-flex items-center px-4 py-1 text-sm font-medium text-indigo-700 bg-indigo-100 hover:bg-indigo-200 rounded-full transition">
                            View
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-6 py-6 text-center text-gray-500">No purchases found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        @if ($purchases->hasPages())
            <div class="flex justify-center">
                {{ $purchases->links('pagination::tailwind') }}
            </div>
        @endif
    </x-shared.table>
@endsection
