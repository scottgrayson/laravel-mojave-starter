@extends('layouts.app')

@section('content')
  @component('components.focused')
        <h1 class="h4">Register</h1>

        {{ Form::open(['route' => 'register']) }}

        {{ Form::bs('email') }}
        {{ Form::bs('name') }}
        {{ Form::bs('password') }}
        {{ Form::bs('password_confirmation') }}

        {{ Form::submit('Register', ['class' => 'btn btn-primary mr-2']) }}
        {{ link_to_route('login', 'Have an account? Login here.') }}

        {{ Form::close() }}
  @endcomponent
@endsection
