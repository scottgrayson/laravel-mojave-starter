@extends('layouts.admin')

@section('content')
  <?php
    $acceptFiles = collect($fields)->contains(function ($rules) {
      return in_array('image', $rules) || in_array('file', $rules);
    });

    echo Form::model($item, ['files' => $acceptFiles, 'method' => 'PUT', 'route' => ["admin.$slug.update", $item->id]]);

    foreach ($fields as $name => $rules) {
      echo Form::bs($name, null, null, [], $rules, $item);
    }

    echo Form::submit('Update', ['class' => 'btn btn-primary']);

    echo Form::close();
  ?>
@endsection
