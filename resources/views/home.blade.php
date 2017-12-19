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

    <section id="home-carousel">
      @include('homepage.carousel')
    </section>

    @include('homepage.about', ['content' => $page ? $page->html : 'description'])

  @include('footer.default')
@endsection

@section('style')
  <style>
    body {
      background-color: white;
    }
  </style>
@endsection
