@extends('layouts.base')

@section('body')
  <header class="app-header header-fixed">
    @include('admin.nav.top')
  </header>

  <div class="app-body">
    <div class="sidebar">
      @include('admin.nav.sidebar')
    </div>

    <main class="main" role="main">
      <div class="container-fluid">
        @yield('content')
      </div>
    </main>
  </div>

  <footer class="app-footer">
    <!-- Footer content here -->
  </footer>
@endsection
