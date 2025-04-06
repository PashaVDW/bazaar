@extends('layouts.profile')

@section('content')
    <div class="max-w-7xl mx-auto mt-8 space-y-16">
        <x-shared.table title="{{ __('messages.recent_orders') }}">
            <div class="overflow-x-auto rounded-lg shadow">
                <table class="w-full text-left table-auto">
                    <thead class="bg-gray-50">
                    <tr class="text-gray-500 text-sm uppercase">
                        <th class="px-6 py-4">{{ __('messages.order_id') }}</th>
                        <th class="px-6 py-4">{{ __('messages.date') }}</th>
                        <th class="px-6 py-4">{{ __('messages.products') }}</th>
                        <th class="px-6 py-4 text-right">{{ __('messages.action') }}</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y">
                    @forelse($purchases as $purchase)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $purchase->id }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $purchase->purchased_at->format('d M Y H:i') }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                <ul class="space-y-1">
                                    @foreach($purchase->products as $product)
                                        <li>
                                            {{ $product->name }} × {{ $product->pivot->quantity }}
                                            @php
                                                $review = $product->reviews->firstWhere('user_id', auth()->id());
                                            @endphp
                                            <a href="{{ route('review.create', ['product' => $product->id]) }}"
                                               class="ml-2 text-sm text-indigo-600 hover:underline">
                                                {{ $review ? __('messages.edit_review') : __('messages.review') }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('profile.purchases.show', $purchase->id) }}"
                                   class="inline-flex items-center px-4 py-1 text-sm font-medium text-indigo-700 bg-indigo-100 hover:bg-indigo-200 rounded-full transition">
                                    {{ __('messages.view') }}
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-6 text-center text-gray-500">{{ __('messages.no_purchases_found') }}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            @if ($purchases->hasPages())
                <div class="mt-6 flex justify-center">
                    {{ $purchases->links('pagination::tailwind') }}
                </div>
            @endif
        </x-shared.table>
    </div>
@endsection
