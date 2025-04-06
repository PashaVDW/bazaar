@extends('layouts.app')

@section('content')
    @foreach ($components as $component)
        @php
            $componentId = $component->id;
            $componentSettings = $settings[$componentId] ?? [];
        @endphp

        @include($component->view_path, array_merge($componentSettings, [
            'ads' => $ads,
            'reviews' => $reviews,
            'business' => $business,
            'logo' => $logo,
        ]))
    @endforeach
@endsection
