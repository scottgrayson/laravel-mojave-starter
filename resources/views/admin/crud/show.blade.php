@extends('layouts.admin')

@section('content')
  @include('crud.show', [
    'item' => $item,
  ])
@endsection
