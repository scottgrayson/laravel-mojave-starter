{{--Normal relation--}}
<select name="{{$name}}" class="select2 {{ $attributes['class']}}">
  @foreach($relation::all() as $option)
    <option value="{{ $option->id }}">
      {{ $option->name ?: $option->title ?: $option->id }}
    </option>
  @endforeach
</select>

@section('scripts')
  @parent
  <script>
    $(document).ready(function() {
      $(".select2").select2();
    });
  </script>
@endsection
