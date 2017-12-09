@extends('layouts.app')

@section('content')
  @component('components.focused')
    <h1 class="h4">Subscribe to Newsletter</h1>
    @include('newsletter.create-form')
  @endcomponent
@endsection
