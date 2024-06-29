@extends('layouts.app')

@section('title', 'Tenant Ledger')


@section('head-css')
<link href="{{ asset('assets/DataTables/datatables.min.css')}}" rel="stylesheet">
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendors/prism/prism-okaidia.css') }}" rel="stylesheet">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet">
@endsection

<style>
  .choices .choices__list--multiple .choices__item {
    background-color: #0863f6 !important;
    color: #fff !important;
}

</style>

@include('shared.overide-select2-multiple')

@section('content')


<div class="card mb-3">


  {{ html()->form('get')->route('reports.ledgers')->class('')->id('form-submit')->novalidate()->open() }}

  <div class="card-header bg-light">
    <div class="row flex-between-end">
      <div class="col-auto align-self-center">
        <h5 class="mb-0" data-anchor="data-anchor">Tenant Ledger</h5>
      </div>

      <div class="col-auto ms-auto">
    <div class="nav nav-pills nav-pills-falcon flex-grow-1" role="tablist">
    @if(!empty($search->tenant_unit_id))
        <form action="{{ route('reports.ledgers') }}" method="GET">
        <input type="hidden" name="tenant_unit_id" value="{{ $search->tenant_unit_id }}">
        <button type="submit" value="PRINT" name="submit" class="btn btn-sm active">
            <i class="fas fa-print"></i> Print Receipt
        </button>
    </form>
    @endif
</div>

      </div>
    </div>

  </div>

  <div class="card-body" style="padding-top: 0px; padding-bottom: 0px;">

    <div class="row">


      <div class="col-md-5 isforyearly" style="padding-right:0px;">
        <label class="form-label" for="code">Select a Tenant Unit</label>
      <select name="tenant_unit_id" class="form-select js-choice choices isyearly" required id="schedule_id" placeholder="Select an Option">

    <option value="">Select a tenant unit ...</option>

    @foreach($tenantunits as $tenantunit)
    <option value="{{ $tenantunit->id }}" @if(($search->tenant_unit_id == $tenantunit->id)) selected @endif> {{ $tenantunit->unit->name }} - {{ $tenantunit->tenant->full_name }} ({{$tenantunit->property->name}})</option>
        @endforeach
      </select> </div>

  <div class="col-md-3" style="margin-top: 22px;">
    <button name='form-submit' style="padding:2px" class="btn btn-primary me-1 mb-1 fullwidth"  id="" type="submit">Filter
    </button>
  </div>
  </div>
  </div>

  {{ html()->form()->close() }}



  <div class="card-body text-justify">

  @include('reports.ledgers_table',['ledgers'=>$ledgers])


  </div>

</div>


@endsection


@section('include-js')

<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="{{ asset('assets/js/cleave.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>
<script src="{{ asset('assets/js/flatpickr.js') }}"></script>
<script src="{{ asset('vendors/prism/prism.js') }}"></script>
<script src="{{ asset('assets/DataTables/datatables.min.js')}}"></script>

<script>
main.init();


$('#ledgers_table').DataTable({
  dom: 'Bfrtip',
  order: false,
  columnDefs: [
        {
            target: 0,
            visible: false,
        }
    ],
  buttons: [{
                extend: 'copy',
                text: 'Copy',
                className: 'btn btn-falcon-default me-1 mb-1',
            }, {
                extend: 'print',
                text: 'Print Pdf',
                className: 'btn btn-falcon-default me-1 mb-1',
                autoPrint: true,
            }, {
                extend: 'csv',
                text: 'CSV',
                className: 'btn btn-falcon-default me-1 mb-1',
                autoPrint: true,
            }
            ],
});
$( document ).ready(function() {


var total = $("#totalclass").val();
$("#grandtotal").html(total);

});

$(document).on('change','.trigers',function(){
$('#filterbutton').click();
});

  </script>


@endsection
