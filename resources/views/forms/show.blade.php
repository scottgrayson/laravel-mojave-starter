@extends('layouts.app')

@section('content')
  <div class="container-fluid">
    <div class="row">
      <div class="col">
        <div class="card">
          <p class="lead text-center mt-1">Forms</p>
          <div class="card-body">
            <ul class="list-group">
              <li class="list-group-item d-flex flex-row justify-content-between">
                <a href="{{ asset('assets/MBDC.medical.pdf') }}">
                  <h6>
                    2017 Medical Form
                  </h6>
                </a>
                <a class="ml-auto mr-1 btn btn-outline-secondary" href="{{ asset('assets/MBDC.medical.pdf') }}">
                  @svg('eye') View
                </a>
                <a class="btn btn-outline-primary" href="{{ asset('assets/MBDC.medical.pdf') }}" download>
                  @svg('download') Download
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
