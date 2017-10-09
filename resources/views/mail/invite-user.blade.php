@component('mail::message')
# Create your {{ config('app.name') }} account

@component('mail::button', ['url' => $url])
Create Your Account
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
