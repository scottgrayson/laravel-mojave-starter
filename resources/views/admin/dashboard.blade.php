@extends('layouts.admin')

@section('content')
  @component('components.card')
    <h2>
      New Campers
    </h2>

    <br>

    @if (!$campers->count())
      <div class="alert alert-info">
        No new campers
      </div>
    @endif

    <table class="table">
      <thead>
        <tr>
          <th scope="col">Camper</th>
          <th scope="col">User</th>
          <th scope="col">Status</th>
          <th scope="col">Last Updated</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($campers as $camper)
          <tr>
            <th>
              <a href="{{ route('admin.campers.edit', $camper->id) }}">
                {{ $camper->name }}
              </a>
            </th>
            <th>
              <a href="{{ route('admin.users.edit', $camper->user->id) }}">
                {{ $camper->user->name }}
              </a>
            </th>
            <th>{{ $camper->status }}</th>
            <th>{{ $camper->updated_at->diffForHumans() }}</th>
          </tr>
        @endforeach
      </tbody>
    </table>

  @endcomponent
@endsection
