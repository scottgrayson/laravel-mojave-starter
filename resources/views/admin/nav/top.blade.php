<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
  <a class="navbar-brand" href="/admin">Admin</a>
  <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarsExampleDefault">
    <ul class="navbar-nav mr-auto">
      @include('nav.nav-item', ['l' => [ 'label' => 'view site', 'href' => '/']])
    </ul>

    <a class="btn btn-outline-secondary" href="{{ url('/logout') }}"
      onclick="event.preventDefault();
      document.getElementById('logout-form').submit();">
      Logout
    </a>

    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
      {{ csrf_field() }}
    </form>
  </div>
</nav>
