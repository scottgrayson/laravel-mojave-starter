@extends('layouts.admin')

@section('content')
  @include('crud.index', [
    'cols' => $cols,
    'slug' => $slug,
    'model' => $model,
    'orderable' => $orderable,
    'items' => $items,
  ])
@endsection
