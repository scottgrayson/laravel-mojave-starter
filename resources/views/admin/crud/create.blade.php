@extends('layouts.admin')

@section('content')

  @php
    $acceptFiles = collect($fields)->contains(function ($rules) {
      return in_array('image', $rules) || in_array('file', $rules);
    });
  @endphp

  {{ Form::open(['files' => $acceptFiles, 'method' => 'POST', 'route' => "admin.$slug.store"]) }}

  @foreach ($fields as $name => $rules)
    @if (View::exists('form.inputs.'.$slug.'.'.$name))
      @include('form.inputs.'.$slug.'.'.$name)
    @else
      {{ Form::bs($name, null, null, [], $rules) }}
    @endif
  @endforeach

  {{ Form::submit('Create', ['class' => 'btn btn-primary']) }}

  {{ Form::close() }}

@endsection
