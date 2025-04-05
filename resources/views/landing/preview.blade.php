@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    @foreach ($landingPage->components as $component)
        @php
            $settings = $component->pivot->settings ? json_decode($component->pivot->settings, true) : [];
        @endphp
        @include($component->view_path, array_merge($settings, [
            'ads' => \App\Models\Ad::where('user_id', $landingPage->business->user_id)->get(),
            'logo' => $landingPage->logo_path,
            'description' => 'Example description',
            'reviews' => [],
        ]))
    @endforeach
</div>
@endsection
