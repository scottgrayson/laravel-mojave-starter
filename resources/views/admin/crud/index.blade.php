@extends('layouts.admin')

@section('content')
  @component('components.card')
    @include('crud.index', [
      'cols' => $cols,
      'slug' => $slug,
      'model' => $model,
      'orderable' => $orderable,
      'items' => $items,
    ])
  @endcomponent
@endsection
