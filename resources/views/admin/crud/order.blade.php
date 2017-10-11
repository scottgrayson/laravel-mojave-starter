@extends('layouts.admin')

@section('content')
  {!! Form::open(['id' => 'orderform', 'route' => "admin.$slug.reorder"]) !!}

  <div class="d-flex">
    <h4> Drag and drop to reorder</h4>
    <button class="ml-auto btn btn-primary" onclick="saveOrder(event)">
      Save Order
    </button>
  </div>

  @include('partials.orderable-list', ['ulclass' => 'orderable', 'item' => $items, 'slug' => $slug])

  <div class="d-flex">
    <button class="ml-auto btn btn-primary" onclick="saveOrder(event)">
      Save Order
    </button>
  </div>

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
