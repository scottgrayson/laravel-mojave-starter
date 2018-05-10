@component('mail::message')
  # Invoice

  Dear {{$user->name}},  

  Thank you for your {{str_plural('reservation', $invoice->reservations->count())}}

  * Campers
  @foreach ($invoice->campers() as $camper)
    * {{ $camper->name }} {{ $camper->address }}
  @endforeach

${{$invoice->total}} will be charged to {{$user->name."'s"}} card.

@if($invoice->registration_fee)
  # Registration Fee
  A registration fee of ${{$registration}} will be charged.  
  * This fee will be refunded if you attend the work-party.
@endif

@component('mail::button', ['url' => $url])
  View Invoice
@endcomponent

{{ config('app.name') }}

@endcomponent

