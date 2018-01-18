<div class="container-fluid m-0" style="padding-top:98px; padding-right: 0px; padding-left: 0px;">

  @if(auth()->user()->campers()->count() == 0)
    <div class="alert alert-info mt-0 mb-0 text-center">
      Register Your Kid's For Camp
      <a href="/registration">Here</a>
    </div>

  @elseif(auth()->user()->reservations()->count() == 0)
    <div class="alert alert-success mt-0 mb-0 text-center">
      Registration Closes {{\App\Camp::current()->registration_end->diffForHumans()}}. Click 
      <a href="/calendar">Here</a> To Register
    </div>

  @elseif(auth()->user()->invoices()->count() == 0)
    <div class="alert alert-warning mt-0 mb-0 text-center">
      Pay To Reserve Your Camper's Dates 
      <a href="/checkout">Here</a>
    </div>
  @endif

</div>
