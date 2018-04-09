@component('mail::message')
  # Invoice

  Dear {{$user->name}},  

  @foreach ($invoice->campers as $camper)
    @php
      $count = $invoice->reservations->where('camper_id', $camper->id)->count();
    @endphp
    - You reserved {{$camper->first_name}} for: {{$count}} {{str_plural('day', $count)}}
  @endforeach
  Thank you for your {{str_plural('reservation', $invoice->reservations->count())}}

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
