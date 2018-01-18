@extends('layouts.base')

@section('body')
  @include('nav.default')
  <div class="container bg-white" style="padding-top: 50px;">
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
