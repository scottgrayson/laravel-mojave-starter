@extends('layouts.admin')

@section('content')
  @component('components.card')
    <h1 class="h3">
      Refunds For Camp {{ $camp->camp_start->year }}
    </h1>

    <br>

    @php
      $alertStatus = [
        'already_refunded' => 'info',
        'error_refunding' => 'danger',
        'refunded' => 'success',
        "email_not_found" => 'danger',
        'payment_not_found' => 'danger',
      ]
    @endphp

    @if(session()->has('refund_results'))
      @foreach(session('refund_results') as $key => $value)
        @if($value->count())
          <div class="alert alert-{{ $alertStatus[$key] }}">
            <h5 class="alert-heading">{{ title_case(str_replace('_', ' ', $key)) }}</h5>
            <p>{{ $value->implode(',') }}</p>
          </div>
        @endif
      @endforeach
    @endif

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

    @if (!$refunds->isEmpty())
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
    @endif
  @endcomponent
@endsection
