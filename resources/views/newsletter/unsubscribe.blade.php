@extends('layouts.app')

@section('content')
  @component('components.focused')
    <h1 class="h4">Unsubscribe from Newsletter</h1>
    {{ Form::open(['method' => 'DELETE', 'route' => "newsletter.destroy"]) }}
    {{ Form::bs('email', 'email', null, [], ['required']) }}
    {{ Form::submit('Unsubscribe', ['class' => 'btn btn-primary mr-2']) }}
    {{ link_to_route('newsletter.create', 'Resubscribe') }}
    {{ Form::close() }}
  @endcomponent
@endsection
