@extends('layouts.base')

<form class="container-fluid">
  <h1>
    Attendance
  </h1>

  <div class="row align-items-center">
    <div class="form-group col-md">
      <select name="tent_id" class="form-control">
        @foreach(\App\Tent::pluck('name', 'id') as $id => $name)
          <option {{ request('tent_id', 1) == $id ? 'selected' : '' }} value="{{$id}}">
            {{$name}}
          </option>
        @endforeach
      </select>
    </div>

    <div class="form-group col-md">
      <input name="start" value="{{$start->toDateString()}}" type="date" class="form-control"></input>
    </div>

    <b class="d-none d-md-flex">
      TO
    </b>

    <div class="form-group col-md">
      <input name="end" value="{{$end->toDateString()}}" type="date" class="form-control"></input>
    </div>

    <div class="form-group col-md">
      <button type="submit" class="btn btn-secondary">Submit</button>
      <a class="btn btn-link" href="/admin">Back</a>
    </div>
  </div>
</form>

<table class="attendance monospace table table-bordered table-striped">
  <tr>
    <th>
      Camper Name
      <br/>
      <small>
        ({{$tent->campers()->count()}} Campers)
      </small>
    </th>
    @foreach($dates as $date)
      <th>
        {{$date->format('D m/d')}}
        <br/>
        <small>
          ({{$tent->reservations->where('date', $date)->count()}} Campers)
        </small>
      </th>
    @endforeach
  </tr>

  @foreach($campers as $camper)
    <tr>
      <th>
        {{$camper->name}}
      </th>
      @foreach($dates as $date)
        <td>
          @if($camper->reservations->contains('date', $date))
            Not Attending
          @endif
        </td>
      @endforeach
    </tr>
  @endforeach
</table>

@section('style')
  <style>
  body.svg-background {
    background: white;
  }
  </style>
@endsection
