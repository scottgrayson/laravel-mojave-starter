<div class="container">
  <div class="row">
    <div class="col">
      <div class="card">
      <div class="break-word card-body">

      <h2 class="card-title">
        About Us
      </h2>
        {!! $content !!}
      </div>
    </div>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <div class="d-flex flex-column flex-lg-row align-items-center">
        <a href="/your-tent" class="p-2 text-center">
          <p class="lead card-text">Your Tent</p>
          @svg('tent', 'svg-camp-icon')
        </a>
        <a href="/wood-shop" class="p-2 text-center">
          <p class="lead">Wood Shop</p>

          @svg('lodge', 'svg-camp-icon')
        </a>
        <a href="/art-barn" class="p-2 text-center">
          <p class="lead">Art Barn</p>
          @svg('cabin', 'svg-camp-icon')
        </a>
        <a href="/clay-barn" class="p-2 text-center">
          <p class="lead">Clay Barn</p>
          @svg('picnic', 'svg-camp-icon')
        </a>
        <a href="/museum" class="p-2 text-center">
          <p class="lead">Museum</p>
          @svg('fishing-rod', 'svg-camp-icon')
        </a>
        <a href="/theatre" class="p-2 text-center">
          <p class="lead">Theatre</p>
          @svg('flashlight', 'svg-camp-icon')
        </a>
        <a href="/creek" class="p-2 text-center">
          <p class="lead">Creek</p>
          @svg('canoe', 'svg-camp-icon')
        </a>
        <a href="/games-and-contests" class="p-2 text-center">
          <p class="lead">Games</p>
          @svg('map', 'svg-camp-icon')
        </a>
        <a href="/special-events" class="p-2 text-center">
          <p class="lead">Events</p>
          @svg('marshmallow', 'svg-camp-icon')
        </a>
      </div>
    </div>
  </div>
</div>
