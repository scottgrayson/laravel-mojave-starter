@extends('layouts.admin')

@section('content')
  @component('components.card')
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
    <p>
      <b>Type:</b>
      {{ $payment->type }}
    </p>

    @if(!$reservations->isEmpty())
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
              <td>{{ $r->camper->first_name . ' ' . $r->camper->last_name }}</td>
              <td>{{ $r->tent->name }}</td>
              <td>{{ $r->date }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @elseif ($payment->refunded)
      <div class="alert alert-info">
        Payment refunded at {{ $payment->refunded }}
      </div>
    @elseif($payment->type === 'registration_fee')
      <a class="btn btn-secondary"
        href="{{ route('admin.payments.destroy', $payment->id) }}" data-method="delete">
        Refund
      </a>
    @endif
  @endcomponent
@endsection
