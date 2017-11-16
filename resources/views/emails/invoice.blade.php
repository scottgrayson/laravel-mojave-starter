@component('mail::message')
  # Invoice

  Thank you for your purchase of {{$total}}

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
