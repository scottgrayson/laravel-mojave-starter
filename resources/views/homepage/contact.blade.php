<div class="container">

  <div class="row">
    <div class="col-sm">
      <h4>
        Address
      </h4>
      <p>
        Pickering Grove Park 
      </p>
      <p>
        Route 113 (between Yellow Springs and Pikeland Road)
      </p>
      <p>
        Chester Springs, PA 19425
      </p>

      <br>

      <h4>
        Join Our Newsletter
      </h4>
      @include('newsletter.create-form')

      <br>
    </div>

    <div class="col-sm">
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
