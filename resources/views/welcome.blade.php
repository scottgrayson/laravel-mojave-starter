@extends('layouts.app')

@section('content')

  @component('components.focused')
    <div class="text-center">
      <h1>{{ config('app.name') }}</h1>

      <br>

      <a class="btn btn-primary" href="/register">
        Sign Up
      </a>
    </div>
  @endcomponent

@endsection
