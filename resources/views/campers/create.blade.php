@extends('layouts.app')

@section('content')

  <h1 class="h3">
    New Camper
  </h1>

  <br>

  {{ Form::open(['method' => 'POST', 'route' => "campers.store"]) }}

  @include('form.fields', [
    'fields' => $fields,
    'model' => $model,
  ])


  <br>

  {{ Form::submit('Create', ['class' => 'btn btn-primary mr-2']) }}
  {{ link_to_route('campers.index', 'Cancel') }}

  {{ Form::close() }}

  <br>
@endsection
