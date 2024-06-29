@extends('layouts.app')

@section('title', 'Properties')

@section('head-css')


<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendors/prism/prism-okaidia.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/css/dropzone.min.css') }}">
<link href="{{ asset('assets/DataTables/datatables.min.css')}}" rel="stylesheet">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet">

@section('content')

          <div class="row g-0">
            <div class="col-lg-12 pe-lg-2">
              <div class="card mb-3">
                <div class="card-header bg-light">
                  <div class="row flex-between-end">
                    <div class="col-auto align-self-center">
                      <h5 class="mb-0" data-anchor="data-anchor" id="example">Payment<a class="anchorjs-link " aria-label="Anchor" data-anchorjs-icon="#" href="#example" style="padding-left: 0.375em;"></a></h5>
                    </div>
                    <div class="col-auto ms-auto">
                      <div class="nav nav-pills nav-pills-falcon flex-grow-1" role="tablist">
                        <a href="{{route('rent.payments.print',$payment)}}" class="btn btn-sm active"  type="button" > <i class="fas fa-print"></i> Print Receipt</a>
                       
                          
    <a href="" class="btn btn-sm active" id="deletebtn"  type="button" > <i class="fas fa-trash"></i> Delete</a>

                           
                          
                       
                      </div>
                    </div>
                  </div>
                  
                </div>
                <div class="card-body text-justify">
                
                  <div class="col-6">
                
                  
                    <div class="row">
                      <div class="col-4 col-sm-6">
                        <p class="fw-semi-bold mb-1 text-end">Tenant:</p>
                      </div>
                      <div class="col">{{$payment->tenantunit->tenant->clientname()}}</div>
                    </div>

                    
                    <div class="row">
                      <div class="col-4 col-sm-6">
                        <p class="fw-semi-bold mb-1 text-end">Unit Number:</p>
                      </div>
                      <div class="col">{{$payment->tenantunit->unit->name}}</div>
                    </div>

                    <div class="row">
                      <div class="col-4 col-sm-6">
                        <p class="fw-semi-bold mb-1 text-end">Date:</p>
                      </div>
                      <div class="col">{{$payment->date()}}</div>
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
                
                  @include('rent.payments.items')

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
<div id="documents-loader"></div>
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
<script src="{{ asset('assets/DataTables/datatables.min.js')}}"></script>
<script src="{{ asset('assets/js/dropzoneinit.js')}}"></script>

<script type="text/javascript">
main.initAjax();
$('#sche-tbl').DataTable({
   ordering: false
});
 
$('#documents_tbl').DataTable();

let url = "{{route('rent.payment.documents', $payment)}}";
main.loadRemote(url, '#documents-loader')

$('#reload-docs').click(function(){
  let url = "{{route('rent.payment.documents', $payment)}}";
  main.loadRemote(url, '#documents-loader')
});


$('#deletebtn').click(function(e){
  e.preventDefault();
  Swal.fire({
  title: "",
  icon: "warning",
  html: `Are you sure you want to delete this item?`,
  showCloseButton: true,
  showCancelButton: true,
  focusConfirm: false,
  confirmButtonText: `<a href="{{route('rent.payment.delete',$payment)}}"><i class="fa fa-thumbs-up"></i> Proceed
  </a>`,
  confirmButtonLink:"",
  cancelButtonText: `Cancel
  `,
  cancelButtonAriaLabel: "Thumbs down"
});
});

  </script>

@endsection

