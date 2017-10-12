<footer class="footer">
  <div class="container">
    <div class="row">
      <div class="col d-none d-sm-inline">
        <img height="80px" src="{{ asset('uploads/desert_logo.svg') }}"/>
        <h3 class="d-inline pl-2">
          {{ config('app.name') }}
        </h3>
      </div>
      <div class="col text-right">
        @foreach(\App\MenuItem::childrenOf('footer') as $item)
          <a href="{{$item->href}}">
            {{ title_case($item->label) }}
          </a>
        @endforeach
      </div>
    </div>
  </div>
</footer>
