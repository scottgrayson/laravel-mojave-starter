<nav class="bg-white sidebar">
  <ul class="nav nav-pills flex-column pt-2">
    @foreach(\App\MenuItem::childrenOf('admin sidebar') as $item)
      @include('nav.nav-item', ['l' => $item])
    @endforeach
  </ul>
</nav>
