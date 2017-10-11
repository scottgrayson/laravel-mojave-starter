@extends('layouts.app')

@section('content')

  @php
    $page = \App\Page::where('published', 1)->where('uri', '/')->first();
  @endphp

  @if ($page)
    {!! $page->html !!}
  @else
    @component('components.focused')
      <h2 class="text-center">
        Welcome {{ auth()->check() ? auth()->user()->name : 'to ' . config('app.name') }}
      </h2>
    @endcomponent
  @endif

@endsection
