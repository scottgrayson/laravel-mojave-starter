@php
  function render ($arg, $ulclass)
  {
    if ($arg instanceof Illuminate\Support\Collection) {
      echo '<ul class="' . $ulclass . '">';
      foreach ($arg as $item) {
        render ($item, $ulclass);
      }
      echo '</ul>';
    } else {
      echo '<li data-id="' . $arg->id . '">';
      echo $arg->label;
      if (isset($arg->children) && $arg->children->count()) {
        render($arg->children, $ulclass);
      }
      echo '</li>';
    }
  }
@endphp

{{ render($items, $ulclass) }}

