@php
  $href = isset($href) ? $href : $name;
  $active = request()->is($href.'*');
@endphp

<li class="nav-item {{ $active ? 'active' : '' }}">
  <a class="nav-link {{ $active ? 'active' : '' }}" href="{{$href}}">
    {{ title_case($name) }}
    @if ($active)
      <span class="sr-only">(current)</span>
    @endif
  </a>
</li>
