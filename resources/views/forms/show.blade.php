@extends('layouts.app')

@section('content')
  <div class="container-fluid">
    <div class="row">
      <div class="col">
        <div class="card">
          <p class="lead text-center mt-1">Forms</p>
          <div class="card-body">
            <ul class="list-group">
              @foreach($forms as $form)
                <li class="list-group-item d-flex flex-row justify-content-between">
                  <a href="{{ Storage::disk('local')->url($form) }}">
                    <h6>
                      {{substr($form, 12)}}
                    </h6>
                  </a>
                  <a class="ml-auto mr-1 btn btn-outline-secondary" href="{{ Storage::disk('local')->url($form) }}">
                    @svg('eye') View
                  </a>
                  <a class="btn btn-outline-primary" href="{{ Storage::disk('local')->url($form) }}" download>
                    @svg('download') Download
                  </a>
                </li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
