@extends('layouts.base')

@section('body')
  @include('nav.default')
  <div class="mt-5 container">
    @yield('content')
  </div>
  @include('footer.default')
@endsection

@section('style')
  <style>
    body {
      background-color: white;
    }
  </style>
@endsection
