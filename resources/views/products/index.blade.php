@extends('layouts.profile')

@section('content')
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
        @endif
    </div>

    <x-shared.table title="Your Products">
        <x-slot:actions>
            <a href="{{ route('products.create') }}"
               class="inline-block py-4 px-8 text-lg leading-6 text-white font-medium tracking-tighter font-heading text-center bg-purple-500 hover:bg-purple-600 focus:ring-2 focus:ring-purple-500 focus:ring-opacity-50 rounded-xl">
                + Add Product
            </a>
        </x-slot:actions>

        <table class="mb-10 table-auto w-full">
            <thead>
            <tr>
                <th class="pl-10 xl:pl-24 h-20 bg-white text-left text-sm font-semibold uppercase text-gray-500">Image</th>
                <th class="text-left h-20 bg-white text-sm font-semibold uppercase text-gray-500">Name</th>
                <th class="text-left h-20 bg-white text-sm font-semibold uppercase text-gray-500">Price</th>
                <th class="text-left h-20 bg-white text-sm font-semibold uppercase text-gray-500">Stock</th>
                <th class="text-left h-20 bg-white text-sm font-semibold uppercase text-gray-500">Type</th>
                <th class="text-left h-20 bg-white text-sm font-semibold uppercase text-gray-500">Ad</th>
                <th class="text-right h-20 bg-white text-sm font-semibold uppercase text-gray-500 pr-10">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($products as $product)
                <tr class="group transition hover:bg-gray-100">
                    <td class="pl-10 xl:pl-24 py-4 bg-blueGray-50">
                        @if ($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-16 h-16 object-cover rounded-md shadow-sm group-hover:scale-105 transition">
                        @else
                            <span class="text-gray-500">No Image</span>
                        @endif
                    </td>
                    <td class="py-4 bg-blueGray-50">{{ $product->name }}</td>
                    <td class="py-4 bg-blueGray-50">€{{ number_format($product->price, 2) }}</td>
                    <td class="py-4 bg-blueGray-50">{{ $product->stock }}</td>
                    <td class="py-4 bg-blueGray-50">{{ ucfirst($product->type) }}</td>
                    <td class="py-4 bg-blueGray-50">{{ $product->ad->title ?? '-' }}</td>
                    <td class="py-4 bg-blueGray-50 pr-10 text-right">
                        <a href="{{ route('products.edit', $product) }}" class="text-blue-600 hover:text-blue-800 transition mr-2">
                            <i class="fas fa-edit text-lg"></i>
                        </a>
                        <button type="button"
                                data-modal-target="delete-modal-{{ $product->id }}"
                                data-modal-toggle="delete-modal-{{ $product->id }}"
                                class="text-red-600 hover:text-red-800 transition"
                                title="Delete">
                            <i class="fas fa-trash-alt text-lg"></i>
                        </button>
                    </td>
                </tr>

                <div id="delete-modal-{{ $product->id }}" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative p-4 w-full max-w-md max-h-full">
                        <div class="relative bg-white rounded-lg shadow">
                            <button type="button"
                                    class="absolute top-3 end-2.5 text-gray-400 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                    data-modal-hide="delete-modal-{{ $product->id }}">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                            </button>
                            <div class="p-4 md:p-5 text-center">
                                <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                </svg>
                                <h3 class="mb-5 text-lg font-normal text-gray-500">
                                    Are you sure you want to delete <strong>{{ $product->name }}</strong>?
                                </h3>
                                <form method="POST" action="{{ route('products.destroy', $product) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                        Yes, I'm sure
                                    </button>
                                    <button type="button"
                                            class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700"
                                            data-modal-hide="delete-modal-{{ $product->id }}">
                                        No, cancel
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            </tbody>
        </table>
    </x-shared.table>

    <script src="https://unpkg.com/flowbite@1.6.5/dist/flowbite.min.js"></script>
@endsection
