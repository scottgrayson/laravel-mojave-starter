@component('mail::message')
  # Invoice

  Dear {{$user->name}},  

  Thank you for your {{str_plural('reservation', $invoice->reservations->count())}}

  - You reserved {{$invoice->reservations->first()->camper->first_name}} for: {{$invoice->reservations->count()}} {{str_plural('day', $invoice->reservations->count())}}

${{$invoice->total}} will be charged to {{$user->name."'s"}} card.
@if($invoice->registration_fee)
  # Registration Fee
  A registration fee of {{$invoice->registration_fee}} will be charged.  
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
