@component('mail::message')

  {!! $newsletter->body !!}

  <p style="font-size:0.65rem; text-align:center;">
    <a href="{{ route("newsletter-subscriber.unsubscribe", $data['subscriberId']) }}">
      Unsubscribe
    </a>
  </p>

  <img src="{{ $data['links']['tracker'] }}"/>

@endcomponent
