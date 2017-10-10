@extends('layouts.admin')

@section('content')
  {!! Form::open(['id' => 'orderform', 'route' => 'admin.menu-item-order.store']) !!}

  <button class="btn btn-primary" onclick="saveOrder(event)">
    Save Order
  </button>

  @include('partials.list', ['ulclass' => 'orderable', 'item' => $items])

  <button class="btn btn-primary" onclick="saveOrder(event)">
    Save Order
  </button>

  <input hidden name="order" id="orderString"/>

  {!! Form::close() !!}
@endsection

@section('scripts')
  @parent
  <script>
    var sortables = []
var uls = document.querySelectorAll('.orderable');
uls.forEach(function(el) {
  sortables.push(Sortable.create(el))
})

function saveOrder (e) {
  e.preventDefault()

  order = sortables.map( function (sortable) {
    return sortable.toArray()
  })
    .reduce( function (acc, arr) {
    return acc ? acc + ',' + arr.join() : arr.join()
  }, '')

  console.log(order)

  document.getElementById('orderString').value = order

  document.getElementById('orderform').submit()
}
  </script>
@endsection
