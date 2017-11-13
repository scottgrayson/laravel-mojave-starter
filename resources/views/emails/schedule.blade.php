@component('mail::message')
  # Week Of: {{\Carbon\Carbon::now()->startOfWeek()->toFormattedDateString()}}

  Follow the link below to check {{$tent->name}} schedule.

@component('mail::button', ['url' => ''])
  View Campers
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
