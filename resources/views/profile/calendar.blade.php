@extends('layouts.profile')
@section('content')
<x-calendar.calendar
    :weekDates="$weekDates"
    :events="$events"
    title="My Rental Calendar"
    addButtonLabel="+ Add Event"
    routeName="profile.calendar"
/>
@endsection