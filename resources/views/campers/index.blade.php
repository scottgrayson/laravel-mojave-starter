@php
  // TODO replace this with logic in \App\Camper
  $status = ['Pending Approval', 'Registration Incomplete', 'Camp Dates Reserved', 'No Reservations']
@endphp

@extends('layouts.app')

@section('content')
  <div class="d-flex justify-content-between">
    <h1 class="h3">
      My Campers
    </h1>

    <a href="{{ route('campers.create') }}"
      class="btn btn-primary">
      Add Camper
    </a>
  </div>

  <br>

  @if($items && $items->count())
    <table class="table">
      <thead>
        <tr>
          <th>Camper</th>
          <th class="d-none d-sm-table-cell">Status</th>
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
              {{ $status[$i->id % 4] }}
            </td>
            <td class="text-right">
              <a href="{{ route('calendar.index', ['camper' =>  $i->id]) }}"
                class="mb-1 mb-lg-0 btn btn-sm btn-secondary">
                @svg('calendar', 'text-top')
                <span class="d-none d-md-inline">
                  Reservations
                </span>
              </a>
              <a href="{{ route('campers.edit', $i->id) }}"
                class="mb-1 mb-lg-0 btn btn-sm btn-secondary">
                @svg('edit', 'text-top')
                <span style="padding-right:0.35rem;" class="d-none d-md-inline">
                  Registration
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
