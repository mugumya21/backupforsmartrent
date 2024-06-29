@extends('layouts.app')

@section('title', 'Properties')

@section('head-css')

<link href="{{ asset('assets/DataTables/datatables.min.css')}}" rel="stylesheet">
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendors/prism/prism-okaidia.css') }}" rel="stylesheet">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/select2.min.css')}}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/css/dropzone.min.css') }}">


<style>
  table.table-bordered.dataTable {
    width: 100%;
}

div#unpaidrent_filter label {
    width: 100% !important;
    text-align: right;
}

div#unpaidrent_wrapper .col-sm-12.col-md-6 {
    width: 100%  !important;
}


div#defaulters_filter label {
    width: 100% !important;
    text-align: right;
}

div#defaulters_wrapper .col-sm-12.col-md-6 {
    width: 100%  !important;
}

  </style>

@section('content')

          <div class="row g-0">
            <div class="col-lg-9 pe-lg-2">
              <div class="card mb-3">
                <div class="card-header bg-light">
                  <div class="row flex-between-end">
                    <div class="col-auto align-self-center">
                      <h5 class="mb-0" data-anchor="data-anchor" id="example">Property<a class="anchorjs-link " aria-label="Anchor" data-anchorjs-icon="#" href="#example" style="padding-left: 0.375em;"></a></h5>
                    </div>

                    <div class="col-auto ms-auto">
                      <div class="nav nav-pills nav-pills-falcon flex-grow-1" role="tablist">
                        <a  href="{{route('rent.properties.edit',$property)}}" class="btn btn-sm active" type="button"  ><i class="fas fa-edit"></i> Edit</a>

<a href="{{route('rent.properties.create')}}" class="btn btn-sm active"  type="button" > <i class="fas fa-plus"></i> Create New</a>

<a href="{{route('rent.properties.index')}}" class="btn btn-sm active"  type="button" > <i class="far fa-eye"></i> View All</a>

                      </div>
                    </div>


                  </div>

                </div>
                <div class="card-body text-justify">
                  <div class="row">
                  <div class="col-sm-3">

<div class="card-img-top" id="profilepic-loader">

