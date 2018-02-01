@component('mail::message')
# Registration

Dear {{$user->name}}, camp registration closes {{$camp->camp_end->diffForHumans()}},
we noticed you haven't completed enrollment for your campers, follow the link below to reserve camp dates

@component('mail::button', ['url' => $url])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
