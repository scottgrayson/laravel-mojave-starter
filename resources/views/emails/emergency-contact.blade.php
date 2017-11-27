@component('mail::message')
# Emergency Contact Reminder

Dear {{$user->name}}:  

  You have registered {{$camper->name}} with an allergy condition, please print and complete the attached form before camp begins,
  campers will not be able to attend until this form has been verified.

@component('mail::button', ['url' => $url])
  View Form Online
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
