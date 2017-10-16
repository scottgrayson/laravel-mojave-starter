@extends('layouts.app')

@section('content')

  <camp-calendar
    :camp-dates="{{ \App\CampDates::current()->toJson() }}"
    :tents="{{ \App\Tent::all()->toJson() }}"
    :campers="{{ auth()->check() ? auth()->user()->campers->toJson() : json_encode([]) }}"
    :availabilities="{{ \App\CampDates::availabilities()->toJson() }}"
    ></camp-calendar>

@endsection
