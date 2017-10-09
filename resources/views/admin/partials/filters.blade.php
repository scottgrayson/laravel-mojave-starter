@php
  $filterCols = preg_replace('/_id$/', '', $cols);
@endphp
{{ Form::open(['url' => request()->path(), 'method' => 'get', 'class' => 'form-inline']) }}
<p class="text-muted">
  Prefix based search
</p>
<div class="row">
  @foreach($filterCols as $c)
    <div class="col-md-6 col-lg-4 col-xl-3 mb-2">
      {{ Form::text("q.".$c, null, ['placeholder' => str_replace('_', ' ', title_case($c)), 'class' => 'mr-1 form-control']) }}
    </div>
  @endforeach
</div>
{{ Form::submit('Search', ['class' => 'btn btn-primary']) }}
<a class="ml-1 btn btn-secondary" href="/{{ request()->path() }}">
  Reset
</a>
{{ Form::close() }}
