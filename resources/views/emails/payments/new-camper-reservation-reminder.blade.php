@component('mail::message')
# Complete Reservations

Dear {{$user->name}},

Thank you for taking the first steps in registering your {{str_plural('child', $user->campers->count())}}  for Miss Betty's Day Camp this summer. 
Camp fills up quickly and we don't want them to lose their spot. Please log back on to missbettysdaycamp.org to select dates and make payment for your Camper.

@component('mail::button', ['url' => $url])
  Enroll
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
