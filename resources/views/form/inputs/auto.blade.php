@php
  // Guess Type and Attributes

  $groupClass = '';
  $labelClass = '';
  $inputClass = '';
  $options = [];
  $model = isset($model) ? $model : get_class($item);
  $item = isset($item) ? $item : null;
  $label = $name;
  $relation = '';

  if (in_array($name, ['meta_description', 'description', 'message'])) {
    $type = 'textarea';
  } elseif (in_array('date', $rules)) {
    $type = 'date';
  } elseif (in_array($name, ['meta_tags'])) {
    $type = 'code';
  } elseif (in_array($name, ['body', 'content'])) {
    $type = 'editor';
  } elseif (in_array($name, ['email', 'password'])) {
    $type = $type ?: $name;
  } elseif ($rule = preg_grep('/in:/', $rules)) {
    $options = collect(explode(',', str_ireplace('in:', '', array_shift($rule))))
      ->mapWithKeys(function ($o) {
        return [$o => title_case(str_replace('_', ' ', $o))];
      })
      ->toArray();
    $type = 'select';
  } elseif (preg_match('/^(.*)_ids?$/', $name)) {
    $relation = '\\App\\'.studly_case(preg_replace('/_ids?/', '', $name));
    if ($relation === '\\App\\Parent') {
      $relation = $model;
    }
    $label = title_case(preg_replace('/_id/', '', $name));
    if (preg_grep('/array/', $rules)) {
      $attributes['multiple'] = 'multiple';
    }
    $type = 'relation';
  } elseif (in_array('file', $rules) || in_array('image', $rules)) {
    $inputClass .= 'form-control-file';
    $type = 'file';
  } elseif (in_array('boolean', $rules)) {
    $groupClass .= 'form-check';
    $labelClass .= 'form-check-label';
    $inputClass .= 'form-check-input';
    $type = 'checkbox';
  }

  //defaults
  $type = $type ?: 'text';
  $groupClass = $groupClass ?: 'form-group';
  $inputClass = $inputClass ?: 'form-control';

  // add error class
  if ($errors->has($name)) {
    $inputClass .= ' is-invalid ';
  }

  // check if required
  if (in_array('required', $rules)) {
    $labelClass .= 'required ';
    $attributes = array_merge($attributes, ['required' => true]);
  }

  // Render Field

  echo '<div class="'.$groupClass.'">';
  if ($type !== 'checkbox') {
    echo Form::label($label, null, ['class' => $labelClass]);
  }

  if ($type === 'password' || $name === 'password_confirmation') {
    // passwords dont have a value argument
    echo Form::password($name, array_merge(['class' => $inputClass], $attributes));
  } elseif ($type === 'relation') {
    echo Form::relation($name, null, $relation, array_merge(['class' => $inputClass], $attributes), $item);
  } elseif ($type === 'select') {
    // select has a different arg signature
    echo Form::select($name, $options, null, array_merge(['class' => $inputClass], $attributes));
  } elseif ($type === 'checkbox') {
    echo '<label class="form-check-label">';
    echo Form::checkbox($name, 1, null, array_merge(['class' => $inputClass], $attributes));
    echo $label;
    echo '</label>';
  } elseif ($type === 'file') {
    // files dont have value
    echo Form::file($name, array_merge(['class' => $inputClass], $attributes));
  } elseif ($type === 'date') {
    // date needs to be in yyyy-MM-dd format for ios
    $value = $item && $item->$name ? $item->$name->format('Y-m-d') : '';
    echo Form::date($name, $value, array_merge(['class' => $inputClass], $attributes));
  } else {
    echo Form::$type($name, $value, array_merge(['class' => $inputClass], $attributes), $item);
  }

  // render errors
  if ($errors->has($name)) {
    echo Html::ul($errors->get($name), ['class' => 'invalid-feedback']);
  }

  // close form-group
  echo '</div>';
@endphp
