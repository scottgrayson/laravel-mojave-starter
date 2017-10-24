@extends('layouts.admin')

@section('content')
  <div class="d-flex justify-content-between">
    <h1 class="h3">
      Payment Info
    </h1>
    <a href="/admin/payments" class="btn btn-secondary">
      All Payments
    </a>
  </div>

  <p>
    <b>Braintree Transaction:</b>
    {{ $payment->transaction }}
  </p>
  <p>
    <b>User:</b>
    <a href="/admin/users/{{$payment->user->id}}/edit">
      {{ $payment->user->name }}
    </a>
  </p>
  <p>
    <b>Email:</b>
    {{ $payment->user->email }}
  </p>
  <p>
    <b>Paid At:</b>
    {{ $payment->created_at }}
  </p>
  <p>
    <b>Amount:</b>
    ${{ $payment->amount }}
  </p>

  <h4>Reservations</h4>

  <table class="table">
    <thead>
      <th>Camper</th>
      <th>Tent</th>
      <th>Date</th>
    </thead>
    <tbody>
      @foreach($reservations as $r)
        <tr>
          <td>{{ $r->camper->name }}</td>
          <td>{{ $r->tent->name }}</td>
          <td>{{ $r->date }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
@endsection
