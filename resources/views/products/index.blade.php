@extends('layouts.profile')

@section('content')
    <div class="max-w-7xl mx-auto mt-8">
        @if (session('success'))
            <x-shared.toast type="success" :message="session('success')" />
        @endif

        @if (session('error'))
            <x-shared.toast type="error" :message="session('error')" />
        @endif

        <x-shared.table title="{{ __('messages.your_products') }}">
            <x-slot:actions>
                <a href="{{ route('products.create') }}"
                   class="inline-block px-6 py-3 bg-primary text-white text-sm font-medium rounded-lg hover:bg-orange-600 transition">
                    <i class="fa-solid fa-plus mr-1"></i> {{ __('messages.add_product') }}
                </a>
            </x-slot:actions>

            <table class="w-full text-left table-auto">
                <thead>
                <tr class="text-gray-500 text-sm uppercase">
                    <th class="px-6 py-4">{{ __('messages.image') }}</th>
                    <th class="px-6 py-4">{{ __('messages.name') }}</th>
                    <th class="px-6 py-4">{{ __('messages.price') }}</th>
                    <th class="px-6 py-4">{{ __('messages.stock') }}</th>
                    <th class="px-6 py-4">{{ __('messages.type') }}</th>
                    <th class="px-6 py-4">{{ __('messages.ad') }}</th>
                    <th class="px-6 py-4 text-right">{{ __('messages.actions') }}</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y">
                @foreach ($products as $product)
                    <tr class="hover:bg-gray-50 transition border-u border-y-gray-100 cursor-pointer group" onclick="window.location='{{ route('products.edit', $product) }}'">
                        <td class="px-6 py-4">
                            @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}"
                                     alt="{{ $product->name }}"
                                     class="w-14 h-14 object-cover rounded shadow-sm">
                            @else
                                <span class="text-gray-400 italic">{{ __('messages.no_image') }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $product->name }}</td>
                        <td class="px-6 py-4 text-gray-700">€{{ number_format($product->price, 2) }}</td>
                        <td class="px-6 py-4 text-gray-700">{{ $product->stock }}</td>
                        <td class="px-6 py-4 text-gray-700">{{ ucfirst($product->type) }}</td>
                        <td class="px-6 py-4 text-gray-700">{{ $product->ad->title ?? '-' }}</td>
                        <td class="px-6 py-4 text-right" onclick="event.stopPropagation()">
                            <a href="{{ route('products.edit', $product) }}" class="text-primary hover:text-orange-600 transition px-2" title="{{ __('messages.edit') }}">
                                <i class="fas fa-edit text-lg"></i>
                            </a>
                            <a data-modal-target="delete-modal-{{ $product->id }}" data-modal-toggle="delete-modal-{{ $product->id }}" class="text-red-600 hover:text-red-800 transition px-2" title="{{ __('messages.delete') }}">
                                <i class="fas fa-trash-alt text-lg"></i>
                            </a>
                        </td>
                    </tr>

                    <x-shared.delete-modal
                        :id="'delete-modal-' . $product->id"
                        :title="__('messages.delete_product', ['name' => $product->name])"
                        message="{{ __('messages.delete_message') }}"
                        :action="route('products.destroy', $product)"
                    />
                @endforeach
                </tbody>
            </table>
        </x-shared.table>
    </div>
@endsection
