@extends('layouts.base')

@section('body')
  @include('admin.nav.top')
  <div class="container-fluid">
    <div class="row">
      <div class="p-0 col-lg-2 d-none d-lg-block">
        @include('admin.nav.sidebar')
      </div>

      <main class="col-lg-10 pt-3" role="main">
        @yield('content')
      </main>
    </div>
  </div>
@endsection
