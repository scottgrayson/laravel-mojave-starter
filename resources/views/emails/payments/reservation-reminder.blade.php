@component('mail::message')
# Registration

Dear {{$user->name}}, camp registration closes {{$camp->camp_start->diffForHumans()}},
we noticed you haven't completed reservation for your campers,
follow the link below to finish reservation. 

@component('mail::button', ['url' => $url])
  Complete Reservations
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent

