@extends('layouts.app')

@section('content')
<div id="invoice-template" class="card-body">
  <!-- Invoice Company Details -->
  <div id="invoice-company-details" class="row">
    <div class="col-md-6 col-sm-12 text-center text-md-left">
      <div class="media">
        <img src="{{ asset('img/logo.png') }}" alt="company logo" class="">
        <div class="media-body">
          <ul class="ml-2 px-0 list-unstyled">
            <li class="text-bold-800">Miss Betty's Day Camp</li>
            <li>Pickering Grove Park</li>
            <li>Chester Springs, PA 19425</li>
            <li>EIN: 20-1292071</li>
          </ul>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-sm-12 text-center text-md-right">
      <h2>INVOICE</h2>
      <p class="pb-3"># {{ $invoice->id }}</p>
      <ul class="px-0 list-unstyled">
        <li>Total</li>
        <li class="lead text-bold-800">$ {{ $invoice->totalUSD }}</li>
      </ul>
    </div>
  </div>
  <!--/ Invoice Company Details -->
  <!-- Invoice Customer Details -->
  <div id="invoice-customer-details" class="row pt-2">
    <div class="col-sm-12 text-center text-md-left">
      <p class="text-muted">Bill To</p>
    </div>
    <div class="col-md-6 col-sm-12 text-center text-md-left">
      <ul class="px-0 list-unstyled">
        <li class="text-bold-800">{{ $invoice->user->name }}</li>
        <li>{{-- TODO Get Camper Address --}}</li>
        <li></li>
        <li></li>
      </ul>
    </div>
    <div class="col-md-6 col-sm-12 text-center text-md-right">
      <p>
        <span class="text-muted">Invoice Date :</span> {{ $invoice->created_at->format('m/d/Y') }}</p>
      {{-- <p>
        <span class="text-muted">Terms :</span> Due on Receipt
      </p>
      <p>
        <span class="text-muted">Due Date :</span> {{ $invoice->created_at->format('m/d/Y') }}
      </p> --}}
    </div>
  </div>
  <!--/ Invoice Customer Details -->
  <!-- Invoice Items Details -->
  <div id="invoice-items-details" class="pt-2">
    <div class="row">
      <div class="table-responsive col-sm-12">
        <table class="table">
          <thead>
            <tr>
              <th>#</th>
              <th>Item &amp; Description</th>
              <th class="text-right">Rate</th>
              <th class="text-right">Hours</th>
              <th class="text-right">Amount</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row">1</th>
              <td>
                <p>Create PSD for mobile APP</p>
                <p class="text-muted">Simply dummy text of the printing and typesetting industry.</p>
              </td>
              <td class="text-right">$ 20.00/hr</td>
              <td class="text-right">120</td>
              <td class="text-right">$ 2400.00</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="row">
      <div class="col-md-7 col-sm-12 text-center text-md-left">
        {{-- <p class="lead">Payment Methods:</p>
        <div class="row">
          <div class="col-md-8">
            <table class="table table-borderless table-sm">
              <tbody>
                <tr>
                  <td>Bank name:</td>
                  <td class="text-right">ABC Bank, USA</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div> --}}
      </div>
      <div class="col-md-5 col-sm-12">
        <p class="lead">Total due</p>
        <div class="table-responsive">
          <table class="table">
            <tbody>
              <tr>
                <td class="text-bold-800">Total</td>
                <td class="text-bold-800 text-right"> $ {{ $invoice->totalUSD }}</td>
              </tr>
              <tr>
                <td>Payment Made</td>
                <td class="pink text-right">(-) $ {{ $invoice->totalUSD }}</td>
              </tr>
              <tr class="bg-grey bg-lighten-4">
                <td class="text-bold-800">Balance Due</td>
                <td class="text-bold-800 text-right">$ 0.00</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!-- Invoice Footer -->
  {{-- <div id="invoice-footer">
    <div class="row">
      <div class="col-md-7 col-sm-12">
        <h6>Terms &amp; Condition</h6>
        <p></p>
      </div>
    </div>
  </div> --}}
  <!--/ Invoice Footer -->
</div>

  <div>
    <div class="card col-lg-4 mx-auto">
      <h5 class="card-title text-center pt-2 my-auto">
        {{$invoice->reservations->first()->camper->first_name}}
        {{$invoice->reservations->first()->camper->last_name}}
      </h5>
      <hr>
      <p class="text-center">
        Total: ${{$invoice->total}}
      </p>
      <p class="text-center">
        {{$invoice->reservations->count()}} {{str_plural('Reservation', $invoice->reservations->count())}}
      </p>
      <ul class="list-group py-2">
        @foreach($invoice->reservations as $reservation)
          <li class="list-group-item text-center">
            {{$reservation->date->toFormattedDateString()}}
          </li>
        @endforeach
      </ul>
      <p class="text-center lead">
        EIN: 20-1292071
      </p>
    </div>
  </div>
@endsection
