@extends('layouts.base')

@php
  $page = \App\Page::where('published', 1)->where('uri', '/')->first();
@endphp

@section('meta')
  @if ($page)
    {!! $page->meta_tags !!}
  @endif
@endsection

@section('body')
  @include('nav.default')
  <div class="container-fluid">

    <div>
      @include('homepage.carousel')
    </div>

    <div class="pb-4">
      @include('homepage.about', ['content' => $page ? $page->html : 'description'])
    </div>

  </div>
  @include('footer.default')
@endsection

@section('style')
  <style>
    body {
      background-color: white;
    }
  </style>
@endsection
