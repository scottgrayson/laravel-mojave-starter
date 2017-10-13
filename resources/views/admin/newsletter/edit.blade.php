@extends('layouts.admin')

@section('content')
@if($item->sent_at)
  <div class="d-flex justify-content-between">
    <div>
      <h4>Newsletter Sent</h4>

    </div>
    <a href="{{ route('admin.newsletter.statistics', $item->id) }}"
      class="btn btn-secondary">
      Statistics
    </a>
  </div>
  @endif

  @include('crud.edit', [
    'fields' => $fields,
    'slug' => $slug,
    'model' => $model,
    'item' => $item,
  ])

  <br>

  <h4>Preview Newsletter</h4>

  {{ Form::open(['method' => 'POST', 'route' => ['admin.newsletter.preview', $item->id]]) }}

  {{ Form::bs('email', null, null, ['placeholder' => 'Preview will be sent here'], ['required']) }}

  {{ Form::submit('Preview', ['class' => 'btn btn-secondary']) }}

  {{ Form::close() }}
@endsection
