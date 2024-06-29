@extends('layouts.app')

@section('title', 'Payments Report')


@section('head-css')
<link href="{{ asset('assets/DataTables/datatables.min.css')}}" rel="stylesheet">
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet">


@section('content')


<div class="card mb-3">

  <div class="card-header bg-light">
    <div class="row flex-between-end">
      <div class="col-auto align-self-center">
        <h5 class="mb-0" data-anchor="data-anchor">Lease Agreement Report<a class="anchorjs-link " aria-label="Anchor" data-anchorjs-icon="#" href="#example" style="padding-left: 0.375em;"></a></h5>
      </div>
      <div class="col-auto ms-auto">
        <div class="nav nav-pills nav-pills-falcon flex-grow-1" role="tablist">

          <button class="btn btn-sm active dropdown-toggle" type="button" data-bs-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false">Filter</button>

          <div class="dropdown-menu py-0">
            <div class="card shadow-none border-0" style="width: 22rem;">
              <div class="card-body">
                
 {{ html()->form('get')->route('reports.leasestatus')->class('nobottompadding')->id('form-submit')->novalidate()->open() }}

                <div class="row">
            
                
<div class="col-md-12">
  <label class="form-label" for="code">Property</label>
{{ html()->select('property_id')->options($properties->pluck('name','id'))->value($search->property_id)->class('form-select form-select-sm trigers')->placeholder('') }}
                </div>


                <div class="col-md-12">
                  <label class="form-label" for="code">Unit</label>
                {{ html()->select('unit_id')->options($units->pluck('name','id'))->value($search->unit_id)->class('form-select form-select-sm trigers')->placeholder('') }}
                                </div>              

<div class="col-md-12">
  <label class="form-label" for="code">Tenant</label>
<select name="tenant_id" class="form-select form-select-sm trigers" required="" id="tenant_unit_id">

  @if(!empty($search->tenant_selected))
  <option selected value="{{$search->tenant_selected->id}}">{{$search->tenant_selected->clientname()}}</option>
  @else
  <option value=""></option>
  @endif
  @foreach($clients as $client)
  <option value="{{$client->id}}">{{$client->clientname()}}</option>
  @endforeach
</select>
</div>



</div>

                <div class="row g-2 mt-2">
                  <div class="col-sm-6">
                    
                
                    <a class="btn btn-secondary me-1 mb-1 fullwidth filterbutton" href="{{route('reports.leasestatus')}}" aria-expanded="false"> Reset </a>

                  </div>
                  <div class="col-sm-6">
                    
                    <button name='form-submit' class="btn btn-primary me-1 mb-1 fullwidth filterbutton"  id="filterbutton" type="submit">Filter
                    </button>
                  
                  </div>
                </div>

                
{{ html()->form()->close() }}
             


              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
    
  </div>

  <div class="card-body text-justify">
    @include('reports.lease_table',['tenantunits'=>$tenantunits])
  </div>
  
</div>


@endsection


@section('include-js')


      
<script src="{{ asset('assets/js/flatpickr.js') }}"></script>



<script src="{{ asset('assets/js/main.js') }}"></script>
<script src="{{ asset('assets/DataTables/datatables.min.js')}}"></script>

<script>
main.init();


$('#example').DataTable({
  dom: 'Bfrtip',
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



$(document).on('change','.fromdate',function(){
var date = $(this).val();
let datespilt = date.split("-");
var year = datespilt[0];
var month = datespilt[1];
var day = datespilt[2];

var nextmonth = parseInt(month) + 1;

var todate = year + '-' + '' + nextmonth + '-'  + '' + day + '';

$('.todate').val(todate);

});

  </script>
  

@endsection
