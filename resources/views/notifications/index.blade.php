@extends('layouts.app')

@section('content')
  <div class="d-flex align-items-center justify-content-between">
    <h4 class="mb-0">
      {{ auth()->user()->unreadNotifications()->count() }} Unread Notifications
    </h4>

    <a href="/notifications/mark-read" class="btn btn-secondary">
      Mark All As Read
    </a>
  </div>

  <br>

  <table class="table">
    <thead>
      <tr>
        <th></th>
        <th>Notification</th>
        <th class="text-right">Time</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($notifications as $notification)
        <tr>
          <td class="text-primary">
            @if (!$notification->read_at)
              @svg('info', 's3 inherit')
            @endif
          </td>
          <td>
            <a class="{{ $notification->read_at ? 'text-muted' : '' }}" href="{{ route('notifications.show', $notification->id) }}">
              {{$notification->data['title']}}
            </a>
          </td>
          <td class="text-right">
            <span class="utc-to-local" format="fromNow">
              {{ $notification->created_at }}
            </span>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>

  <br>

  {!! $notifications->links('vendor.pagination.bootstrap-4') !!}
@endsection
