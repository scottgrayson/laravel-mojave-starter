<div class="container">
  <div class="row my-5">
    <div class="col">
      <p class="lead text-center">Activities</p>
      <div class="row flex-wrap justify-content-around">
        <a href="/your-tent" class="card activity-card">
          <p class="lead">Your Tent</p>
          @svg('tent', 'svg-camp-icon')
        </a>
        <a href="/wood-shop" class="card activity-card">
          <p class="lead">Wood Shop</p>
          @svg('lodge', 'svg-camp-icon')
        </a>
        <a href="/art-barn" class="card activity-card">
          <p class="lead">Art Barn</p>
          @svg('cabin', 'svg-camp-icon')
        </a>
        <a href="/clay-barn" class="card activity-card">
          <p class="lead">Clay Barn</p>
          @svg('picnic', 'svg-camp-icon')
        </a>
        <a href="/museum" class="card activity-card">
          <p class="lead">Museum</p>
          @svg('fishing-rod', 'svg-camp-icon')
        </a>
        <a href="/theatre" class="card activity-card">
          <p class="lead">Theatre</p>
          @svg('flashlight', 'svg-camp-icon')
        </a>
        <a href="/creek" class="card activity-card">
          <p class="lead">Creek</p>
          @svg('canoe', 'svg-camp-icon')
        </a>
        <a href="/games-and-contests" class="card activity-card">
          <p class="lead">Games</p>
          @svg('map', 'svg-camp-icon')
        </a>
        <a href="/special-events" class="card activity-card">
          <p class="lead">Events</p>
          @svg('marshmallow', 'svg-camp-icon')
        </a>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 col-lg-6 pb-4">
      <div class="card">
        <div class="break-word card-body d-flex flex-column align-items-start">
          <p class="card-title align-top">
            <strong>
              About Us
            </strong>
          </p>
          {!! $content !!}
          <div class="mt-auto">
            <p>
              <strong>Address</strong>
              <br>
              Pickering Grove Park 
              <br>
              Route 113 (between Yellow Springs and Pikeland Road)
              <br>
              Chester Springs, PA 19425
            </p>
            <strong>
              Join Our Newsletter
            </strong>
            @include('newsletter.create-form')
          </div>
        </div>
      </div>
    </div>
    <div class="col pb-4">
        <div class="card">
          <div class="embed-responsive embed-responsive-1by1">
            <iframe
              width="400"
              height="400"
              frameborder="0" style="border:0"
              src="https://www.google.com/maps/embed/v1/place?key={{ config('services.google.maps_key') }}&q=pickering+grove+park" allowfullscreen>
            </iframe>
          </div>
      </div>
    </div>
  </div>
</div>
