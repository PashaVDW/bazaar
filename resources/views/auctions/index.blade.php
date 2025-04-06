@extends('layouts.profile')

@section('content')
    <div class="max-w-7xl mx-auto mt-8">
        @if (session('success'))
            <x-shared.toast type="success" :message="session('success')" />
        @endif

        @if (session('error'))
            <x-shared.toast type="error" :message="session('error')" />
        @endif

        <x-shared.table :title="__('messages.your_auctions')">
            <table class="w-full text-left table-auto">
                <thead>
                <tr>
                    <th class="px-6 py-3 text-sm font-semibold text-gray-500 uppercase">{{ __('messages.product') }}</th>
                    <th class="px-6 py-3 text-sm font-semibold text-gray-500 uppercase">{{ __('messages.status') }}</th>
                    <th class="px-6 py-3 text-sm font-semibold text-gray-500 uppercase">{{ __('messages.highest_bid') }}</th>
                    <th class="px-6 py-3 text-sm font-semibold text-gray-500 uppercase">{{ __('messages.winning_bidder') }}</th>
                    <th class="px-6 py-3 text-sm font-semibold text-gray-500 uppercase text-right">{{ __('messages.actions') }}</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y">
                @forelse ($products as $product)
                    <tr class="hover:bg-gray-50 transition group">
                        <td class="px-6 py-4 font-medium text-gray-900">
                            {{ $product->name }}
                        </td>
                        <td class="px-6 py-4">
                            @if ($product->is_auction_closed)
                                <span class="px-3 py-1 text-xs bg-red-100 text-red-700 rounded-full font-medium">{{ __('messages.closed') }}</span>
                            @else
                                <span class="px-3 py-1 text-xs bg-green-100 text-green-700 rounded-full font-medium">{{ __('messages.open') }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if ($product->bids->count())
                                €{{ number_format($product->bids->first()->amount, 2) }}
                            @else
                                <span class="text-sm text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if ($product->winningBid && $product->winningBid->user)
                                {{ $product->winningBid->user->name }}
                            @else
                                <span class="text-sm text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            @if (!$product->is_auction_closed)
                                <form method="POST" action="{{ route('auctions.close', $product) }}">
                                    @csrf
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">
                                        {{ __('messages.close_auction') }}
                                    </button>
                                </form>
                            @else
                                <span class="text-gray-400 text-sm">{{ __('messages.closed') }}</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">{{ __('messages.no_auctions_found') }}</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </x-shared.table>

        <div class="mt-6">
            {{ $products->links() }}
        </div>
    </div>
@endsection
