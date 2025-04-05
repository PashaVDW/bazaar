@extends('layouts.app')

@section('content')
    @foreach ($components as $component)
        @php
            $componentId = $component->id;
            $componentSettings = $settings[$componentId] ?? [];

            $componentData = array_merge($componentSettings, [
                'ads' => $ads,
                'reviews' => $reviews,
                'business' => $business,
                'logo' => $logo,
                'preview' => true,
            ]);
        @endphp

        @include($component->view_path, $componentData)
    @endforeach
@endsection
