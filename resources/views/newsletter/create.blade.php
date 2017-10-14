@extends('layouts.app')

@section('content')
  @component('components.focused')
    <h1 class="h4">Subscribe to Newsletter</h1>
    {{ Form::open(['method' => 'POST', 'route' => "newsletter.store"]) }}
    {{ Form::bs('email', 'email', null, [], ['required']) }}
    {{ Form::submit('Subscribe', ['class' => 'btn btn-primary mr-2']) }}
    {{ link_to_route('newsletter.unsubscribe', 'Unsubscribe') }}
    {{ Form::close() }}
  @endcomponent
@endsection
