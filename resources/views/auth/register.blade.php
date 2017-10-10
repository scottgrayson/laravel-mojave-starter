@extends('layouts.app')

@section('content')
  @component('components.focused')
    @php
      echo Form::open(['route' => 'register']);

      echo Form::bs('email');
      echo Form::bs('name');
      echo Form::bs('password');
      echo Form::bs('password_confirmation');

      echo Form::submit('Login', ['class' => 'btn btn-primary mr-2']);
      echo link_to_route('login', 'Have an account?');

      echo Form::close();
    @endphp
  @endcomponent
@endsection
