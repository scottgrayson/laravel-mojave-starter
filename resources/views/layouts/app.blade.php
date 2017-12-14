@extends('layouts.base')

@section('body')
  @include('nav.default')
  <div style="margin-top:100px" class="container">
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
