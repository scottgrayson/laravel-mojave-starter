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
      <div class="d-flex justify-content-center">
        <p class="mr-4">
          From: {{$invoice->reservations->first()->date->toFormattedDateString()}}
        </p>
        <p>
          To: {{$invoice->reservations->last()->date->toFormattedDateString()}}
        </p>
      </div>
      <div class="mx-auto">
        <a class="btn btn-link" href="{{ route('invoices.show', ['invoice' => $invoice])}}">
        Download: @svg('download')
      </a>
      </div>
    </div>
  </div>
@endsection
