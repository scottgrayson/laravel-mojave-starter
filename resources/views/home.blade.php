@extends('layouts.app')

@php
  $page = \App\Page::where('published', 1)->where('uri', '/')->first();
@endphp

@section('meta')
  @if ($page)
    {!! $page->meta_tags !!}
  @endif
@endsection

@section('content')

  @if ($page)
    <div class="page-content">
      {!! $page->html !!}
    </div>
  @else
    @component('components.focused')
      <h2 class="text-center">
        Welcome {{ auth()->check() ? auth()->user()->name : 'to ' . config('app.name') }}

        @if (!auth()->check())
          <a class="btn btn-primary" href="/register">
            Sign Up
          </a>
        @endif
      </h2>
    @endcomponent
  @endif

@endsection
