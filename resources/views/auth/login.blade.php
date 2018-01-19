@extends('layouts.app')

@section('content')
  @component('components.focused')
    <div class="card mt-4">
      <div class="card-header">
        <h1 class="h4">
          Login
        </h1>
      </div>
      <div class="card-body">

        {{ Form::open(['route' => 'login']) }}

        {{ Form::bs('email') }}
        {{ Form::bs('password') }}

        {{ Form::submit('Login', ['class' => 'btn btn-primary mr-2']) }}
        {{ link_to_route('register', 'Register new account') }}
        <p class="mt-2">
          {{ link_to_route('password.request', 'Forgot your password?') }}
        </p>

        {{ Form::close() }}
      </div>
    </div>
  @endcomponent
@endsection
