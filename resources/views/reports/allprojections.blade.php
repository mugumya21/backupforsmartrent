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

  
  {{ html()->form('get')->route('reports.generalprojections')->class('')->id('form-submit')->novalidate()->open() }}

  <div class="card-header bg-light">
    <div class="row flex-between-end">
      <div class="col-auto align-self-center">
        <h5 class="mb-0" data-anchor="data-anchor">All Projections Report</h5>
      </div>

      <div class="col-auto ms-auto">
        <div class="nav nav-pills nav-pills-falcon flex-grow-1" role="tablist">
          @if(!empty($search->period))
          <button type="submit" value="PRINT" name="submit" class="btn btn-sm active"> <i class="fas fa-print"></i> Print Preview</button>  
@endif

        </div>
      </div>
    </div>
    
  </div>

  <div class="card-body" style="padding-top: 0px; padding-bottom: 0px;">

    <div class="row">
  <div class="col-md-3" style="padding-right:0px;">
    <label class="form-label" for="code">Period</label>
    <select name="period" class="form-select form-select-sm js-choice" id="period_id" required="">
     
      <option> Select an Option</option>
      <option value="ANNUALLY"  @if(!empty($search->period && $search->period == 'ANNUALLY')) selected @endif> ANNUALLY</option>
      <option value="MONTHLY" @if(!empty($search->period && $search->period =='MONTHLY')) selected @endif> MONTHLY</option>
 
    </select>
  </div>

  
  <div class="col-md-3 isformonthly hidden" style="padding-right:0px;">
    <label class="form-label" for="code">Select Months</label>
  <select name="months" class="form-select js-choice choices ismonthly hidden" required id="schedule_id" placeholder="Select an Option">

    @if(!empty($search->months))
    <option value="{{ $search->months }}" selected>{{Carbon\Carbon::parse($search->months)->formatLocalized('%b')}}' {{Carbon\Carbon::parse($search->months)->format('Y')}}</option>
    @else 
    <option value="">Select Months ...</option>
    @endif

    @foreach($months as $month)
<option value="{{ $month->format("Y-m-d") }}">{{Carbon\Carbon::parse($month)->formatLocalized('%b')}}' {{Carbon\Carbon::parse($month)->format('Y')}}</option>
    @endforeach
  </select> </div>

  <div class="col-md-3 isforyearly hidden">
    <label class="form-label" for="code">Select Years</label>
  <select name="years" class="form-select js-choice choices isyearly hidden" required id="schedule_id" placeholder="Select an Option">

    @if(!empty($search->years))
    <option value="{{ $search->years }}" selected>{{ $search->years }}</option>
    @else 
    <option value="">Select Years ...</option>
    @endif

    @foreach($years as $year)
<option value="{{ $year->format("Y") }}"> {{ $year->format("Y") }}</option>
    @endforeach
  </select> </div>

  <div class="col-md-3 isforbutton hidden" style="margin-top: 22px;">
    <button name='form-submit' style="padding:2px" class="hidden isbutton btn btn-primary me-1 mb-1 fullwidth"  id="filterbutton" type="submit">Filter
    </button>
  </div>
  </div>
  </div>

  {{ html()->form()->close() }}



  <div class="card-body text-justify">
  
  @include('reports.allprojections_table',['properties'=>$properties])


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


var periodvalue = $("#period_id option:selected").val(); 

if(periodvalue == 'MONTHLY'){
$(".isformonthly").removeClass('hidden');
$(".ismonthly").removeClass('hidden');
$(".ismonthly").prop('required',true);

$(".isforyearly").addClass('hidden');
$(".isyearly").addClass('hidden');

$(".isforbutton").removeClass('hidden');
$(".isbutton").removeClass('hidden');

}  else if(periodvalue == 'ANNUALLY'){
$(".isformonthly").addClass('hidden');
$(".ismonthly").addClass('hidden');
$(".ismonthly").prop('required',false);

$(".isforyearly").removeClass('hidden');
$(".isyearly").removeClass('hidden');
$(".isyearly").prop('required',true);

$(".isforbutton").removeClass('hidden');
$(".isbutton").removeClass('hidden');

}  else {
$(".isformonthly").addClass('hidden');
$(".ismonthly").addClass('hidden');
$(".ismonthly").prop('required',false);

$(".isforyearly").addClass('hidden');
$(".isyearly").addClass('hidden');
$(".isyearly").prop('required',false);

$(".isforbutton").addClass('hidden');
$(".isbutton").addClass('hidden');

$(".isforbutton").addClass('hidden');
$(".isbutton").addClass('hidden');

}


});

$(document).on('change','.trigers',function(){
$('#filterbutton').click();
});


$(document).on('change', '#period_id', function () {

        var periodvalue = $("#period_id option:selected").val(); 

        $(".isforbutton").removeClass('hidden');
        $(".isbutton").removeClass('hidden');
        
        if(periodvalue == 'MONTHLY'){
        $(".isformonthly").removeClass('hidden');
        $(".ismonthly").removeClass('hidden');
        $(".ismonthly").prop('required',true);
        
        $(".isforyearly").addClass('hidden');
        $(".isyearly").addClass('hidden');

        }  else if(periodvalue == 'ANNUALLY'){
        $(".isformonthly").addClass('hidden');
        $(".ismonthly").addClass('hidden');
        $(".ismonthly").prop('required',false);

        $(".isforyearly").removeClass('hidden');
        $(".isyearly").removeClass('hidden');
        $(".isyearly").prop('required',true);

        }  else {
        $(".isformonthly").addClass('hidden');
        $(".ismonthly").addClass('hidden');
        $(".ismonthly").prop('required',false);

        $(".isforyearly").addClass('hidden');
        $(".isyearly").addClass('hidden');
        $(".isyearly").prop('required',false);

        $(".isforbutton").addClass('hidden');
        $(".isbutton").addClass('hidden');

        }

        });

  </script>
  

@endsection
