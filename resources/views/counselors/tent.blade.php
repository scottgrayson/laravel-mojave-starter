@extends('layouts.app')

@section('content')
  <my-tent
    :tent="{{ $counselorTent }}">
  </my-tent>
@endsection
