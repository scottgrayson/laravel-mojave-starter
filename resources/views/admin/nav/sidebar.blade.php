<div class="collapse show">
  <nav class="bg-white sidebar" id="sideNav">
    <ul class="nav nav-pills flex-column pt-2">
      @foreach(\App\MenuItem::childrenOf('admin sidebar') as $item)
        @include('nav.nav-item', ['l' => $item])
      @endforeach
    </ul>
  </nav>
</div>
