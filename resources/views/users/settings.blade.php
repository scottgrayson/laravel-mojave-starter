@extends('layouts.app')

@section('content')
  @include('crud.edit', [
    'fields' => $fields,
    'slug' => $slug,
    'model' => $model,
    'item' => $item,
  ])
@endsection
