@extends('layouts.app')

@section('content')
  @if (session('status'))
    <div class="alert-notify alert-success alert">
      {{ session('status') }}
    </div>
  @endif

  @component('components.focused')
    <h4>
      Reset Password
    </h4>

    <?php
      echo Form::open(['route' => 'password.email']);

      echo Form::bs('email', old('email'));

      echo Form::submit('Send Password Reset Link', ['class' => 'btn btn-primary']);

      echo Form::close();
    ?>
  @endcomponent
@endsection
