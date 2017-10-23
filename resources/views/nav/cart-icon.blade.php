<li class="nav-item {{ (request()->is($l->href.'*')) ? 'active' : '' }}">
  <a class="mr-2 btn btn-icon {{ (request()->is($l->href.'*')) ? 'active' : '' }}" href="{{$l->href}}">
    <cart-count class="cart-count"
      initial-count="{{ Cart::content()->count() }}"></cart-count>
    @svg('cart', 'xl')
  </a>
</li>
