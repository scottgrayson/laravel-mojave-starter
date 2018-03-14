@php
if (isset($attributes['class'])) {
    $attributes['class'] = $attributes['class'] . ' datepicker';
} else {
    $attributes['class'] =  'datepicker';
}
@endphp

{{-- Form::input($name, $value, $attributes) --}} 
<input placeholder="Pick a date" id="{{$name}}-datepicker" name="{{$name}}"
       value="{{$value}}"
       @foreach($attributes as $k => $v)
       {{$k}}="{{$v}}"
       @endforeach
       >

@section('scripts')
  @parent
  <script>
    $(document).ready(function() {
      $("#{{$name}}-datepicker").datepicker({
	// sub 10 years to show relavant years first
	date: moment().subtract('10', 'years').toDate(),
	format: 'yyyy-mm-dd',
	// pick year > month > day
	startView: 2
      })
    })
  </script>
@endsection
