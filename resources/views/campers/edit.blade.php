@extends('layouts.app')

@section('content')

  <h1 class="h3">
    Camper Registration
  </h1>

  <br>

  {{ Form::model($item, ['method' => 'PUT', 'route' => ["campers.update", $item->id]]) }}

  @foreach ($fields as $name => $rules)
    {{ Form::bs($name, null, null, [], $rules, $model, $item) }}
  @endforeach

  <br>

  {{ Form::submit('Save', ['class' => 'btn btn-primary mr-2']) }}
  {{ link_to_route('campers.index', 'Cancel') }}

  {{ Form::close() }}

  <br>

@endsection
