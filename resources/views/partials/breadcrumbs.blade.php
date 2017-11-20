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

  function isActive($crumb) {
    return request()->is($crumb);
  }

  function crumbLabel($crumb) {
    if (strpos($crumb, '/')) {
      $parts = explode('/', $crumb);
      $last = end($parts);
      return title_case(str_replace('-', ' ', $last));
    } else {
      return title_case(str_replace('-', ' ', $crumb));
    }
  }

@endphp
<ol class="breadcrumb">
  @foreach ($crumbs as $crumb)
    @if (!preg_match('/\d/', crumbLabel($crumb)))
      @if (request()->is($crumb))
        <li class="breadcrumb-item active">
          {{ crumbLabel($crumb) }}
        </li>
      @else
        <li class="breadcrumb-item">
          <a href="/{{ $crumb }}">
            {{ crumbLabel($crumb) }}
          </a>
        </li>
      @endif
    @endif
  @endforeach
</ol>
