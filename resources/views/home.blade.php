@extends('layouts.app')

@section('content')

  @component('components.focused')
    Welcome {{ auth()->user()->name }}
  @endcomponent

@endsection
