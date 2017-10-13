@extends('layouts.admin')

@section('content')
  @include('crud.order', [
    'items' => $items,
    'slug' => $slug,
  ])
@endsection
