@php
  $path = isset($path) ? $path : $name;
  $active = request()->is($path.'*');
@endphp

<li class="nav-item {{ $active ? 'active' : '' }}">
  <a class="nav-link {{ $active ? 'active' : '' }}" href="/{{$path}}">
    {{ title_case($name) }}
    @if ($active)
      <span class="sr-only">(current)</span>
    @endif
  </a>
</li>
