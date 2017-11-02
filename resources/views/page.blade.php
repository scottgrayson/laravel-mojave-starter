@extends('layouts.'.$page->layout)

@section('meta')
  {!! $page->meta_tags !!}
@endsection

@section('content')
  <div class="page-content">
    {!! $page->html !!}
  </div>
@endsection


@section('style')
  @parent
  <style>
    .page-content {
      font-size: 1.125rem;
      margin: 0 auto;
      padding-bottom: 2rem;
      max-width: 800px;
    }
    .page-content img {
      display: block;
      margin: 1rem auto;
      max-height: 50vh;
      max-width: 100%;
    }
  </style>
@endsection
