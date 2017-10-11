<nav class="bg-light sidebar">
  <ul class="nav nav-pills flex-column">
    @foreach(\App\MenuItem::childrenOf('admin sidebar') as $item)
      @include('nav.nav-item', ['name' => $item->label, 'href' => $item->href])
    @endforeach
  </ul>
</nav>
