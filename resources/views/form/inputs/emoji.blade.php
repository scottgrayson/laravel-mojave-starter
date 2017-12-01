{{ Form::text($name, $value, array_merge(['id' => $name], $attributes)) }}

@section('scripts')
  @parent
  <script>
    $('#{{ $name }}').emojioneArea({
      inline: true,
      pickerPosition: 'bottom'
    });
  </script>
@endsection
