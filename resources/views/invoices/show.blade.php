@extends('layouts.app')

@section('content')
  <div>
    {{\App\Camper::find($invoice->reservations->first()->camper_id)->first_name}}
    {{\App\Camper::find($invoice->reservations->first()->camper_id)->last_name}}
    {{$invoice->reservations->count()}} reservations
  </div>
@endsection
