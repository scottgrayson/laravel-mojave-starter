@component('mail::message')
  # Invoice

  Dear {{$user->name}},  

  Thank you for your reservation!

@foreach($dates as $d)
* You reserved {{$d['camper']->all()[0]}} for:
@if ($d['dates']->count() >= 5)
- {{$d['dates']->count() . ' days'}}
@else
@foreach($d['dates'] as $x)
- {{$x}}  
@endforeach
@endif
@endforeach

${{$total}} was charged to {{$user->name."'s"}} card on {{$payment->created_at->toDateString()}}

@component('mail::button', ['url' => $url])
  View Reservations
@endcomponent

{{ config('app.name') }}
@endcomponent
