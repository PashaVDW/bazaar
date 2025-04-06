@extends('layouts.profile')

@section('content')
    <x-calendar.calendar
        :weekDates="$weekDates"
        :events="$events"
        title="Ad Expiry Overview"
        routeName="profile.ads.calendar"
        firstEventName="Ad Start: "
        secondEventName="Ad Expiry: "
        
    />
@endsection
