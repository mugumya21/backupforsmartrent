@extends('layouts.app')

@section('title', 'Unpaid Rent')


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


  {{ html()->form('get')->route('reports.bianualprojections')->class('')->id('form-submit')->novalidate()->open() }}

  <div class="card-header bg-light">
    <div class="row flex-between-end">
      <div class="col-auto align-self-center">
        <h5 class="mb-0" data-anchor="data-anchor">Bi-Annual Projections Report</h5>
      </div>

      <div class="col-auto ms-auto">
        <div class="nav nav-pills nav-pills-falcon flex-grow-1" role="tablist">
            @if(!empty($search->months))
          <button type="submit" value="PRINT" name="submit" class="btn btn-sm active"> <i class="fas fa-print"></i> Print Receipt</button>
@endif

        </div>
      </div>
    </div>

  </div>

  <div class="card-body" style="padding-top: 0px; padding-bottom: 0px;">

    <div class="row">

      <div class="col-md-3" style="padding-right:0px;">
        <label class="form-label" for="code">Select a Property to populate data</label>
      {{ html()->select('property_id')->options($properties->pluck('name','id'))->value($search->property_id)->class('form-select form-select-sm js-choice')->placeholder('Select an Option') }}
      </div>

  <div class="col-md-3 isforyearly" style="padding-right:0px;">
    <label class="form-label" for="code">Select Years</label>
  <select name="months" class="form-select js-choice choices isyearly" required id="schedule_id" placeholder="Select an Option">

    <option value="">Select Months ...</option>

<option value="JantoJun" @if($search->months == 'JantoJun') selected @endif> January - June</option>
<option value="JultoDec"  @if($search->months == 'JultoDec') selected @endif> July - December</option>


  </select> </div>

  <div class="col-md-3" style="margin-top: 22px;">
    <button name='form-submit' style="padding:2px" class="btn btn-primary me-1 mb-1 fullwidth"  id="" type="submit">Filter
    </button>
  </div>
  </div>
  </div>

  {{ html()->form()->close() }}



  <div class="card-body text-justify">

  @include('reports.bianualprojections_table',['monthsarray'=>$monthsarray])


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


$('#example').DataTable({
  dom: 'Bfrtip',
  ordering:false,
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
