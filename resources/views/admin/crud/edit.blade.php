@extends('layouts.admin')

@section('content')
  @component('components.card')
    @include('crud.edit', [
      'fields' => $fields,
      'slug' => $slug,
      'model' => $model,
      'item' => $item,
    ])
  @endcomponent
@endsection
