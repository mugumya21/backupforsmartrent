@extends('layouts.app')

@section('title', 'Properties')

@section('head-css')

<link rel="stylesheet" href="{{ asset('assets/css/dropzone.min.css') }}">
<link href="{{ asset('assets/DataTables/datatables.min.css')}}" rel="stylesheet">
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendors/prism/prism-okaidia.css') }}" rel="stylesheet">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet">

@section('content')

          <div class="row g-0">
            <div class="col-lg-12 pe-lg-2">
              <div class="card mb-3">
                <div class="card-header bg-light">
                  <div class="row flex-between-end">
                    <div class="col-auto align-self-center">
                      <h5 class="mb-0" data-anchor="data-anchor" id="example">Payment Schedule<a class="anchorjs-link " aria-label="Anchor" data-anchorjs-icon="#" href="#example" style="padding-left: 0.375em;"></a></h5>
                    </div>
                    <div class="col-auto ms-auto">
                      <div class="nav nav-pills nav-pills-falcon flex-grow-1" role="tablist">
                        @if($tenantunit->canEdit())
<a  href="{{route('rent.tenantUnits.edit',$tenantunit)}}" data-ajax="true" class="btn btn-sm active" type="button"  ><i class="fas fa-edit"></i> Edit</a>

<a href="" class="btn btn-sm active" id="deletebtn"  type="button" > <i class="fas fa-trash"></i> Delete</a>
@endif
                       
                      </div>
                    </div>
                  </div>
                  
                </div>
                <div class="card-body text-justify row">
                
                  <div class="col-4">
                
                  
                    <div class="row">
                      <div class="col-4 col-sm-6">
                        <p class="fw-semi-bold mb-1 text-end">Tenant:</p>
                      </div>
                      <div class="col">{{$tenantunit->tenant->clientname()}}</div>
                    </div>

                    
                    <div class="row">
                      <div class="col-4 col-sm-6">
                        <p class="fw-semi-bold mb-1 text-end">Unit Number:</p>
                      </div>
                      <div class="col">{{$tenantunit->unit->name}}</div>
                    </div>


                    
                    <div class="row" style="margin-top:20px">
                      <div class="col-4 col-sm-6">
                        <p class="fw-semi-bold mb-1 text-end"><u>Tenancy Details</u></p>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-4 col-sm-6">
                        <p class="fw-semi-bold mb-1 text-end">Period:</p>
                      </div>
                      <div class="col">{{$tenantunit->period->name}}</div>
                    </div>

                    <div class="row">
                      <div class="col-4 col-sm-6">
                        <p class="fw-semi-bold mb-1 text-end">Number:</p>
                      </div>
                      <div class="col">{{$tenantunit->duration}}</div>
                    </div>

                    <div class="row">
                      <div class="col-4 col-sm-6">
                        <p class="fw-semi-bold mb-1 text-end">Start:</p>
                      </div>
                      <div class="col">{{$tenantunit->shortFromDate()}}</div>
                    </div>


                    <div class="row">
                      <div class="col-4 col-sm-6">
                        <p class="fw-semi-bold mb-1 text-end">End:</p>
                      </div>
                      <div class="col">{{$tenantunit->shortToDate()}}</div>
                    </div>


                  </div>


                  <div class="col-4">
                    <div class="row">
                      <div class="col-4 col-sm-6">
                        <p class="fw-semi-bold mb-1 text-end">Currency:</p>
                      </div>
                      <div class="col">{{$tenantunit->currency->name}}</div>
                    </div>
                  </div>

                </div>
              </div>

              <div class="card mb-3">
                <div class="card-header bg-light">
                  <div class="row flex-between-end">
                    <div class="col-auto align-self-center">
                      <h5 class="mb-0" data-anchor="data-anchor" id="example">Breakdown<a class="anchorjs-link " aria-label="Anchor" data-anchorjs-icon="#" href="#example" style="padding-left: 0.375em;"></a></h5>
                    </div>
                    <div class="col-auto ms-auto">
                      <div class="nav nav-pills nav-pills-falcon flex-grow-1" role="tablist">
                      </div>
                    </div>
                  </div>
                  
                </div>
                <div class="card-body text-justify">
                
                  @include('rent.tenantunits.schedules')

                </div>


                
                
              </div>

              
              <div class="card mb-3">
                <div class="card-header bg-light">
                  <div class="row flex-between-end">
                    <div class="col-auto align-self-center">
                      <h5 class="mb-0" data-anchor="data-anchor" id="example">Documents<a class="anchorjs-link " aria-label="Anchor" data-anchorjs-icon="#" href="#example" style="padding-left: 0.375em;"></a></h5>
                    </div>
                    <div class="col-auto ms-auto">
                      <div class="nav nav-pills nav-pills-falcon flex-grow-1 addocsbtn" role="tablist">
                        <button type="button" class="btn btn-sm active"  type="button" > <i class="fas fa-plus"></i> Add</button>
                       
                       
                      </div>
                    </div>
                  </div>
                  
                </div>
                <div class="card-body text-justify">
              
                  @include('documents.form') 
                  <button type="button" id="reload-docs" class="hidden"></button>      

                  <div id="documents-tab-loader"></div>

                </div>


                
                
              </div>










            
            </div>
            

          


          </div>
          

     

@endsection


@section('include-js')

<script src="{{ asset('assets/js/sweetalert2@11.js') }}"></script>
<script src="{{ asset('assets/js/dropzone.min.js') }}"></script>
<script src="{{ asset('assets/js/cleave.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>
<script src="{{ asset('assets/js/jquery-3.7.1.js') }}"></script>
<script src="{{ asset('assets/DataTables/datatables.min.js')}}"></script>
<script src="{{ asset('assets/js/dropzoneinit.js')}}"></script>

<script type="text/javascript">
main.initAjax();
$('#sche-tbl').DataTable({
   ordering: false
});

$(document).ready(function() {
let paymenturl = "{{route('main.documents.list', [$tenantunit,$tenantunit->documenttype()->id])}}";
main.loadRemote(paymenturl, '#documents-tab-loader');
});

$('#reload-docs').click(function(){
  let paymenturl = "{{route('main.documents.list', [$tenantunit,$tenantunit->documenttype()->id])}}";
main.loadRemote(paymenturl, '#documents-tab-loader');
});


$('#documents_tbl').DataTable();

$('#deletebtn').click(function(e){
  e.preventDefault();
  Swal.fire({
  title: "",
  icon: "warning",
  html: `Are you sure you want to delete this item?`,
  showCloseButton: true,
  showCancelButton: true,
  focusConfirm: false,
  confirmButtonText: `<a href="{{route('rent.tenantunits.delete',$tenantunit)}}"><i class="fa fa-thumbs-up"></i> Proceed
  </a>`,
  confirmButtonLink:"",
  cancelButtonText: `Cancel
  `,
  cancelButtonAriaLabel: "Thumbs down"
});
});


  </script>

@endsection

