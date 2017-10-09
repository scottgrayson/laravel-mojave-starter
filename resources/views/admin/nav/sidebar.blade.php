<nav class="bg-light sidebar">
  <ul class="nav nav-pills flex-column">
      @include('nav.nav-item', ['name' => 'users', 'path' => 'admin/users'])
      @include('nav.nav-item', ['name' => 'images', 'path' => 'admin/images'])
      @include('nav.nav-item', ['name' => 'files', 'path' => 'admin/files'])
  </ul>
  {{--<hr/>
  <ul class="nav nav-pills flex-column">
      @include('nav.nav-item', ['name' => 'settings', 'path' => 'admin/settings'])
  </ul>--}}
</nav>
