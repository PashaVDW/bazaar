@extends('layouts.profile')

@section('content')
    <div class="max-w-7xl mx-auto mt-8">
        <x-shared.view-switch
        left-label="Advertisements Overview"
        right-label="Advertisements Calendar"
        left-route="advertisements.index"
        right-route="advertisements.ad-calendar"
        switch-key="switch"
        />
    </div>
    <x-calendar.calendar
        :weekDates="$weekDates"
        :events="$events"
        title="Ad Expiry Overview"
        routeName="advertisements.ad-calendar"
        firstEventName="Ad Start: "
        secondEventName="Ad Expiry: "
        />
@endsection
