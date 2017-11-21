@extends('layouts.admin')

@section('content')
  @component('components.card')
    @include('crud.create', [
      'fields' => $fields,
      'slug' => $slug,
      'model' => $model,
    ])
  @endcomponent
@endsection
