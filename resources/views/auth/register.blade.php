@extends('layouts.app')

@section('title', 'Register')

@section('content')
    <div class="fixed inset-0 bg-gray-50 flex items-center justify-center">
        <section class="w-full max-w-md p-6 bg-white shadow rounded">
            <div class="text-center mb-6">
                <x-shared.logo class="w-34 mx-auto" />
                <div class="mt-2">
                    <h3 class="text-xl font-semibold">Create an account</h3>
                    <p class="text-sm text-gray-500">Sign up to get started</p>
                </div>
            </div>

            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-100 text-red-600 rounded text-sm">
                    <strong>Error(s):</strong>
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
                    <input class="w-full p-3 text-sm bg-gray-50 outline-none rounded" type="text" name="name" value="{{ old('name') }}" placeholder="Name" required autofocus>
                </div>

                <div class="mb-5">
                    <input class="w-full p-3 text-sm bg-gray-50 outline-none rounded" type="email" name="email" value="{{ old('email') }}" placeholder="Email Address" required>
                </div>

                <div class="mb-5">
                    <input class="w-full p-3 text-sm bg-gray-50 outline-none rounded" type="password" name="password" placeholder="Password" required>
                </div>

                <div class="mb-5">
                    <input class="w-full p-3 text-sm bg-gray-50 outline-none rounded" type="password" name="password_confirmation" placeholder="Confirm Password" required>
                </div>

                <div class="mb-6">
                    <select class="w-full p-3 text-sm bg-gray-50 outline-none rounded" name="account_type" required>
                        <option value="">-- Choose an account type --</option>
                        <option value="customer" {{ old('account_type') == 'customer' ? 'selected' : '' }}>Guest</option>
                        <option value="private_advertiser" {{ old('account_type') == 'private_advertiser' ? 'selected' : '' }}>Private</option>
                        <option value="business_advertiser" {{ old('account_type') == 'business_advertiser' ? 'selected' : '' }}>Business</option>
                    </select>
                </div>

                <div class="text-center">
                    <button type="submit" class="mb-2 w-full py-3 bg-green-600 hover:bg-green-700 rounded text-sm font-bold text-white transition duration-200">Register</button>
                    <span class="text-gray-400 text-xs">
            Already have an account?
            <a class="text-green-600 hover:underline" href="{{ route('login') }}">Log in here</a>
        </span>
                </div>
            </form>
        </section>
    </div>
@endsection
