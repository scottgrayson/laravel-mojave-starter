<div class="dropdown">
  <button data-toggle="dropdown" class="dropdown-toggle btn btn-icon mb-2 mb-md-0 mr-2">
    @if(auth()->user()->unread_notification_count)
      <span class="noti-badge badge badge-pill badge-danger">
        {{ auth()->user()->unread_notification_count }}
      </span>
    @endif
    @svg('bell', 'xl')
  </button>
  <div class="dropdown-menu dropdown-menu-md-right">
    <h6 class="dropdown-header">Notifications</h6>
    @forelse ($notifications->take(5) as $notification)
      <a class="dropdown-item" href="{{ route('notifications.show', $notification->id) }}">
        <h6>{{ $notification->data['title'] }}</h6>
        <small class="utc-to-local" format="fromNow">
          {{ $notification->created_at }}
        </small>
      </a>
    @empty
      <a class="dropdown-item">
        <h6>No Unread Notifications</h6>
      </a>
    @endforelse
    <div class="dropdown-divider"></div>
    <a class="dropdown-item text-center" href="/notifications">
      View All
    </a>
  </div>
</div>
