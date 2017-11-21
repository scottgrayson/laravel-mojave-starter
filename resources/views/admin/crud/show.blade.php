@extends('layouts.admin')

@section('content')
  @component('components.card')
    @include('crud.show', [
      'item' => $item,
    ])
  @endcomponent
@endsection
