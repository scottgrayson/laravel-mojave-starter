@php
  function render ($arg, $ulclass, $slug)
  {
    if ($arg instanceof Illuminate\Support\Collection) {
      echo '<ul class="' . $ulclass . ' orderable-list">';
      foreach ($arg as $item) {
        render ($item, $ulclass, $slug);
      }
      echo '</ul>';
    } else {
      echo '<li data-id="' . $arg->id . '" class="orderable-item">';
      echo title_case($arg->label)
        . ' - ' . '<a target="_blank" rel="noopener norefferer" href="'.$arg->href.'">View</a>'
        . ' - ' . '<a href="'.route("admin.$slug.edit", $arg->id).'">Edit</a>';
      if (isset($arg->children) && $arg->children->count()) {
        render($arg->children, $ulclass, $slug);
      }
      echo '</li>';
    }
  }
@endphp

{{ render($items, $ulclass, $slug) }}


@section('style')
  @parent
  <style>
    .orderable-item {
    }
    .orderable-list {
      margin-top: 0.5rem;
      margin-bottom: 0.5rem;
    }
  </style>
@endsection
