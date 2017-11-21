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
    @include('crud.edit', [
      'fields' => $fields,
      'slug' => $slug,
      'model' => $model,
      'item' => $item,
    ])
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
