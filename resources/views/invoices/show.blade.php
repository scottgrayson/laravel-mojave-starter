@extends('layouts.app')

@section('content')
  <div>
    <div class="card">
      <h5 class="card-title text-center py-2">
        {{$invoice->reservations->first()->camper->first_name}}
        {{$invoice->reservations->first()->camper->last_name}}
      </h5>
      <p class="text-center">
        {{$invoice->reservations->count()}} days reserved
      </p>
      <p class="text-center">
        From: {{$invoice->reservations->first()->date->toDayDateTimeString()}}
      </p>
      <p class="text-center">
        To: {{$invoice->reservations->last()->date->toDayDateTimeString()}}
      </p>
    </div>
  </div>
@endsection
