@extends('layouts.app')

@section('content')

  <camp-calendar
    :camp-dates="{{ \App\CampDates::current()->toJson() }}"
    :tents="{{ \App\Tent::all()->toJson() }}"
    :campers="{{ auth()->check() ? auth()->user()->campers->toJson() : json_encode([]) }}"
    :reservations="{{ $reservations->toJson() }}"
    :availabilities="{{ \App\CampDates::availabilities()->toJson() }}"
    ></camp-calendar>

  <br>

@endsection