</div>



                  </div>

                  <div class="col-sm-4">
                    <h5 class="mt-3 mt-sm-0 bigname">{{$property->name}}</h5>
                    <p class="fs--1 mb-2 mb-md-3"><i>{{ $property->number}}</i></p>
                                      </div>



                                     </div>
                </div>

              </div>

              <div class="card mb-3">
                <div class="card-header bg-light d-flex justify-content-between tabbedheader nopadding-left-right">
                  <ul class="nav nav-tabs" id="myTab" role="tablist" style="    width: 100%;">

                    <li class="nav-item"><a class="nav-link active" id="details-tab" data-bs-toggle="tab" href="#details" role="tab" aria-controls="tab-home" aria-selected="true">Details</a></li>

                    <li class="nav-item"><a class="nav-link" id="document-tab" data-bs-toggle="tab" href="#document" role="tab" aria-controls="tab-contact" aria-selected="false">Documents</a></li>

                    <li class="nav-item"><a class="nav-link" id="floor-tab" data-bs-toggle="tab" href="#floors" role="tab" aria-controls="tab-contact" aria-selected="false">Floors</a></li>

                    <li class="nav-item"><a class="nav-link" id="units-tab" data-bs-toggle="tab" href="#units" role="tab" aria-controls="tab-profile" aria-selected="false">Units</a></li>

                    <li class="nav-item"><a class="nav-link" id="tenant-tab" data-bs-toggle="tab" href="#tenant" role="tab" aria-controls="tab-contact" aria-selected="false">Tenant Units</a></li>


                    <li class="nav-item"><a class="nav-link" id="invoice-tab" data-bs-toggle="tab" href="#invoice" role="tab" aria-controls="tab-contact" aria-selected="false">Invoices</a></li>


                    <li class="nav-item"><a class="nav-link" id="payment-tab" data-bs-toggle="tab" href="#payment" role="tab" aria-controls="tab-contact" aria-selected="false">Payments</a></li>


                    <li class="nav-item" style="border-right: none;"><a class="nav-link" id="expense-tab" data-bs-toggle="tab" href="#expense" role="tab" aria-controls="tab-contact" aria-selected="false">Expenses</a></li>



                  </ul>
                </div>
                <div class="card-body">

                  <div class="tab-content" id="myTabContent">


                    <div class="tab-pane fade show active" id="details" role="tabpanel" aria-labelledby="details-tab">

                      <div class="row">
                      <div class="col-6">

                        <div class="row">
                          <div class="col-4 col-sm-5">
                            <p class="fw-semi-bold mb-1 text-end">Property Name:</p>
                          </div>
                          <div class="col">{{$property->name}}</div>
                        </div>

                        <div class="row">
                          <div class="col-4 col-sm-5">
                            <p class="fw-semi-bold mb-1 text-end">Number:</p>
                          </div>
                          <div class="col">{{$property->number}}</div>
                        </div>


                        <div class="row">
                          <div class="col-4 col-sm-5">
                            <p class="fw-semi-bold mb-1 text-end">Location:</p>
                          </div>
                          <div class="col">{{$property->location}}</div>
                        </div>


                        <div class="row">
                          <div class="col-4 col-sm-5">
                            <p class="fw-semi-bold mb-1 text-end">Square Maters:</p>
                          </div>
                          <div class="col">{{$property->square_meters}}</div>
                        </div>
                      </div>

                      <div class="col-6">

                        <div class="row">
                          <div class="col-4 col-sm-5">
                            <p class="fw-semi-bold mb-1 text-end">Type:</p>
                          </div>
                          <div class="col">{{$property->propertyType->name}}</div>
                        </div>

                        <div class="row">
                          <div class="col-4 col-sm-5">
                            <p class="fw-semi-bold mb-1 text-end">Category:</p>
                          </div>
                          <div class="col">{{$property->category->name}}</div>
                        </div>


                        <div class="row">
                          <div class="col-4 col-sm-5">
                            <p class="fw-semi-bold mb-1 text-end">Added Date:</p>
                          </div>
                          <div class="col">{{$property->createdDate()}}</div>
                        </div>
                      </div>


                      <div class="col-12" style="margin-top: 30px">
                        <div class="row">
                          <div class="col-4 col-sm-12">
                            <p class="fw-semi-bold mb-1 ">Description:</p>
                          </div>
                          <div class="col">{{$property->description}}</div>
                        </div>
                      </div>

                    </div>
                    </div>

                    <div class="tab-pane fade" id="manager" role="tabpanel" aria-labelledby="manager-tab">
                      <div class="actions showbuttons">
                        </div> <div style="clear:both;"></div>

                    </div>

                    <div class="tab-pane fade" id="units" role="tabpanel" aria-labelledby="units-tab">
                      <div class="actions showbuttons">

                        @if(FrontEndHelper::subscriptionlimit() == 'OVER_THRESHHOLD')
                        <a href="" class="btn btn-primary btn-sm" id="expirybtn"><span class="fas fa-plus me-1" data-fa-transform="shrink-3"></span>Add</a>
                        @else
                        <a href="{{route('rent.units.add',$property->id)}}" class="btn btn-primary btn-sm" data-ajax="true"><span class="fas fa-plus me-1" data-fa-transform="shrink-3"></span>Add</a>
                        @endif


                        </div> <div style="clear:both;"></div>

                      <div id="units-tab-loader"></div>
                    </div>

                    <div class="tab-pane fade" id="tenant" role="tabpanel" aria-labelledby="tenant-tab">

                      <div class="actions showbuttons">
                        <a href="{{route('rent.tenantunits.add',$property->id)}}" class="btn btn-primary btn-sm" data-ajax="true"><span class="fas fa-plus me-1" data-fa-transform="shrink-3"></span>Add</a>

                        </div> <div style="clear:both;"></div>
                        <div id="tenant-tab-loader"></div>


                    </div>

                    <div class="tab-pane fade" id="floors" role="tabpanel" aria-labelledby="floor-tab">
                      <div class="actions showbuttons">
                        <a href="{{route('rent.floors.add',$property->id)}}" class="btn btn-primary btn-sm" data-ajax="true"><span class="fas fa-plus me-1" data-fa-transform="shrink-3"></span>Add</a>

                        </div> <div style="clear:both;"></div>
                      <div id="floor-tab-loader"></div>
                    </div>


                    <div class="tab-pane fade" id="invoice" role="tabpanel" aria-labelledby="invoice-tab">

                      <div class="actions showbuttons">
                        <a href="{{route('accounts.invoices.create')}}" class="btn btn-primary btn-sm" ><span class="fas fa-plus me-1" data-fa-transform="shrink-3"></span>Add</a>

                        </div> <div style="clear:both;"></div>
                      <div id="invoice-tab-loader"></div>

                    </div>
                    <div class="tab-pane fade" id="payment" role="tabpanel" aria-labelledby="payment-tab">

                      <div class="actions showbuttons">
                        <a href="{{route('rent.payments.add',$property->id)}}" class="btn btn-primary btn-sm" data-ajax="true"><span class="fas fa-plus me-1" data-fa-transform="shrink-3"></span>Add</a>

                        </div> <div style="clear:both;"></div>
                      <div id="payment-tab-loader"></div>

                    </div>


                    <div class="tab-pane fade" id="document" role="tabpanel" aria-labelledby="document-tab">
                    <div class="actions showbuttons">
                      <button type="button" class="btn btn-primary btn-sm addocsbtn" ><span class="fas fa-plus me-1" data-fa-transform="shrink-3"></span>Add</button>

                      </div> <div style="clear:both;"></div>

                      <div>
                      @include('documents.form')
                      </div>

                    <div id="documents-tab-loader"></div>
                    <div id="gallery-tab-loader"></div>
                  </div>





                  <div class="tab-pane fade" id="expense" role="tabpanel" aria-labelledby="expense-tab">
                    <div class="actions showbuttons">
                      <a href="{{route('rent.expenses.add',$property)}}" class="btn btn-primary btn-sm" data-ajax="true"><span class="fas fa-plus me-1" data-fa-transform="shrink-3"></span>Add</a>

                      </div> <div style="clear:both;"></div>
                    <div id="expense-tab-loader"></div>
                  </div>





                  </div>



                </div>
              </div>

            </div>


            @include('rent.properties.sidebar')



          </div>




