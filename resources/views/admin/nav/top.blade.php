<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="/admin">Admin</a>
  <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarsExampleDefault">
    <ul class="navbar-nav ml-auto d-none d-lg-flex">
      @foreach(\App\MenuItem::childrenOf('admin top') as $item)
        @include('nav.nav-item', ['l' => $item])
      @endforeach
    </ul>

    <ul class="navbar-nav mr-auto d-lg-none">
      @foreach(\App\MenuItem::childrenOf('admin collapsed') as $item)
        @include('nav.nav-item', ['l' => $item])
      @endforeach
    </ul>

  </div>
</nav>
