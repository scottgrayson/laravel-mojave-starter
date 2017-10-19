@if (auth()->check())

  @foreach(\App\MenuItem::childrenOf('nav right user') as $item)
    @if ($item->name === 'notifications dropdown')
      @include('nav.notifications', ['notifications' => auth()->user()->unreadNotifications])
    @elseif ($item->href === '/cart')
      @include('nav.cart-icon', ['l' => $item, 'itemCount' => Cart::content()->count()])
    @else
      @include('nav.nav-item', ['l' => $item])
    @endif
  @endforeach

@else

  @foreach(\App\MenuItem::childrenOf('nav right guest') as $item)
    @if ($item->name === 'login button')
      <a class="btn btn-outline-secondary" href="{{ url('/login') }}">
        Login
      </a>
    @else
      @include('nav.nav-item', ['l' => $item])
    @endif
  @endforeach

@endif
