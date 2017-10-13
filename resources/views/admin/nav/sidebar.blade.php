<nav class="bg-light sidebar">
  <ul class="nav nav-pills flex-column">
    @foreach(\App\MenuItem::childrenOf('admin sidebar') as $item)
      @include('nav.nav-item', ['l' => $item])
    @endforeach
  </ul>
</nav>
