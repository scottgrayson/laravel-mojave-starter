@extends('layouts.admin')

@section('content')
  <div class="card">
    <div class="card-body">
      @include('crud.index', [
        'cols' => $cols,
        'slug' => $slug,
        'model' => $model,
        'orderable' => $orderable,
        'items' => $items,
      ])
  </div>
</div>
@endsection
