@extends('layouts.guest')

@section('content')
  @if (session('status'))
    <div class="alert-notify alert-success alert">
      {{ session('status') }}
    </div>
  @endif

  <h4>
    Reset Password
  </h4>

  <?php
    echo Form::open(['route' => 'password.email']);

    echo Form::bs('email', old('email'));

    echo Form::submit('Send Password Reset Link', ['class' => 'btn btn-primary']);

    echo Form::close();
  ?>
@endsection
