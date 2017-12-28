@component('mail::message')
  # Invoice

  Dear {{$user->name}},  

  Thank you for your reservation!

@foreach($dates as $d)
- You reserved {{$d['camper']}} for:
@if ($d['dates']->count() >= 5)
  - {{$d['dates']->count() . ' days'}}
@else
@foreach($d['dates'] as $x)
  - {{$x}}  
@endforeach
@endif
@endforeach

${{$total}} will be charged to {{$user->name."s"}} card
@if($registration)
# Registration Fee
A registration fee of ${{$registration->amount}} will be charged.  
* This fee will be refunded if you attend the work-party.
@endif

@component('mail::button', ['url' => $url])
  View Reservations
@endcomponent

{{ config('app.name') }}
@endcomponent
