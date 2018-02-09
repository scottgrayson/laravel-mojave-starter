
@component('mail::message')
# Registration

Dear {{$user->name}}, camp registration closes {{$camp->camp_start->diffForHumans()}},
we noticed you haven't completed payment for your reservations,
follow the link below to finish reservation. 

@component('mail::button', ['url' => $url])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent

