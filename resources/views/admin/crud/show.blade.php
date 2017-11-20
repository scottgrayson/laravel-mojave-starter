@extends('layouts.admin')

@section('content')
  <div class="card">
    <div class="card-body">
      @include('crud.show', [
        'item' => $item,
      ])
    </div>
  </div>
@endsection
