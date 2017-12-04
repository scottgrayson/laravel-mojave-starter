@extends('layouts.admin')

@section('content')
  @if($item->sent_at)
    <div class="d-flex justify-content-between alert alert-info">
      <div>
        <h4>Sent</h4>
        <small>{{ $item->sent_at }}</small>
      </div>

      <a href="{{ route('admin.newsletters.show', $item->id) }}"
        class="align-self-start btn btn-outline-info">
        Statistics
      </a>
    </div>
  @endif

  @component('components.card')
    {{ Form::model($item, ['method' => 'PUT', 'route' => ["admin.newsletters.update", $item->id]]) }}

    @foreach ($fields as $name => $rules)
      @if (View::exists('form.inputs.'.$slug.'.'.$name))
        @include('form.inputs.'.$slug.'.'.$name)
      @else
        {{ Form::bs($name, null, null, [], $rules, $model, $item) }}
      @endif
    @endforeach

    {{ Form::submit('Update', ['class' => 'btn btn-primary']) }}

    {{ Form::close() }}

    <br>

    @if(!$item->sent_at)
      <h4>Send Newsletter</h4>
      <p class="lead">
        @svg('alert', 'lg text-top')
        Emails will be sent to all subscribers when you click send
      </p>
      {{ Form::open(['method' => 'POST', 'route' => ['admin.newsletter.send', $item->id]]) }}
      {{ Form::submit('Send', ['class' => 'btn btn-primary']) }}
      {{ Form::close() }}
    @endif

  @endcomponent

  <br>

  @component('components.card')

    <h4>Preview Newsletter</h4>

    {{ Form::open(['method' => 'POST', 'route' => ['admin.newsletter.preview', $item->id]]) }}

    {{ Form::bs('email', null, null, ['placeholder' => 'Preview will be sent here'], ['required']) }}
    {{ Form::submit('Preview', ['class' => 'btn btn-secondary']) }}

    {{ Form::close() }}
  @endcomponent
@endsection
