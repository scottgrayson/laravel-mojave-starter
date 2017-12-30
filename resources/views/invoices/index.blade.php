@extends('layouts.app')

@section('content')
  <p class="text-center lead">Invoices</p>
  <table class="table table-responsive-md border border-top-0">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Date</th>
        <th scope="col">Total</th>
        <th scope="col">Camper</th>
        <th scope="col">Camp Year</th>
        <th scope="col">View</th>
      </tr>
    </thead>
    <tbody>
    @foreach($invoices as $i)
      <tr>
        <td scope="row">{{$loop->iteration}}</td>
        <td scope="row"><a href="{{route('invoices.show', $i)}}">
            {{$i->created_at->toDayDateTimeString()}}
        </a></td>
        <td scope="row">$ {{$i->total}}</td>
        <td scope="row">{{$i->reservations->first()->camper->first_name}}</td>
        <td scope="row">{{$i->reservations->first()->payment->camp->camp_start->format('Y')}}</td>
        <td scope="row"><a href="{{route('invoices.show', $i)}}">
            @svg('eye')
        </a></td>
      </tr>
    @endforeach
  </tbody>
  </table>
@endsection
