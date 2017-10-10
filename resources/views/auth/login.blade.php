@extends('layouts.app')

@section('content')
  @component('components.focused')
    <h4>
      Login
    </h4>

    <?php
      echo Form::open(['route' => 'login']);

      echo Form::bs('email');
      echo Form::bs('password');

      echo Form::submit('Login', ['class' => 'btn btn-primary mr-2']);
      echo link_to_route('password.request', 'Forgot your password?');

      echo Form::close();
    ?>
  @endcomponent
@endsection
