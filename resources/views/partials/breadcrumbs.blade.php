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

<ol class="breadcrumb">
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
        <li class="breadcrumb-item active">
          {{ $crumbLabel }}
        </li>
      @else
        <li class="breadcrumb-item">
          <a href="/{{ $crumb }}">
            {{ $crumbLabel }}
          </a>
        </li>
      @endif
    @endif
  @endforeach
</ol>
