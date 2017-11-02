@extends('layouts.'.$page->layout)

@section('meta')
  {!! $page->meta_tags !!}
@endsection

@section('content')
  {!! $page->html !!}
@endsection


@section('style')
  @parent
  <style>
    img {
      display: block;
      margin: 0 auto;
      max-height: 50vh;
      max-width: 100%;
    }
  </style>
@endsection
