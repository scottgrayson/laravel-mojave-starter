@extends('layouts.app')

@section('content')
  <h1 class="h3">
    My Cart
  </h1>

  <br>

  @if($noReservations)

    <div class="alert alert-info">
      <h4>
        Your Cart Is Empty
      </h4>
      <div class="d-flex justify-content-between align-items-center">
        <span>
          Go to our calendar to reserve days for your campers.
        </span>

        <a href="/calendar" class="btn btn-outline-info">
          Calendar
        </a>
      </div>
    </div>

  @else

    <span class="lead">
      Prices:
    </span>
    <ul>
      @foreach($rates as $rate)
        <li>
          {{ $rate->description }}
        </li>
      @endforeach
    </ul>

    <br>

    <table class="table">
      <thead>
        <tr>
          <th>Camper</th>
          <th>Qty</th>
          <th>Rate</th>
          <th>Subtotal</th>
          <th>Edit</th>
        </tr>
      </thead>
      <tbody>
        @foreach($items as $item)
          <tr>
            @if (isset($item->feeNotice))
              <td colspan="3">
                {{ $item->name }}
                <small class="text-muted">
                  ({{ $item->feeNotice }})
                </small>
              </td>
            @else
              <td>
                {{ $item->name }}
              </td>
              <td>
                {{ $item->qty }}
              </td>
              <td>
                ${{ $item->rate }}
              </td>
            @endif
            <td>
              ${{ $item->subtotal }}
            </td>
            <td>
              @if (isset($item->camper_id))
                <a href="{{ route('calendar.index', ['camper' => $item->camper_id]) }}" class="btn btn-icon">
                  @svg('edit')
                </a>
              @endif
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>

    <div class="text-right">
      <b>Total</b>
      <b>${{ $total }}</b>
    </div>

    <hr>

    <a href="/checkout" class="btn btn-primary">
      Checkout
    </a>

    <a data-method="delete" type="delete" href="/cart" class="btn btn-secondary">
      Reset Cart
    </a>

    <a href="/calendar" class="d-none d-sm-inline btn btn-link">
      Add More Reservations
    </a>

  @endif
@endsection
