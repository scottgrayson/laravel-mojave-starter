@php
@endphp

{{ Form::model($item, ['method' => 'PUT', 'route' => ["campers.update", $item->id]]) }}

@foreach ($stepFields as $name => $rules)
  {{ Form::bs($name, null, null, [], $rules, $model, $item) }}
@endforeach

<input hidden name="form_step" value="{{ $currentStep }}"></input>

<br>

{{ Form::submit('Next', ['class' => 'btn btn-primary mr-2']) }}

{{ Form::close() }}
