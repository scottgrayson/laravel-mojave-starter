@extends('layouts.app')

@section('content')
  @include('crud.create', [
    'fields' => $fields,
    'slug' => $slug,
    'model' => $model,
  ])
@endsection
