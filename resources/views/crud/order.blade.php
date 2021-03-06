@php
  $prefix = request()->is('admin*') ? 'admin.' : '';
@endphp

{!! Form::open(['id' => 'orderform', 'route' => $prefix.$slug.".reorder"]) !!}

<div class="d-flex">
  <h4> Drag and drop to reorder</h4>
  <button class="ml-auto btn btn-primary" onclick="saveOrder(event)">
    Save Order
  </button>
</div>

<p class="text-muted">
  Menu items cannot be dragged across menus.
  <br>
  To do this, click edit and change the "parent" menu item.
</p>

@include('partials.orderable-list', ['ulclass' => 'orderable', 'item' => $items, 'slug' => $slug])

<div class="d-flex">
  <button class="ml-auto btn btn-primary" onclick="saveOrder(event)">
    Save Order
  </button>
</div>

<input hidden name="order" id="orderString"/>

{!! Form::close() !!}

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
