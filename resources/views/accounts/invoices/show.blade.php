@extends('layouts.app')

@section('title', 'Invoice')

@section('head-css')
<link href="{{ asset('assets/DataTables/datatables.min.css')}}" rel="stylesheet">
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendors/prism/prism-okaidia.css') }}" rel="stylesheet">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet">

@section('content')

          <div class="row g-0">

            <div class="card mb-3">
              <div class="card-body">
                <div class="row justify-content-between align-items-center">
                  <div class="col-md">
                    <h5 class="mb-2 mb-md-0">Order #{{$invoice->number}}</h5>
                  </div>
                  <div class="col-auto">
                    {{-- <button class="btn btn-falcon-default btn-sm me-1 mb-2 mb-sm-0" type="button"><span class="fas fa-arrow-down me-1"> </span>Download (.pdf)</button> --}}
                    <a href="{{route('accounts.invoices.index')}}" class="btn btn-falcon-default btn-sm me-1 mb-2 mb-sm-0"> <span class="fas fa-eye" style="    margin-right: 5px;"> </span>See All</a>


                    @if(Auth::user()->hasAnyDirectPermission(['approve_invoice']) && $invoice->canApprove())

                    <a href="{{route('accounts.invoices.approve',$invoice)}}" data-ajax="true" class="btn btn-falcon-default btn-sm me-1 mb-2 mb-sm-0"> <span class="fas fa-check" style="    margin-right: 5px;"> </span>Approve</a>


                    <a href="{{route('accounts.invoices.edit',$invoice)}}" class="btn btn-falcon-default btn-sm me-1 mb-2 mb-sm-0"> <span class="fas fa-edit" style="    margin-right: 5px;"> </span>Edit</a>


@if(Auth::user()->hasAnyDirectPermission(['delete_invoice']))
<a href="" class="btn btn-falcon-default btn-sm me-1 mb-2 mb-sm-0" id="deletebtn"> <span class="fas fa-trash-alt" style="margin-right: 5px;"> </span>Delete</a> @endif

                    @endif

                    @if($invoice->invoiceStatus->code == 'APPROVED')
                    <a href="{{route('accounts.invoices.print',$invoice)}}" class="btn btn-falcon-default btn-sm me-1 mb-2 mb-sm-0"> <span class="fas fa-print me-1"> </span>Print</a>

                    <a href="{{route('accounts.invoices.payment',$invoice)}}" data-ajax="true" class="btn btn-falcon-default btn-sm me-1 mb-2 mb-sm-0"><span class="fas fa-dollar-sign me-1"></span>Make a Payment</a>

                    @endif



                  </div>
                </div>
              </div>
            </div>



            <div class="card mb-3">
            <div class="card-body">
              <div class="row align-items-center text-center mb-3">
                <div class="col-sm-9 text-sm-start"><img class="me-2" src="{{ asset('assets/img/logo.png')}}" alt=""  /></div>
                <div class="col text-sm-end mt-3 mt-sm-0">
                  <h2 class="mb-3">Invoice</h2>
                  <p class="fs--1 mb-0"></p>
                </div>
                <div class="col-12">
                  <hr />
                </div>
              </div>
              <div class="row align-items-center">
                <div class="col-sm-3">
                  <h6 class="text-500">Invoice to</h6>
                
                  <p class="fs--1">
                    {!! $invoice->address !!}
                  </p>
                 
                </div>
                <div class="col-sm-auto ms-auto">
                  <div class="table-responsive">
                    <table class="table table-sm table-borderless fs--1">
                      <tbody>
                        <tr>
                          <th class="text-sm-end">Invoice No:</th>
                          <td>{{$invoice->number}}</td>
                        </tr>
                        <tr>
                          <th class="text-sm-end">Date:</th>
                          <td>{{ Carbon\Carbon::parse($invoice->date)->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                          <th class="text-sm-end">Due Date:</th>
                          <td>{{ Carbon\Carbon::parse($invoice->due_date)->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                          <th class="text-sm-end">Tax:</th>
                          <td>{{$invoice->tax->code}}</td>
                        </tr>

                        <tr>
                          <th class="text-sm-end">Status:</th>
                          <td>{!! $invoice->invoiceStatusDisp() !!}</td>
                        </tr>

                        

                        <tr class="alert-success fw-bold">
                          <th class="text-sm-end">Amount:</th>
                          <td>{{$invoice->amountDisp()}}</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="table-responsive scrollbar mt-4 fs--1">
             
                @include('accounts.invoices.items-table')

              </div>
              <div class="row justify-content-end">
                <div class="col-auto">
                  <table class="table table-sm table-borderless fs--1 text-end">
                    <tr>
                      <th class="text-900">Subtotal:</th>
                      <td class="fw-semi-bold"> {{$invoice->amountDisp()}} </td>
                    </tr>
                    <tr>
                      <th class="text-900">Tax {{$invoice->tax->rate}}%:</th>
                      <td class="fw-semi-bold">{{$invoice->totalTaxDisp()}}</td>
                    </tr>
                    
                    <tr class="border-top border-top-2 fw-bolder text-900">
                      <th>TOTAL:</th>
                      <td>{{$invoice->totalDisp()}}</td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
            <div class="card-footer">
              <p class="fs--1 mb-0"><strong>Terms & Conditions: </strong>{!! $invoice->terms !!}</p>
            </div>
          </div>



          <div class="card mb-3">
            <div class="card-header bg-light">
              <div class="row flex-between-end">
                <div class="col-auto align-self-center">
                  <h5 class="mb-0" data-anchor="data-anchor" id="example">Payments<a class="anchorjs-link " aria-label="Anchor" data-anchorjs-icon="#" href="#example" style="padding-left: 0.375em;"></a></h5>
                </div>
                <div class="col-auto ms-auto">
                  <div class="nav nav-pills nav-pills-falcon flex-grow-1" role="tablist">
                  </div>
                </div>
              </div>
              
            </div>
            <div class="card-body text-justify">
            
              @include('accounts.invoices.payments_table')

            </div>


            
            
          </div>


          

          <div class="card mb-3">
            <div class="card-header bg-light">
              <div class="row flex-between-end">
                <div class="col-auto align-self-center">
                  <h5 class="mb-0" data-anchor="data-anchor" id="example">Actions<a class="anchorjs-link " aria-label="Anchor" data-anchorjs-icon="#" href="#example" style="padding-left: 0.375em;"></a></h5>
                </div>
                <div class="col-auto ms-auto">
                  <div class="nav nav-pills nav-pills-falcon flex-grow-1" role="tablist">
                  </div>
                </div>
              </div>
              
            </div>
            <div class="card-body text-justify">
            
              @include('accounts.invoices.actions_table')

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

<script type="text/javascript">
main.initAjax();
$('#sche-tbl').DataTable({
   ordering: false
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
  confirmButtonText: `<a href="{{route('accounts.invoices.delete',$invoice)}}"><i class='fa fa-thumbs-up'></i> Proceed
  </a>`,
  confirmButtonLink:"",
  cancelButtonText: `Cancel
  `,
  cancelButtonAriaLabel: "Thumbs down"
});
});

  </script>

@endsection

