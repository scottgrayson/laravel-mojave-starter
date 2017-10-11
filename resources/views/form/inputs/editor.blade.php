{{ Form::textarea($name, null, array_merge(['id' => $name], $attributes)) }}

@section('scripts')
  @parent
  <script>
var simplemde = new SimpleMDE();

  </script>
@endsection
