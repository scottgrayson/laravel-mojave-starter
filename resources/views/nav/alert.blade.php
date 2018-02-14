@if(auth()->user()->campers()->count() == 0)
  <div class="alert alert-info alert-subnav text-center">
    Register Your Kid's For Camp
    <a href="/campers/create">Here</a>
  </div>

@elseif(auth()->user()->reservations()->count() == 0)
  <div class="alert alert-success alert-subnav text-center">
    Registration Closes {{\App\Camp::current()->registration_end->diffForHumans()}}. Click 
    <a href="/calendar">Here</a> To Register
  </div>

@elseif(!(Cart::content()->isEmpty()))
  <div class="alert alert-warning alert-subnav text-center">
    Pay To Reserve Your Camper's Dates 
    <a href="/checkout">Here</a>
  </div>
@endif


