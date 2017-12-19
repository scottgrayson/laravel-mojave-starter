@extends('layouts.base')

@section('body')
  @include('nav.default')
  <div style="padding-top:115px" class="container bg-white">
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
