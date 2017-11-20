@extends('layouts.admin')

@section('content')
  <div class="card">
    <div class="card-body">
      @include('crud.order', [
        'items' => $items,
        'slug' => $slug,
      ])
    </div>
  </div>
@endsection
