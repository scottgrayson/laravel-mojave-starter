<nav class="bg-light sidebar">
  <ul class="nav nav-pills flex-column">
      @include('nav.nav-item', ['name' => 'users', 'path' => 'admin/users'])
      @include('nav.nav-item', ['name' => 'images', 'path' => 'admin/images'])
      @include('nav.nav-item', ['name' => 'files', 'path' => 'admin/files'])
      @include('nav.nav-item', ['name' => 'pages', 'path' => 'admin/pages'])
      @include('nav.nav-item', ['name' => 'menu-items', 'path' => 'admin/menu-items'])
      @include('nav.nav-item', ['name' => 'menu-item-order', 'path' => 'admin/menu-item-order'])
  </ul>
  {{--<hr/>
  <ul class="nav nav-pills flex-column">
      @include('nav.nav-item', ['name' => 'settings', 'path' => 'admin/settings'])
  </ul>--}}
</nav>
