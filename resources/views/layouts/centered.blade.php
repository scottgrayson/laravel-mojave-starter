@extends('layouts.base')

@section('body')
  <div class="h-100 d-flex justify-content-center align-items-center">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-sm-8 col-md-6 col-lg-4">
          @yield('content')
        </div>
      </div>
    </div>
  </div>
@endsection

@section('style')
  <style>
    body {
      padding:0;
      margin:0;
      height:100vh;
    }

    #app {
      padding:0;
      margin:0;
      height:100vh;
    }
  </style>
@endsection
