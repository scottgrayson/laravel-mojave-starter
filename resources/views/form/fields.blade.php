@foreach ($fields as $name => $rules)
  {{
    Form::bs(
      $name,
      null,
      null,
      [],
      $rules,
      $model,
      isset($item) ? $item : null,
      isset($wording[$name]) ? $wording[$name] : []
    )
  }}
@endforeach

