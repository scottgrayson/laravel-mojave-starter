@extends('layouts.base')

@section('body')
  @include('nav.default')
  <div class="mt-5 container">
      <vue-socket></vue-socket>
      @yield('content')
  </div>
  @include('footer.default')
@endsection
