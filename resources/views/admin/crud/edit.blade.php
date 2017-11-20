@extends('layouts.admin')

@section('content')
  <div class="card">
    <div class="card-body">
      @include('crud.edit', [
        'fields' => $fields,
        'slug' => $slug,
        'model' => $model,
        'item' => $item,
      ])
    </div>
  </div>
@endsection
