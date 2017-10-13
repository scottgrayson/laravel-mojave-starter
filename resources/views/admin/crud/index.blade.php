@extends('layouts.admin')

@section('content')
  @include('crud.index', [
    'cols' => $cols,
    'model' => $model,
    'orderable' => $orderable,
    'items' => $items,
  ])
@endsection
