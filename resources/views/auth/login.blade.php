@extends('layouts.app')

@section('content')
  @component('components.focused')
    <h1 class="h4">
      Login
    </h1>

    {{ Form::open(['route' => 'login']) }}

    {{ Form::bs('email') }}
    {{ Form::bs('password') }}

    {{ Form::submit('Login', ['class' => 'btn btn-primary mr-2']) }}
    {{ link_to_route('register', 'Register new account') }}
    <p class="mt-2">
      {{ link_to_route('password.request', 'Forgot your password?') }}
    </p>

    {{ Form::close() }}
  @endcomponent
@endsection
