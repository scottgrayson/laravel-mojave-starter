@extends('layouts.admin')

@section('content')
  @component('components.card')
    <div class="d-flex justify-content-between">
      <h1 class="h3">
        {{ $user->name }}
      </h1>
      <a href="{{ route('impersonate', $user->id) }}"class="btn btn-secondary">
        Impersonate
      </a>
    </div>

    <br>

    <p>
      <b>Email:</b>
      {{ $user->email }}
    </p>

    <p>
      @if($user->campers->count())
        <b>Campers:</b>
        <ul>
          @foreach($user->campers as $camper)
            <li>
              <a href="/admin/users/{{$camper->id}}/edit">
                {{ $camper->name }}
              </a>
            </li>
          @endforeach
        </ul>
      @else
        <div class="alert alert-info">
          {{ $user->name }} has not registered campers
        </div>
      @endif
    </p>

    <p>
      <b>Payments:</b>
      @if($user->payments->count())
        <ul>
          @foreach($user->payments as $payment)
            <li>
              {{ $payment->amount }}
              {{ $payment->type }}
              {{ $payment->created_at }}
              <a href="/admin/payments/{{$payment->id}}">
                View
              </a>
            </li>
          @endforeach
        </ul>
      @else
        <div class="alert alert-info">
          {{ $user->name }} has not made any payments
        </div>
      @endif
    </p>
  @endcomponent
@endsection
