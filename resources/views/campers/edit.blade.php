@extends('layouts.app')

@section('content')
  @php
    $views = [
      'basic',
      'guardian',
      'emergency',
      'photo-consent',
    ];

$steps = [
  [
    'label' => 'Basic Info',
    'href' => route('campers.edit', ['camper' => $item->id, 'step' => 1]),
  ],
  [
    'label' => 'Guardian Info',
    'href' => route('campers.edit', ['camper' => $item->id, 'step' => 2]),
  ],
  [
    'label' => 'Emergency Info',
    'href' => route('campers.edit', ['camper' => $item->id, 'step' => 3]),
  ],
  [
    'label' => 'Photo Consent',
    'href' => route('campers.edit', ['camper' => $item->id, 'step' => 4]),
  ],
];
  @endphp


  <h1 class="h3">
    Camper Registration
  </h1>

  <br>

  @include('partials.stepper', [
    'currentStep' => $currentStep,
    'steps' => $steps,
  ])

  @if($currentStep == 4)
    <br>
    <p class="muted">
      We take photographs of camp activities, that usually include recognizable images  of our campers, as well as counselors and staff.  We would like to use these photographs for marketing purposes, including, but not limited to, in brochures,  mailings and on our website,  and to include them in CD albums of the Camp experience that may be offered for sale to Camp families at the end of Camp.   By signing below, you agree that Miss Betty’s Day Camp is granted a license to use photographs that include images of your child/children in their activities at Camp for those purposes,  without charge, unless the box below has been checked.  Thank you.
    </p>
  @endif

  {{ Form::model($item, ['method' => 'PUT', 'route' => ["campers.update", $item->id]]) }}

  @foreach ($fields as $name => $rules)
    {{ Form::bs($name, null, null, [], $rules, $model, $item) }}
  @endforeach

  <input hidden name="step" value="{{ $currentStep }}"></input>

  <br>

  @if($currentStep < 4)
    {{ Form::submit('Next', ['class' => 'btn btn-primary mr-2']) }}
  @else
    {{ Form::submit('Save', ['class' => 'btn btn-primary mr-2']) }}
  @endif

  {{ Form::close() }}

@endsection
