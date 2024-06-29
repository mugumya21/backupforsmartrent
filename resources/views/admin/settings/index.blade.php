@extends('layouts.app')

@section('title', 'Properties')



@section('head-css')
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendors/prism/prism-okaidia.css') }}" rel="stylesheet">

<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet">
@endsection

@section('content')

 
<div class="row g-3 mb-3" style="margin-top:10px;">


    <div class="col-sm-6 col-md-4">
      <div class="card overflow-hidden" style="min-width: 12rem">
        <div class="bg-holder bg-card" style="background-image:url({{ asset('assets/img/icons/spot-illustrations/corner-2.png')}});">
        </div>

        <div class="card-body position-relative">
          <a class="fw-semi-bold fs--1 text-nowrap" href="{{route('admin.basecurrency.create')}}" data-ajax="true">Set Base Currency<span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
        </div>
      </div>
    </div>


    <div class="col-sm-6 col-md-4">
      <div class="card overflow-hidden" style="min-width: 12rem">
        <div class="bg-holder bg-card" style="background-image:url({{ asset('assets/img/icons/spot-illustrations/corner-2.png')}});">
        </div>

        <div class="card-body position-relative">
          <a class="fw-semi-bold fs--1 text-nowrap" href="{{route('admin.foreigncurrency.create')}}" data-ajax="true">Set Foreign Currency<span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
        </div>
      </div>
    </div>

    <div class="col-sm-6 col-md-4">
      <div class="card overflow-hidden" style="min-width: 12rem">
        <div class="bg-holder bg-card" style="background-image:url({{ asset('assets/img/icons/spot-illustrations/corner-2.png')}});">
        </div>

        <div class="card-body position-relative">
          <a class="fw-semi-bold fs--1 text-nowrap" href="{{route('admin.subscription.create')}}" data-ajax="true">Subscription<span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
        </div>
      </div>
    </div>
    

</div>

@endsection


<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="{{ asset('assets/js/cleave.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>
<script src="{{ asset('assets/js/flatpickr.js') }}"></script>
<script src="{{ asset('vendors/prism/prism.js') }}"></script>

@section('include-js')

<script>
main.initAjax();
main.init();
  </script>
@endsection
