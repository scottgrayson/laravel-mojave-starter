@component('mail::message')
  # Invoice

  Dear {{$user->name}},  

  Thank you for your reservation!

  * Total: {{$total}} 

@component('mail::button', ['url' => $url])
  View Reservations
@endcomponent

{{ config('app.name') }}
@endcomponent
