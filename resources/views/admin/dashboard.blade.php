@extends('layouts.admin')

@section('content')
  @component('components.markdown')
## Testing Info

---

test accounts (you can also register your own)  

email | password | notes
--- | --- | ---
admin@dev.com | secret | has access to admin section
user@dev.com | secret | will be blocked from admin section

---

automatic emails will be captured and displayed at http://missbettys.webuildawesomesoftware.com:8025
(Other sites we are developing have emails show up here too)

---

Test cards numbers to use for checkout https://developers.braintreepayments.com/guides/credit-cards/testing-go-live/php
Test paypal account: `admin@dev.com` `secret123`

---

# Things to Test

### New User + Register Campers
1. register user
2. create/register campers
3. select days for camper
4. checkout / reserve days for camper
  - Test Cards https://developers.braintreepayments.com/guides/credit-cards/testing-go-live/php
5. check calendar to see reserved days
6. reserve more days and confirm that registration fee is only charged once

### Refunding Payments
1. Prerequisite: users who have paid registration fee
2. refund payments by one of 2 ways
  - find the specific payment in the payments section. click the eye to view. then refund
  - refund multiple users by email from the refunds section. (intended for refunding many work party attendees at once)

### Counselors
1. create a user who is not admin
2. Use admin account to add them as a counselor
3. log in as the counselor account and view the campers in their tent

### Admin editing menus
1. change the order of menus or add a new menu link
2. view a page with that menu and see that the new item was added

### Admin editing page content
1. find a page you with to change text on
2. change the text in the admin pages section

### Admin adding photos to pages
1. add a photo in the images section
2. copy the url link to that photo into a page

### Sending newsletters
1. create a newsletter in the newsletters section
2. visit http://missbettys.webuildawesomesoftware.com:8025 to see the emails sent
  @endcomponent
@endsection
