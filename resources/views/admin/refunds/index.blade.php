@extends('layouts.admin')

@section('content')
  <h1 class="h3">
    Refunds For Camp {{ $camp->camp_start->year }}
  </h1>

  <br>

  {{ Form::open(['route' => 'admin.refunds.store']) }}

  @include('form.fields', [
    'fields' => $fields,
    'wording' => [
      'emails' => [
        'before' => 'Comma seperated list of emails to refund.',
        'placeholder' => 'example1@email.com,example2@email.com,example3@email.com',
        'help' => 'Spaces are ignored and will not cause problems',
        ],
      ]
  ])

  {{ Form::submit('Refund', ['class' => 'btn btn-primary']) }}

  {{ Form::close() }}

  <hr>

  <h2 class="h4">Already Refunded</h2>
  <table class="table">

    <thead>
      <tr>
        <th>
          Name
        </th>
        <th>
          Email
        </th>
        <th>
          Refunded
        </th>
      </tr>
    </thead>

    <tbody>
      @foreach($refunds as $r)
        <tr>
          <td>
            {{ $r->user->name }}
          </td>
          <td>
            {{ $r->user->email }}
          </td>
          <td>
            <a target="_blank" href="/admin/payments/{{ $r->id }}">
              {{ $r->refunded }}
            </a>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
@endsection
