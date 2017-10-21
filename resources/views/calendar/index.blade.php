@extends('layouts.app')

@section('content')

  {{-- Props that will not change between page refresh --}}

  <camp-calendar
    :open-days="{{ $openDays->toJson() }}"
    :tents="{{ $tents->toJson() }}"
    :campers="{{ $campers->toJson() }}"
    :reservations="{{ $reservations->toJson() }}"
    ></camp-calendar>

  <br>

@endsection