@endsection


@section('include-js')

<script src="{{ asset('assets/js/sweetalert2@11.js') }}"></script>
<script src="{{ asset('assets/js/dropzone.min.js') }}"></script>
<script src="{{ asset('assets/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/form-advanced.init.js') }}"></script>

<script src="{{ asset('assets/js/main.js') }}"></script>
<script src="{{ asset('assets/DataTables/datatables.min.js')}}"></script>
<script src="{{ asset('assets/js/dropzoneinit.js')}}"></script>


<script type="text/javascript">
      main.initAjax();

$('#documents_tbl').DataTable();
$('#units_tbl').DataTable();
$('#unpaidrent').DataTable({
  "bLengthChange":false,
  "info":false
});

$('#defaulters').DataTable({
  "bLengthChange":false,
  "info":false
});


let profilepicurl = "{{route('rent.propertyprofilepic', $property)}}";
main.loadRemote(profilepicurl, '#profilepic-loader')

$('#units-tab').click(function(){
let unitsurl = "{{route('rent.units.unitsonproperty', $property)}}";
main.loadRemote(unitsurl, '#units-tab-loader')
});


$('#tenant-tab').click(function(){
let tenantuniturl = "{{route('rent.tenantunits', $property)}}";
main.loadRemote(tenantuniturl, '#tenant-tab-loader')
});


$('#floor-tab').click(function(){
let floorsurl = "{{route('rent.floors.floorsonproperty', $property)}}";
main.loadRemote(floorsurl, '#floor-tab-loader')
});

$('#invoice-tab').click(function(){
let invoiceurl = "{{route('accounts.invoices.invoicesonproperty', $property)}}";
main.loadRemote(invoiceurl, '#invoice-tab-loader')
});

$('#payment-tab').click(function(){
let paymenturl = "{{route('rent.payments.list', $property)}}";
main.loadRemote(paymenturl, '#payment-tab-loader')
});

$('#document-tab').click(function(){
let paymenturl = "{{route('main.documents.list', [$property,$property->documenttype()->id])}}";
main.loadRemote(paymenturl, '#documents-tab-loader');
$('.dropzone').hide();
$('#message').hide();

let galleryurl = "{{route('main.documents.gallery', [$property,$property->documenttype()->id])}}";
main.loadRemote(galleryurl, '#gallery-tab-loader');

});


$('#expense-tab').click(function(){
let paymenturl = "{{route('rent.expenses.list', $property)}}";
main.loadRemote(paymenturl, '#expense-tab-loader')
});

$('#expirybtn').click(function(e){
  e.preventDefault();
  Swal.fire({
  icon: "error",
  title: "",
  text: "You have reached the limit for your UNITS Subscription!",
  footer: '<i>Contact Support for help!</i>'
});
});





  </script>

@endsection

