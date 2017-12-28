@extends('layouts.app')

@section('content')
  <table class="table table-responsive-md">
    <thead>
      <tr>
        <th scope="col">Date</th>
        <th scope="col">Total</th>
      </tr>
    </thead>
    <tbody>
    @foreach($invoices as $i)
      <tr>
        <td scope="row"><a href="/invoices/"+{{$i->id}}>
            {{\Carbon\Carbon::parse($i)->diffForHumans()}}
        </a></td>
        <td scope="row">{{$i->total}}</td>
      </tr>
    @endforeach
  </tbody>
  </table>
@endsection
