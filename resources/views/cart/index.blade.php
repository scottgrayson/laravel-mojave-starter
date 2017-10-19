@extends('layouts.app')

@section('content')
  <h1 class="h3">
    My Cart
  </h1>

  <br>

  @if($items->count())

    <table class="table">
      <thead>
        <tr>
          <th>Camper</th>
          <th>Days</th>
          <th>Rate</th>
          <th>Price</th>
          <th>Edit</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Mark</td>
          <td>19</td>
          <td>20</td>
          <td>380</td>
          <td>
            <a href="{{ route('calendar.index', ['camper' => 1]) }}" class="btn btn-icon">
              @svg('edit')
            </a>
          </td>
        </tr>
      </tbody>
    </table>

    <div class="text-right">
      <b>Total</b>
      <b>$1000</b>
    </div>

    <hr>

    <div class="text-right">
      <button type="delete" href="/cart" class="btn btn-secondary">
        Reset Cart
      </button>

      <a href="/checkout" class="btn btn-primary">
        Checkout
      </a>
    </div>

  @else

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

  @endif
@endsection
