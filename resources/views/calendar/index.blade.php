@extends('layouts.app')

@section('content')
  <h1 class="h2">
    Camp Calendar
  </h1>

  <br>

  <div id='calendar'></div>

@endsection

@section('scripts')
  @parent
  <script>
    $(document).ready(function() {

      $('#calendar').fullCalendar({
        weekends: false,
        header: {
          left: 'title',
          right: 'prev,next',
        },
        defaultDate: "{{ $camp->camp_start }}",
        // themeSystem: 'bootstrap3'
      })

    });
  </script>
@endsection
