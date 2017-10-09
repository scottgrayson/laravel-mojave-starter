@extends('layouts.base')

@section('body')
  @include('admin.nav.top')
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-3 col-md-2 d-none d-sm-block">
        @include('admin.nav.sidebar')
      </div>

      <main class="col-sm-9 ml-sm-auto col-md-10 pt-3" role="main">
        @yield('content')
      </main>
    </div>
  </div>
@endsection
