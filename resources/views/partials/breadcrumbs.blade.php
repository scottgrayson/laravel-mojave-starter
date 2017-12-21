@php

  $segments = collect(explode('/',request()->path()));

  $crumbs = [];

  foreach($segments as $segment) {
    if (count($crumbs)) {
      $crumbs []= end($crumbs) . '/' . $segment;
    } else {
      $crumbs []= $segment;
    }
  }
@endphp


<div class="nav-bread d-flex align-items-center mb-2 bg-white">
  @include('partials.sidebar-toggle')
  <nav class="breadcrumb border border-0 mb-0" id="navBread">
    @foreach ($crumbs as $crumb)

      @php
        if (strpos($crumb, '/')) {
          $parts = explode('/', $crumb);
          $last = end($parts);
          $crumbLabel = title_case(str_replace('-', ' ', $last));
        } else {
          $crumbLabel = title_case(str_replace('-', ' ', $crumb));
        }
      @endphp

      @if (!preg_match('/\d/', $crumbLabel))
        @if (request()->is($crumb))
          <a class="breadcrumb-item active">
            {{ $crumbLabel }}
          </a>
        @else
          <a class="breadcrumb-item" href="/{{ $crumb }}">
            {{ $crumbLabel }}
          </a>
        @endif
      @endif
    @endforeach
  </nav>
</div>
