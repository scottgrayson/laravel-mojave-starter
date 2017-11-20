@extends('layouts.base')

@section('body')
  @include('admin.nav.top')
  <div class="container-fluid">
    <div class="row">
      <div class="p-0 col-lg-2 d-none d-lg-block">
        @include('admin.nav.sidebar')
      </div>

      <main class="col-lg-10 p-0" role="main">
        @include('partials.breadcrumbs')

        <div class="container-fluid">
          @yield('content')
        </div>

      </main>
    </div>
  </div>
@endsection
