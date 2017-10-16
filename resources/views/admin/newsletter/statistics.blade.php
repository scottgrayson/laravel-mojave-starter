@extends('layouts.admin')

@section('content')
  @if(!$item->sent_at)
    <div class="alert alert-info">
      Newsletter has not been sent.
    </div>
  @else
    <h4>Statistics</h4>
    <p>
      <b>Subject:</b>
      {{ $item->subject }}
    </p>
    <p>
      <b>Sent At:</b>
      {{ $item->sent_at }}
    </p>
    <p>
      <b>Opens:</b>
      {{ $opens }}
    </p>
    <p>
      <b>Unique Opens:</b>
      {{ $uniqueOpens }}
    </p>

      <table class="table">
        <thead>
          <th>Url</th>
          <th>Clicks</th>
          <th>Unique Clicks</th>
        </thead>
        <tbody>
          @foreach($item->links as $link)
            <tr>
              <td>{{ $link->target }}</td>
              <td>{{ $link->clicks()->count() }}</td>
              <td>{{$link->clicks()->distinct('ip_address')->count('ip_address')}}</td>
            </tr>
            @endforeach
        </tbody>
      </table>
  @endif
@endsection
