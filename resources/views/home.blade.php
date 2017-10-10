@extends('layouts.app')

@section('content')

  <div class="text-center">

    <br>

    <div class="row">
      <div class="col-md-8 ml-md-auto mr-md-auto">
        Welcome {{ auth()->user()->name }}
      </div>
    </div>

    <br>
  </div>

@endsection
