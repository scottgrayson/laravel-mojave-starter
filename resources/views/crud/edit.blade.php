@php
  $prefix = request()->is('admin*') ? 'admin.' : '';

  $acceptFiles = collect($fields)->contains(function ($rules) {
    return in_array('image', $rules) || in_array('file', $rules);
  });
@endphp

{{ Form::model($item, ['files' => $acceptFiles, 'method' => 'PUT', 'route' => [$prefix.$slug.".update", $item->id]]) }}

@foreach ($fields as $name => $rules)
  @if (View::exists('form.inputs.'.$slug.'.'.$name))
    @include('form.inputs.'.$slug.'.'.$name)
  @else
    {{ Form::bs($name, null, null, [], $rules, $model, $item) }}
  @endif
@endforeach

{{ Form::submit('Update', ['class' => 'btn btn-primary']) }}

{{ Form::close() }}
