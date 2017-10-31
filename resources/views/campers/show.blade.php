@extends('layouts.app')

@section('content')
  <div class="card">
    <div class="card-header">
      <p class="lead text-center">
        {{ $camper->name }}
      </p>
    </div>
    <div class="card-content">
      @if ($camper->allergies !== null)
        <p class="text-center mt-1">Allergies</p>
        <ul>
          <li>{{$camper->allergies}}</li>
        </ul>
      @endif
    </div>
  </div>
@endsection
