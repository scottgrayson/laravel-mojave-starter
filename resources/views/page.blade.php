@extends('layouts.'.$page->layout)

@section('meta')
  {!! $page->meta_tags !!}
@endsection

@section('content')
  {!! $page->html !!}
@endsection

