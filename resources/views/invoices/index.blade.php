@extends('layouts.app')

@section('content')
  <table class="table table-responsive-md">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Date</th>
        <th scope="col">Total</th>
        <th scope="col">Camper</th>
      </tr>
    </thead>
    <tbody>
    @foreach($invoices as $i)
      <tr>
        <td scope="row">{{$loop->iteration}}</td>
        <td scope="row"><a href="{{route('invoices.show', $i)}}">
            {{\Carbon\Carbon::parse($i->created_at)->toDayDateTimeString()}}
        </a></td>
        <td scope="row">$ {{$i->total}}</td>
        <td scope="row">{{\App\Camper::find($i->reservations->first()->camper_id)->first_name}}</td>
      </tr>
    @endforeach
  </tbody>
  </table>
@endsection
