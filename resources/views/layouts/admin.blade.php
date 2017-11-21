@extends('layouts.base')

@section('body')
  @include('admin.nav.top')
  <div class="d-none d-lg-block">
    @include('admin.nav.sidebar')
  </div>

  <main class="admin-content" role="main">
    @include('partials.breadcrumbs')

    <div class="container-fluid">
      @yield('content')
    </div>

  </main>
@endsection
