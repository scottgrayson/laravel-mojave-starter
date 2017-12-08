<div class="container">
  <div class="row">
    <div class="col-sm">
      <h2>
        About Us
      </h2>

      {!! $content or 'description here' !!}

      <div class="d-flex justify-content-center">
        <a href="/about" class="btn btn-primary">
          More
        </a>
      </div>

    </div>

    <div class="col-sm">
      <h2>
        Activities
      </h2>
      <ul class="list-group">
        @foreach(\App\MenuItem::childrenOf('activities') as $link)
          <a class="list-group-item list-group-item-action" href="{{ $link->href }}">{{ title_case($link->label) }}</a>
        @endforeach
      </ul>
    </div>
  </div>
</div>
