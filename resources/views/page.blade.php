@extends('layouts.' . $page->layout ?: 'app')

@section('meta')
  {!! $page->meta_tags !!}
@endsection

@section('content')
  <div class="page-content">
    {!! $page->html !!}
  </div>
@endsection
