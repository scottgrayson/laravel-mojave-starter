@extends('layouts.app')

@section('content')
  <div>
    <div class="card col-lg-4 mx-auto">
      <h5 class="card-title text-center pt-2 my-auto">
        {{$invoice->reservations->first()->camper->first_name}}
        {{$invoice->reservations->first()->camper->last_name}}
      </h5>
      <hr>
      <p class="text-center">
        Total: ${{$invoice->total}}
      </p>
      <p class="text-center">
        {{$invoice->reservations->count()}} {{str_plural('Reservation', $invoice->reservations->count())}}
      </p>
      <ul class="list-group py-2">
        @foreach($invoice->reservations as $reservation)
          <li class="list-group-item text-center">
            {{$reservation->date->toFormattedDateString()}}
          </li>
        @endforeach
      </ul>
      <p class="text-center lead">
        EIN: 20-1292071
      </p>
    </div>
  </div>
@endsection
