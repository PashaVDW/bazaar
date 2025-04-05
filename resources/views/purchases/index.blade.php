@extends('layouts.profile')

@section('content')
    <section class="py-8 bg-blueGray-50" x-data="{ showContent: false }">
        <div class="container px-4 mx-auto">
            <div class="p-7 pb-12 pt-12 bg-white rounded-5xl">
                <h2 class="pl-10 xl:pl-24 text-3xl font-heading font-medium">Recent Transactions</h2>
                <div class="overflow-x-auto">
                    <div class="inline-block min-w-full overflow-hidden">
                        <table class="mb-10 table-auto w-full">
                            <thead>
                            <tr>
                                <th class="pl-10 xl:pl-24 h-20 bg-white text-left">
                                    <span class="block text-sm text-body text-opacity-40 font-heading font-semibold uppercase min-w-max">Transaction ID</span>
                                </th>
                                <th class="p-5 h-20 bg-white">
                                    <span class="block text-sm text-body text-opacity-40 font-heading font-semibold uppercase min-w-max">Date</span>
                                </th>
                                <th class="p-5 h-20 bg-white">
                                    <span class="block text-sm text-body text-opacity-40 font-heading font-semibold uppercase min-w-max">Quantity</span>
                                </th>
                                <th class="p-5 h-20 bg-white">
                                    <span class="block text-sm text-body text-opacity-40 font-heading font-semibold uppercase min-w-max">Action</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($purchases as $purchase)
                                <tr>
                                    <td class="p-0">
                                        <div class="flex items-center pl-10 xl:pl-24 h-20 bg-blueGray-50 border-l border-t border-b border-gray-100 rounded-tl-5xl rounded-bl-5xl">
                                            <span class="text-lg font-heading font-medium">{{ $purchase->id }}</span>
                                        </div>
                                    </td>
                                    <td class="p-0">
                                        <div class="flex items-center justify-center p-5 h-20 text-center bg-blueGray-50 border-t border-b border-gray-100">
                                            <span class="text-lg text-darkBlueGray-400 font-heading">{{ $purchase->purchased_at->format('d M Y H:i') }}</span>
                                        </div>
                                    </td>
                                    <td class="p-0">
                                        <div class="flex items-center justify-center p-5 h-20 text-center bg-blueGray-50 border-t border-b border-gray-100">
                                            <span class="text-lg text-darkBlueGray-400 font-heading">
                                                {{ $purchase->ads->sum(fn($ad) => $ad->pivot->quantity) }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="p-0">
                                        <div class="flex items-center justify-center p-5 h-20 text-center bg-blueGray-50 border-t border-b border-r border-gray-100 rounded-tr-5xl rounded-br-5xl">
                                            <a href="{{ route('profile.purchases.show', $purchase->id) }}"
                                               class="py-1 px-3 text-sm text-indigo-700 font-heading font-medium bg-indigo-200 rounded-full">
                                                View
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">No purchases found.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if ($purchases->hasPages())
                    <div class="flex justify-center mt-4 space-x-1">
                        @if ($purchases->onFirstPage())
                            <span class="px-3 py-2 text-sm text-gray-400 bg-gray-100 rounded">&lsaquo;</span>
                        @else
                            <a href="{{ $purchases->previousPageUrl() }}" class="px-3 py-2 text-sm text-gray-700 bg-gray-200 rounded hover:bg-gray-300">&lsaquo;</a>
                        @endif

                        @foreach ($purchases->links()->elements[0] as $page => $url)
                            @if ($page == $purchases->currentPage())
                                <span class="px-3 py-2 text-sm font-semibold text-white bg-indigo-600 rounded">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="px-3 py-2 text-sm text-gray-700 bg-gray-200 rounded hover:bg-gray-300">{{ $page }}</a>
                            @endif
                        @endforeach

                        @if ($purchases->hasMorePages())
                            <a href="{{ $purchases->nextPageUrl() }}" class="px-3 py-2 text-sm text-gray-700 bg-gray-200 rounded hover:bg-gray-300">&rsaquo;</a>
                        @else
                            <span class="px-3 py-2 text-sm text-gray-400 bg-gray-100 rounded">&rsaquo;</span>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
