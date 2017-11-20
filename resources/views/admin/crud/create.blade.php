@extends('layouts.admin')

@section('content')
  <div class="card">
    <div class="card-body">
      @include('crud.create', [
        'fields' => $fields,
        'slug' => $slug,
        'model' => $model,
      ])
    </div>
  </div>
@endsection
