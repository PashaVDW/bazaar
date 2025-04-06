@extends('layouts.profile')

@section('content')
    <div class="max-w-7xl mx-auto mt-8">
        @if (session('success'))
            <x-shared.toast type="success" :message="session('success')" />
        @endif

        @if (session('error'))
            <x-shared.toast type="error" :message="session('error')" />
        @endif

        <x-shared.table :title="__('messages.api_tokens')">
            <x-slot:actions>
                <form method="POST" action="{{ route('developer.createToken') }}" class="flex items-center gap-3">
                    @csrf
                    <input name="token_name" type="text" placeholder="{{ __('messages.token_name') }}"
                           class="px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm text-gray-700">
                    <button type="submit"
                            class="inline-block px-6 py-3 bg-primary text-white text-sm font-medium rounded-lg hover:bg-primary/80 transition">
                        <i class="fa-solid fa-plus mr-1"></i> {{ __('messages.generate_token') }}
                    </button>
                </form>
            </x-slot:actions>

            <table class="w-full text-left table-auto">
                <thead>
                <tr>
                    <th class="pl-10 xl:pl-24 h-20 bg-white text-left text-sm font-semibold uppercase text-gray-500">{{ __('messages.token_id') }}</th>
                    <th class="text-left h-20 bg-white text-sm font-semibold uppercase text-gray-500">{{ __('messages.created') }}</th>
                    <th class="text-left h-20 bg-white text-sm font-semibold uppercase text-gray-500">{{ __('messages.token_name') }}</th>
                    <th class="text-left h-20 bg-white text-sm font-semibold uppercase text-gray-500">{{ __('messages.token') }}</th>
                    <th class="text-right h-20 bg-white text-sm font-semibold uppercase text-gray-500 pr-10">{{ __('messages.actions') }}</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y">
                @forelse ($tokens as $token)
                    <tr class="hover:bg-gray-50 border-u border-gray-100 transition">
                        <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $token->id }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $token->created_at->format('d M Y H:i') }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $token->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">
                            <div x-data="{ show: false }" class="relative">
                                <div
                                    :class="show ? '' : 'blur-sm select-none'"
                                    class="transition cursor-pointer font-mono text-xs bg-gray-100 px-2 py-1 rounded text-gray-600"
                                    @click="show = !show"
                                    title="{{ __('messages.click_to_reveal') }}"
                                >
                                    @if (isset($newTokenId) && $token->id === $newTokenId)
                                        {{ $plainTextToken }}
                                    @else
                                        {{ $token->token }}
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a data-modal-target="delete-token-{{ $token->id }}" data-modal-toggle="delete-token-{{ $token->id }}"
                               class="text-red-600 hover:text-red-800 transition cursor-pointer" title="{{ __('messages.delete') }}">
                                <i class="fas fa-trash-alt text-lg"></i>
                            </a>
                        </td>
                    </tr>
                    <x-shared.delete-modal
                        :id="'delete-token-' . $token->id"
                        :title="'Delete Token #' . $token->id . '?'"
                        :message="__('messages.delete_token_message')"
                        :action="route('developer.destroyToken', $token->id)"
                    />
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-6 text-center text-gray-500">{{ __('messages.no_tokens_found') }}</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </x-shared.table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection
