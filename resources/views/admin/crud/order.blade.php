@extends('layouts.admin')

@section('content')
  @component('components.card')
    @include('crud.order', [
      'items' => $items,
      'slug' => $slug,
    ])
  @endcomponent
@endsection
