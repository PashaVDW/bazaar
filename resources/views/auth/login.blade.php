@extends('layouts.app')

@section('title', __('messages.login'))

@section('content')
    <div class="fixed inset-0 bg-gray-50 flex items-center justify-center">
        <section class="w-full max-w-md p-6 bg-white shadow rounded">
            <div class="text-center mb-6">
                <x-shared.logo class="w-34 mx-auto" />
                <div class="mt-2">
                    <h3 class="text-xl font-semibold">{{ __('messages.welcome_back') }}</h3>
                    <p class="text-sm text-gray-500">{{ __('messages.log_in_to_your_account') }}</p>
                </div>
            </div>

            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-100 text-red-600 rounded text-sm">
                    <strong>{{ __('messages.errors') }}:</strong>
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-5">
                    <input class="w-full p-3 text-sm bg-gray-50 outline-none rounded" id="email" type="email" name="email" value="{{ old('email') }}" placeholder="{{ __('messages.email_address') }}" required autofocus>
                </div>

                <div class="mb-5">
                    <input class="w-full p-3 text-sm bg-gray-50 outline-none rounded" id="password" type="password" name="password" placeholder="{{ __('messages.password') }}" required>
                </div>

                <button type="submit" class="w-full py-3 bg-green-600 hover:bg-green-700 rounded text-sm font-bold text-white transition">{{ __('messages.login') }}</button>

                <p class="mt-3 text-xs text-center text-gray-500">
                    {{ __('messages.dont_have_account') }}
                    <a href="{{ route('register') }}" class="text-green-600 hover:underline">{{ __('messages.register_here') }}</a>
                </p>
            </form>
        </section>
    </div>
@endsection
