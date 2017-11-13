@foreach ($fields as $name => $rules)
  {{
    Form::bs(
      $name,
      null,
      null,
      [],
      $rules,
      isset($model) ? $model : null,
      isset($item) ? $item : null,
      isset($wording[$name]) ? $wording[$name] : []
    )
  }}
@endforeach

