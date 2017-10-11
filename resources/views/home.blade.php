@extends('layouts.app')

@section('content')

  @php
    $page = \App\Page::where('published', 1)->where('uri', '/')->first();
  @endphp

  @if ($page)
    {!! $page->html !!}
  @else
    @component('components.focused')
      Welcome {{ auth()->check() ? auth()->user()->name : 'to' . config('app.name') }}
    @endcomponent
  @endif

@endsection
