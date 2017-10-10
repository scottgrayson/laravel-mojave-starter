@php
  // TODO replace with admin managed menu
  if (auth()->check()) {
    $navItems = [
      ['name' => 'home', 'href' => '/home'],
    ];
  } else {
    $navItems = [
      ['name' => 'home', 'href' => '/'],
    ];
  }
@endphp

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
        @foreach ($navItems as $link)
          @include('nav.nav-item', ['name' => $link['name'], 'path' => $link['href']])
        @endforeach
      </ul>

      {{-- NAV RIGHT --}}
      @include('nav.nav-right')
    </div>
  </div>
</nav>
