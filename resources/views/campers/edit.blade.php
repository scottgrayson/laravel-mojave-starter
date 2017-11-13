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

$wording = [
  'tent_id' => ['help' => 'Choose the grade that the camper has completed. Not the grade for the upcoming year.'],
  'photo_consent' => [
    'before' => "We take photographs of camp activities, that usually include recognizable images  of our campers, as well as counselors and staff.  We would like to use these photographs for marketing purposes, including, but not limited to, in brochures,  mailings and on our website,  and to include them in CD albums of the Camp experience that may be offered for sale to Camp families at the end of Camp.   By signing below, you agree that Miss Betty’s Day Camp is granted a license to use photographs that include images of your child/children in their activities at Camp for those purposes,  without charge, unless the box below has been checked.  Thank you.",
  ],
  'henna_consent' => [
    'before' => "Henna consent explanation",
  ],
  'allergies' => [
    'before' => '<b>Campers with allergies must have a completed paper copy of <a target="_blank" href="/assets/MBDC.medical.pdf">THIS FORM</a> when they attend camp.</b>',
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


  {{ Form::model($item, ['method' => 'PUT', 'route' => ["campers.update", $item->id]]) }}

  @include('form.fields', [
    'fields' => $fields,
    'item' => $item,
    'model' => $model,
    'wording' => $wording,
  ])

  <input hidden name="step" value="{{ $currentStep }}"></input>

  <br>

  @if($currentStep < 4)
    {{ Form::submit('Next', ['class' => 'btn btn-primary mr-2']) }}
  @else
    {{ Form::submit('Save', ['class' => 'btn btn-primary mr-2']) }}
  @endif

  {{ Form::close() }}

  <br>

@endsection
