<nav class="navbar navbar-expand-md navbar-light bg-light navbar-bordered fixed-top">
  <div class="container">
    <a class="navbar-brand" href="/home">
      <img height="40px" src="{{ asset('uploads/desert_logo.svg') }}"/>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
      {{-- NAV LEFT --}}
      <ul class="mr-auto navbar-nav">
        @foreach(\App\MenuItem::childrenOf('top') as $link)
          @include('nav.nav-item', ['l' => $link])
        @endforeach
      </ul>

      {{-- NAV RIGHT --}}
      @include('nav.nav-right')
    </div>
  </div>
</nav>
