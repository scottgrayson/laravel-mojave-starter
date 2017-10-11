@if($l->children()->count())
  <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
      {{ title_case($l->label) }}
    </a>
    <div class="dropdown-menu">
      @foreach ($l->children as $c)
        <a class="dropdown-item {{ (request()->is($c->href.'*')) ? 'active' : '' }}" href="{{ $c->href }}">
          {{ title_case($c->label) }}
        </a>
      @endforeach
    </div>
  </li>
@else
  <li class="nav-item {{ (request()->is($l->href.'*')) ? 'active' : '' }}">
    <a class="nav-link {{ (request()->is($l->href.'*')) ? 'active' : '' }}" href="{{$l->href}}">
      {{ title_case($l->label) }}
      @if (request()->is($l->href.'*'))
        <span class="sr-only">(current)</span>
      @endif
    </a>
  </li>
@endif
