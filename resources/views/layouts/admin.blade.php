@extends('layouts.base')

@section('body')
  @include('admin.nav.top')
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-2 col-xl-1 d-none d-lg-block">
        @include('admin.nav.sidebar')
      </div>

      <main class="col-lg-10 col-xl-11 pt-3" role="main">
        @yield('content')
      </main>
    </div>
  </div>
@endsection
