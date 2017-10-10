@extends('layouts.app')

@section('content')
  @component('components.focused')
    <h4>
      New Password
    </h4>

    <?php
      echo Form::open(['route' => 'password.request']);

      echo Form::hidden('token', $token);
      echo Form::bs('email', null, $email ?: old('email'));
      echo Form::bs('password');
      echo Form::bs('password_confirmation');

      echo Form::submit('Login', ['class' => 'btn btn-primary']);

      echo Form::close();
    ?>
  @endcomponent
@endsection
