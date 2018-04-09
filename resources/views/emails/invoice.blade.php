@component('mail::message')
  # Invoice

  Dear {{$user->name}},  

  Thank you for your {{str_plural('reservation', $invoice->reservations->count())}}

  @foreach($invoice->reservations as $reservation)
    @php
      dd($reservation->count());
    @endphp

    - You reserved {{$reservation->camper->first_name}} for: {{$reservation->count()}}
    {{str_plural('day', $reservation->count())}}

  @endforeach

${{$invoice->total}} will be charged to {{$user->name."'s"}} card.
@if($invoice->registration_fee)
  # Registration Fee
  A registration fee of ${{$registration}} will be charged.  
  * This fee will be refunded if you attend the work-party.
@endif

<p class="text-center">
  EIN: 20-1292071
</p>

@component('mail::button', ['url' => $url])
  View Reservations
@endcomponent

{{ config('app.name') }}
@endcomponent
