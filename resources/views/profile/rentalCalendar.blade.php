@extends('layouts.profile')

@section('content')
    <div class="max-w-7xl mx-auto mt-8">
        <x-shared.view-switch
        left-label="Rentals Overview"
        right-label="Rentals Calendar"
        left-route="profile.rentalHistory"
        right-route="profile.rentalCalendar"
        switch-key="switch"
        />
    </div>
    <x-calendar.calendar
        :weekDates="$weekDates"
        :events="$events"
        title="Ad Expiry Overview"
        routeName="profile.rentalCalendar"
        firstEventName="Ad Start: "
        secondEventName="Ad Expiry: "
        />
@endsection
