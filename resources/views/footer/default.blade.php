<footer class="footer">
  <div class="container h-100">
    <div class="row h-100">
      <div class="col h-100 d-none d-md-flex align-items-center">
        <img height="80px" src="{{ asset('uploads/desert_logo.svg') }}"/>
        <h3 class="d-inline pl-3">
          {{ config('app.name') }}
        </h3>
      </div>
      <div class="col h-100">
        <nav class="nav h-100 justify-content-end align-items-center">
          @foreach(\App\MenuItem::childrenOf('footer') as $item)
            <a class="nav-link" href="{{$item->href}}">
              {{ title_case($item->label) }}
            </a>
          @endforeach
        </nav>
      </div>
    </div>
  </div>
</footer>
