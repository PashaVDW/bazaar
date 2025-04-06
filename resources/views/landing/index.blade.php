@extends('layouts.profile')

@section('content')
<div class="max-w-5xl mx-auto mt-12">
    @if (!$landingPage)
        <div class="bg-white border-4 border-dashed border-gray-300 rounded-xl p-16 text-center shadow-sm">
            <h2 class="text-2xl font-bold mb-4">No Landing Page Yet</h2>
            <p class="text-gray-600 mb-6">Start building your custom landing page using prebuilt components.</p>
            <a href="{{ route('landing.create') }}" class="bg-primary text-white px-6 py-3 rounded hover:bg-orange-600">
                Create Landing Page
            </a>
        </div>
    @else
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold">Your Landing Page</h2>
            <a href="{{ route('landing.edit') }}" class="bg-primary text-white px-4 py-2 rounded hover:bg-orange-600">Edit Page</a>
        </div>
        <div class="border border-gray-300  rounded p-4 shadow-sm">
            @include('layouts.app')
            @foreach ($landingPage->components as $component)
                @php
                    $settings = $component->pivot->settings ? json_decode($component->pivot->settings, true) : [];
                @endphp
                @include($component->view_path, array_merge($settings, [
                    'ads' => \App\Models\Ad::where('user_id', auth()->id())->take(4)->get(),
                    'reviews' => [],
                    'logo' => $landingPage->logo_path,
                ]))
            @endforeach
        </div>
    @endif
</div>
@endsection
