{{ Form::textarea($name, null, array_merge(['id' => $name], $attributes)) }}

@section('scripts')
  @parent
  <script>
    new SimpleMDE({
      element: document.getElementById("{{$name}}"),
      toolbar: [
        'bold',
        'italic',
        'strikethrough',
        'heading',
        /*
        'heading-smaller',
        'heading-bigger',
        'heading-1',
        'heading-2',
        'heading-3',
        'code',
        */
        'quote',
        'unordered-list',
        'ordered-list',
        'clean-block',
        'link',
        'image',
        'table',
        'horizontal-rule',
        'preview',
        /*
        'side-by-side',
        'fullscreen',
        */
        'guide',
      ]
    });

  </script>
@endsection
