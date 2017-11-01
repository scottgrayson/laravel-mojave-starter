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
    'wording' => [
      'tent_id' => ['help' => 'Choose the grade that the camper has completed. Not the grade for the upcoming year.'],
    ],
  ])


  <br>

  {{ Form::submit('Create', ['class' => 'btn btn-primary mr-2']) }}
  {{ link_to_route('campers.index', 'Cancel') }}

  {{ Form::close() }}

  <br>
@endsection
