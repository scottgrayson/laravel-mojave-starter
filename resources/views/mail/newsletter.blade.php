@component('mail::message')

  {!! $newsletter->body !!}

  <p style="font-size:0.65rem; text-align:center;">
    <a href="{{ route("newsletter.unsubscribe", ['email' => $data['subscriberEmail']]) }}">
      Unsubscribe
    </a>
  </p>

  <img src="{{ $data['links']['tracker'] }}"/>

@endcomponent
