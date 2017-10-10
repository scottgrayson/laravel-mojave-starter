@if (auth()->check())

  @include('nav.notifications', ['notifications' => auth()->user()->unreadNotifications])

  <a class="btn btn-outline-secondary" href="{{ url('/logout') }}"
    onclick="event.preventDefault();
    document.getElementById('logout-form').submit();">
    Logout
  </a>

  <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
    {{ csrf_field() }}
  </form>

@else

  <a class="btn btn-outline-secondary" href="{{ url('/login') }}">
    Login
  </a>

@endif
