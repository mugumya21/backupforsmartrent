@extends('layouts.app')

@section('title', 'Payments')


@section('head-css')

<link href="{{ asset('assets/DataTables/datatables.min.css')}}" rel="stylesheet">
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendors/prism/prism-okaidia.css') }}" rel="stylesheet">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet">
 

@section('content')


<div class="card mb-3">
  <div class="card-header bg-light">
    <div class="row flex-between-end">
      <div class="col-auto align-self-center">
        <h5 class="mb-0" data-anchor="data-anchor">Payments<a class="anchorjs-link " aria-label="Anchor" data-anchorjs-icon="#" href="#example" style="padding-left: 0.375em;"></a></h5>
      </div>
      <div class="col-auto ms-auto">


      <div class="nav nav-pills nav-pills-falcon flex-grow-1" role="tablist">

        <a href="{{route('accounts.invoices.invoicepayments-invoicedcreate')}}" data-ajax="true" class="btn btn-sm active" aria-selected="true"><i class="fas fa-plus"></i> Invoice Payment</a>

        <a href="{{route('accounts.invoices.invoicepayments-create')}}" data-ajax="true" class="btn btn-sm active" aria-selected="true"><i class="fas fa-plus"></i> Non Invoice Payment</a>
         
      </div>
      </div>
    </div>
  </div>

  <div class="card-body text-justify">
  @include('rent.payments.index')
  </div>
  
</div>


@endsection


@section('include-js')


<script src="{{ asset('assets/js/sweetalert2@11.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>
<script src="{{ asset('assets/js/jquery-3.7.1.js') }}"></script>
<script src="{{ asset('assets/js/flatpickr.js') }}"></script>
<script src="{{ asset('vendors/prism/prism.js') }}"></script>
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script> 
<script src="{{ asset('assets/js/cleave.js') }}"></script>
<script src="{{ asset('assets/DataTables/datatables.min.js')}}"></script>

<script>
  main.initAjax();
$('#payment_tbl').DataTable();
  </script>

@endsection
