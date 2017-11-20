@if($l->children->count())

  <li class="nav-item dropdown">
    @if ($l->name === 'user dropdown')
      <button data-toggle="dropdown" class="noti dropdown-toggle btn btn-icon mb-2 mb-md-0 mr-2">
        @svg('user')
      </button>
    @else
      <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">

        {{ title_case($l->label) }}
      </a>
    @endif
    <div class="dropdown-menu {{ $l->name === 'user dropdown' ? 'dropdown-menu-md-right' : '' }}">
      @foreach ($l->children as $c)
        <a class="dropdown-item {{ $l->isActive() ? 'active' : '' }}" href="{{ $c->href }}">
          {{ title_case($c->label) }}
        </a>
      @endforeach
    </div>
  </li>

@else

  @if ($l->href === '/logout')

    <a class="nav-link" href="{{ url('/logout') }}"
      onclick="event.preventDefault();
      document.getElementById('logout-form').submit();">
      Logout
    </a>

    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
      {{ csrf_field() }}
    </form>

  @else

    <li class="nav-item {{ $l->isActive() ? 'active' : '' }}">
      <a class="nav-link {{ $l->isActive() ? 'active' : '' }}" href="{{$l->href}}">
        {{ title_case($l->label) }}
        @if ($l->href === '/notifications')
          <span class="badge badge-pill badge-danger">
        {{ auth()->user()->unread_notification_count }}
          </span>
        @endif
        @if ($l->isActive())
          <span class="sr-only">(current)</span>
        @endif
      </a>
    </li>

  @endif
@endif
