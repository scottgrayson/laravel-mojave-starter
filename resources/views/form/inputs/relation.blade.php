@if($relation === '\App\File' && $item)
  {{--File or Image preview--}}
  <input hidden name="file_id" value="{{ $item->file_id }}"/>
  <div class="mb-2">
    @if($item->file && $item->file->is_image)
      <a rel="noopener noreferrer" target="_blank" href="{{ $item->file->url }}">
        <img src="{{ $item->file->url }}"/>
      </a>
    @elseif($item->file)
      <a rel="noopener noreferrer" target="_blank" class="btn btn-secondary" href="{{ $item->file->url }}">View</a>
      <span>{{ $item->file->name }}</span>
    @else
      <div class="alert alert-info">
        No file
      </div>
    @endif
  </div>

@elseif($relation === '\App\Image' && $item)
  {{-- Image preview--}}
  <input hidden name="image_id" value="{{ $item->image_id }}"/>
  @if ($item->image && $item->image->file)
    <div class="mb-2">
      <a rel="noopener noreferrer" target="_blank" href="{{ $item->image->file->url }}">
        <img src="{{ $item->image->file->url }}"/>
      </a>
    </div>
  @else
    <div class="alert alert-info">
      No image
    </div>
  @endif

@else
  {{--Normal relation--}}
  @php
    $attributes['class'] = $attributes['class'] . ' select2';
  if (!isset($attributes['required']) && !isset($attributes['multiple'])) {
    $attributes['placeholder'] = 'None';
  }
  echo Form::select(
    $name . (isset($attributes['multiple']) ? '[]' : ''),
    $relation::pluck($relation::label(), 'id'),
    null,
    $attributes
  );
@endphp

@section('scripts')
  @parent
  <script>
    $(document).ready(function() {
      $(".select2").select2();
    });
  </script>
@endsection

@endif
