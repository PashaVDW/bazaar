@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <div class="fixed inset-0 bg-gray-50 flex items-center justify-center">
        <section class="w-full max-w-md p-6 bg-white shadow rounded">
            <div class="text-center mb-6">
                <x-logo class="w-34 mx-auto" />
                <div class="mt-2">
                    <h3 class="text-xl font-semibold">Welcome back</h3>
                    <p class="text-sm text-gray-500">Log in to your account</p>
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

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-5">
                    <input class="w-full p-3 text-sm bg-gray-50 outline-none rounded" id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Email Address" required autofocus>
                </div>

                <div class="mb-5">
                    <input class="w-full p-3 text-sm bg-gray-50 outline-none rounded" id="password" type="password" name="password" placeholder="Password" required>
                </div>

                <button type="submit" class="w-full py-3 bg-green-600 hover:bg-green-700 rounded text-sm font-bold text-white transition">Login</button>

                <p class="mt-3 text-xs text-center text-gray-500">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="text-green-600 hover:underline">Register here</a>
                </p>
            </form>
        </section>
    </div>
@endsection
