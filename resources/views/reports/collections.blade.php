@extends('layouts.app')

@section('title', 'Unpaid Rent')


@section('head-css')
<link href="{{ asset('assets/DataTables/datatables.min.css')}}" rel="stylesheet">
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendors/prism/prism-okaidia.css') }}" rel="stylesheet">

<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet">


@section('content')


<div class="card mb-3">

  
  {{ html()->form('get')->route('reports.collections')->class('')->id('form-submit')->novalidate()->open() }}

  <div class="card-header bg-light">
    <div class="row flex-between-end">
      <div class="col-auto align-self-center">
        <h5 class="mb-0" data-anchor="data-anchor">Collections Report</h5>
      </div>

      <div class="col-auto ms-auto">
        <div class="nav nav-pills nav-pills-falcon flex-grow-1" role="tablist">


          <button type="submit" value="PRINT" name="submit" class="btn btn-sm active"> <i class="fas fa-print"></i> Print Preview</button>



          {{-- <button class="btn btn-sm active dropdown-toggle" type="button" data-bs-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false">Filter</button> --}}

          {{-- <div class="dropdown-menu py-0">
            <div class="card shadow-none border-0" style="width: 22rem;">
              <div class="card-body">
                


                <div class="row">
                  <div class="col-md-6">
                    <label class="form-label" for="code">From Date</label>
                    {{ html()->text('from')->class('form-control form-control-sm datetimepicker fromdate trigers')->value($search->from)->id('datepicker')->placeholder('from Date') }}
                  </div>
                  
                  <div class="col-md-6">
                    <label class="form-label" for="code">To Date</label>
                    {{ html()->text('to')->class('form-control form-control-sm datetimepicker todate trigers')->value($search->to)->id('datepicker')->placeholder('To Date') }}
                  </div>   


                <div class="col-md-12">
                  <label class="form-label" for="code">Unit</label>
                {{ html()->select('unit_id')->options($allunits->pluck('name','id'))->value($search->unit_id)->class('form-select form-select-sm trigers')->placeholder('Select an Option') }}
                                </div>


                                <div class="col-md-6">
                                  <label class="form-label" for="code">Rental From Date</label>
                                  {{ html()->text('schedule_from')->class('form-control form-control-sm datetimepicker fromdate trigers')->value($search->from)->id('datepicker')->placeholder('from Date') }}
                                </div>
                                
                                <div class="col-md-6">
                                  <label class="form-label" for="code">Rental To Date</label>
                                  {{ html()->text('schedule_to')->class('form-control form-control-sm datetimepicker todate trigers')->value($search->to)->id('datepicker')->placeholder('To Date') }}
                                </div>
                                


<div class="col-md-12">
  <label class="form-label" for="code">Tenant</label>
<select name="tenant_id" class="form-select form-select-sm trigers" required="" id="tenant_unit_id">

  @if(!empty($search->tenant_selected))
  <option selected value="{{$search->tenant_selected->id}}">{{$search->tenant_selected->clientname()}}</option>
  @else
  <option value="">Select an Option</option>
  @endif
  @foreach($clients as $client)
  <option value="{{$client->id}}">{{$client->clientname()}}</option>
  @endforeach
</select>
</div>



</div>

                <div class="row g-2 mt-2">
                  <div class="col-sm-6">
                    
                
                    <a class="btn btn-secondary me-1 mb-1 fullwidth" style="padding:4px" href="{{route('reports.collections')}}" aria-expanded="false"> Reset </a>

                  </div>
                  <div class="col-sm-6">
                    
                  
                  
                  </div>
                </div>

                

             


              </div>
            </div>
          </div> --}}

  

        </div>
      </div>
    </div>
    
  </div>

  <div class="card-body" style="padding-top: 0px; padding-bottom: 0px;">

    <div class="row">
  <div class="col-md-3" style="padding-right:0px;">
    <label class="form-label" for="code">Select a Property to populate data</label>
  {{ html()->select('property_id')->options($properties->pluck('name','id'))->value($search->property_id)->class('form-select form-select-sm js-choice trigers')->placeholder('Select an Option') }}
  </div>

  <div class="col-md-3">
    <label class="form-label" for="code">Filter by Months</label>
    <select name="period_date" class="form-select form-select-sm js-choice trigers" required="">
      <option value=""></option>
    
<option value="{{$search->thismonth}}" @if($search->period_date == $search->thismonth) selected @endif>This month</option>
<option value="{{$search->lastmonth}}" @if($search->period_date == $search->lastmonth) selected @endif>Last month</option>
    
      @foreach($search->dates as $date)
      <option value="{{$date}}" @if($search->period_date == $date) selected @endif> {{ Carbon\Carbon::parse($date)->format('F y') }}</option>
      @endforeach
    </select>
  </div>


  <div class="col-md-3" style="padding-right:0px;">
    <label class="form-label" for="code">Currency</label>
  {{ html()->select('currency_id')->options($currencies->pluck('name','id'))->value($search->currency_id)->class('form-select form-select-sm js-choice trigers')->placeholder('') }}
  </div>


  </div>

  <button name='form-submit' style="padding:4px" class=" hidden btn btn-primary me-1 mb-1 fullwidth"  id="filterbutton" type="submit">Filter
  </button>
  
  

  </div>

  {{ html()->form()->close() }}



  <div class="card-body text-justify">
  
    @if(!empty($search->property_id))
    @include('reports.collections_table',['schedules'=>$schedules])
    @endif

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

// let url = "{{route('reports.unpaidrent')}}";
// main.loadRemote(url, '#items-loader');

var total = $("#totalclass").val();
$("#grandtotal").html(total);


});

$(document).on('change','.trigers',function(){
$('#filterbutton').click();
});




// $("#form-submit").submit(function(e) {
          
//             let button = $("button[type=submit][clicked=true]");

//             let form = $("#form-submit");
//             let url = form.attr('action');

//             let data = form.serializeArray(); // convert form to array
//             data.push({
//                 name: "submit",
//                 value: button.val()
//             });

//             $.ajax({
//                 method: "get",
//                 url: url,
//                 data: $.param(data)
//             }).done(function(data, textStatus, jqXHR) {



//             }).fail(function(jqXHR, textStatus, errorThrown) {

//                 _.each(jqXHR.responseJSON.errors, function(value, key, list) {
                  
//                 });

//             }).always(function(data, textStatus, jqXHR) {

//             });
//         })

  </script>
  

@endsection
