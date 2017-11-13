@component('mail::message')
# Welcome {{ $user->name }}

Thanks for registering! Follow the link below to begin camper registration.

@component('mail::button', ['url' => $url])
  Enroll Campers
@endcomponent

{{ config('app.name') }}
@endcomponent
