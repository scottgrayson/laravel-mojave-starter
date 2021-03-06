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
      <ul class="mr-auto navbar-nav d-md-none">
        @foreach(\App\MenuItem::childrenOf('nav collapsed ' . (auth()->check() ? 'user' : 'guest')) as $link)
            @include('nav.nav-item', ['l' => $link])
          @endforeach
      </ul>

      <ul class="mr-auto navbar-nav d-none d-md-flex">
        @foreach(\App\MenuItem::childrenOf('nav left') as $link)
          @include('nav.nav-item', ['l' => $link])
        @endforeach
      </ul>

      {{-- NAV RIGHT --}}
      <ul class="navbar-nav d-none d-md-flex">
        @include('nav.nav-right')
      </ul>
    </div>
  </div>
</nav>
