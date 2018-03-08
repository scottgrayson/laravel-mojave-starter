@extends('layouts.base')

@section('body')
  @include('nav.default')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-sm-8 col-md-6 col-lg-4">
        @yield('content')
      </div>
    </div>
  </div>
  @include('footer.default')
@endsection
