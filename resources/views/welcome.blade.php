@extends('layouts.guest')

@section('content')

  <div class="text-center">
    <h1>Welcome to {{ config('app.name') }}</h1>
    <a class="btn btn-primary" href="/login">Login</a>
  </div>

@endsection
