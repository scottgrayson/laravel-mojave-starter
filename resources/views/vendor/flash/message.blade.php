@foreach (session('flash_notification', collect())->toArray() as $message)
    @if ($message['overlay'])
        @include('flash::modal', [
            'modalClass' => 'flash-modal',
            'title'      => $message['title'],
            'body'       => $message['message']
        ])
    @else
        <div class="alert
                    alert-notify
                    alert-{{ $message['level'] }}
                    {{ $message['important'] ? 'alert-important' : '' }}"
                    role="alert"
        >
        <button type="button"
            class="pl-2 close"
            data-dismiss="alert"
            aria-hidden="true"
            >&times;</button>

            {!! $message['message'] !!}
        </div>
    @endif
@endforeach

{{ session()->forget('flash_notification') }}

@section('scripts')
    <script>
        $('div.alert-notify').not('.alert-important').delay(6000).fadeOut(500);
    </script>
@endsection
