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

  <table class="table">
    <thead>
      <tr>
        <th>Camper</th>
        <th>Status</th>
        <th class="text-right">Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($items as $i)
        <tr>
          <td>
            {{ $i->name}}
          </td>
          <td>
            {{ $status[array_rand($status)] }}
          </td>
          <td>
            <div class="d-flex">
              <a target="_blank" rel="noopener norefferer" href="{{ route('admin.'.$slug.'.show', $i->id) }}"
                class="btn btn-icon">
                @svg('cart')
              </a>
              <a href="{{ route('campers.edit', $i->id) }}"
                class="btn btn-icon">
                @svg('edit')
              </a>
            </div>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
@endsection
