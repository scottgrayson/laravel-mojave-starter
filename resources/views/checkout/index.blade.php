@extends('layouts.app')

@section('content')
  <checkout authorization="{{ $clientToken }}" amount="{{ $amount }}"></checkout>
@endsection
