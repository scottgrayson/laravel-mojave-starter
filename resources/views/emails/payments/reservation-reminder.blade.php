@component('mail::message')
# Complete Reservations

Dear {{$user->name}}, camp registration closes {{$camp->camp_start->diffForHumans()}},
we noticed you haven't completed enrollment for your campers, follow the link below to reserve camp dates

@component('mail::button', ['url' => $url])
  Enroll
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
