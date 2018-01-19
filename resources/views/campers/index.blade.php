@extends('layouts.app')

@section('content')
  <div class="d-flex align-items-center justify-content-between mt-3">
    <h1 class="h3">
      My Campers
    </h1>
    <a href="{{ route('forms') }}"
      class="btn btn-outline-primary mr-auto ml-2">
      Forms
    </a>
    <a href="{{ route('campers.create') }}"
      class="btn btn-primary">
      Add Camper
    </a>
  </div>

  <br>

  @if($items && $items->count())
    <table class="table">
      <thead class="thead-light">
        <tr>
          <th>Name</th>
          <th class="d-none d-sm-table-cell">Reservations</th>
          <th class="text-right">Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($items as $i)
          <tr>
            <td>
              {{ $i->name}}
            </td>
            <td class="d-none d-sm-table-cell">
              {{ $i->status }}
            </td>
            <td class="d-flex justify-content-end">
              <a href="{{ route('calendar.index', ['camper' =>  $i->id]) }}"
                class="btn btn-sm btn-outline-primary">
                @svg('calendar', 'text-top')
                <span class="d-none d-md-inline">
                  Add Days
                </span>
              </a>
              <a href="{{ route('campers.edit', $i->id) }}"
                class="mx-1 btn btn-sm btn-outline-primary">
                @svg('edit', 'text-top')
                <span class="d-none d-md-inline">
                  Update
                </span>
              </a>
              <a href="{{ route('campers.destroy', $i->id) }}"
                data-method="delete"
                class="btn btn-sm btn-outline-primary">
                @svg('trash', 'text-top')
                <span class="d-none d-md-inline">
                  Delete
                </span>
              </a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @else

    <div class="alert alert-info">
      You have not registered any campers.
    </div>
  @endif

@endsection
