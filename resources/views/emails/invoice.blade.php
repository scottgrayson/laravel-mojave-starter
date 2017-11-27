@component('mail::message')
  # Invoice

  Dear {{$user->name}},  

  Thank you for your reservation!

  * Camper: {{$user->name}}
  * Dates: {{$user->email}}
  * Total: $ {{$total}} 

@component('mail::button', ['url' => $url])
  View Reservations
@endcomponent

{{ config('app.name') }}
@endcomponent
