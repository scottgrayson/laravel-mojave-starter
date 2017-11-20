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
    'label' => 'Photo and Henna Consent',
    'href' => route('campers.edit', ['camper' => $item->id, 'step' => 4]),
  ],
];

$wording = [
  'tent_id' => ['help' => 'Choose the grade your child attended as of January of this year.'],
  'photo_consent' => [
    'label' => "Miss Betty's Day Camp may use photos of " . $item->name,
    'before' => "We take photographs of camp activities, that usually include recognizable images  of our campers, as well as counselors and staff.  We would like to use these photographs for marketing purposes, including, but not limited to, in brochures,  mailings and on our website,  and to include them in CD albums of the Camp experience that may be offered for sale to Camp families at the end of Camp.   By checking the box below, you agree that Miss Betty’s Day Camp is granted a license to use photographs that include images of your child/children in their activities at Camp for those purposes.",
  ],
  'henna_consent' => [
    'label' => $item->name . ' has permission to obtain a henna tattoo',
    'before' => "On Fridays the Clay Barn at Miss Betty’s Day Camp will offer optional henna tattoo designs, with your permission. We have a variety of child-friendly designs for arms or legs only. The henna used is from www.HENNACARAVAN.com and does not contain any black or colored chemical dyes or additives, PPD paraphnylenediamene, nut products or preservatives. It contains 100% natural henna, sugar, lemon juice and essential oils (cajeput, orange sweet, wild orange or lavender). We will also use sugar, lemon juice/tea tree oil to help seal the design. Anyone with allergy concerns or other concerns should consult a doctor and/or hennacaravan.com for further questions. The design is applied with a paste that dries and can be washed off, leaving behind the brown design stain. Depending on how long the paste is left on (we recommend 6 hours) the design will last 7 to 14 days, sometimes less.",
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
