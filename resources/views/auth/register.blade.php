@extends('layouts.app')

@section('title', __('messages.register'))

@section('content')
    <div class="fixed inset-0 bg-gray-50 flex items-center justify-center">
        <section class="w-full max-w-md p-6 bg-white shadow rounded">
            <div class="text-center mb-6">
                <x-shared.logo class="w-34 mx-auto" />
                <div class="mt-2">
                    <h3 class="text-xl font-semibold">{{ __('messages.create_an_account') }}</h3>
                    <p class="text-sm text-gray-500">{{ __('messages.sign_up_to_get_started') }}</p>
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

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-5">
                    <input class="w-full p-3 text-sm bg-gray-50 outline-none rounded" type="text" name="name" value="{{ old('name') }}" placeholder="{{ __('messages.name') }}" required autofocus>
                </div>

                <div class="mb-5">
                    <input class="w-full p-3 text-sm bg-gray-50 outline-none rounded" type="email" name="email" value="{{ old('email') }}" placeholder="{{ __('messages.email_address') }}" required>
                </div>

                <div class="mb-5">
                    <input class="w-full p-3 text-sm bg-gray-50 outline-none rounded" type="password" name="password" placeholder="{{ __('messages.password') }}" required>
                </div>

                <div class="mb-5">
                    <input class="w-full p-3 text-sm bg-gray-50 outline-none rounded" type="password" name="password_confirmation" placeholder="{{ __('messages.confirm_password') }}" required>
                </div>

                <div class="mb-6">
                    <select class="w-full p-3 text-sm bg-gray-50 outline-none rounded" name="account_type" required>
                        <option value="">{{ __('messages.choose_account_type') }}</option>
                        <option value="customer" {{ old('account_type') == 'customer' ? 'selected' : '' }}>{{ __('messages.guest') }}</option>
                        <option value="private_advertiser" {{ old('account_type') == 'private_advertiser' ? 'selected' : '' }}>{{ __('messages.private') }}</option>
                        <option value="business_advertiser" {{ old('account_type') == 'business_advertiser' ? 'selected' : '' }}>{{ __('messages.business') }}</option>
                    </select>
                </div>

                <div class="text-center">
                    <button type="submit" class="mb-2 w-full py-3 bg-green-600 hover:bg-green-700 rounded text-sm font-bold text-white transition duration-200">{{ __('messages.register') }}</button>
                    <span class="text-gray-400 text-xs">
                        {{ __('messages.already_have_account') }}
                        <a class="text-green-600 hover:underline" href="{{ route('login') }}">{{ __('messages.log_in_here') }}</a>
                    </span>
                </div>
            </form>
        </section>
    </div>
@endsection
