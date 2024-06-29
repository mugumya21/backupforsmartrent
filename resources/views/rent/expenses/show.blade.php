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
                      <h5 class="mb-0" data-anchor="data-anchor" id="example">Expense<a class="anchorjs-link " aria-label="Anchor" data-anchorjs-icon="#" href="#example" style="padding-left: 0.375em;"></a></h5>
                    </div>
                    <div class="col-auto ms-auto">
<div class="nav nav-pills nav-pills-falcon flex-grow-1" role="tablist">

  
  @if(Auth::user()->hasAnyDirectPermission(['approve_expenses']) && $expense->canApprove())

  <a href="{{route('rent.expense.approve',$expense)}}" data-ajax="true" class="btn btn-sm active"> <span class="fas fa-check" style="    margin-right: 5px;"> </span>Approve</a>

  @if(Auth::user()->hasAnyDirectPermission(['edit_expenses']))
  <a href="{{route('rent.expenses.edit',$expense)}}" data-ajax="true" class="btn btn-sm active"> <span class="fas fa-edit" style="margin-right: 5px;"> </span>Edit</a>
  @endif

@if(Auth::user()->hasAnyDirectPermission(['delete_expenses']))
<a href="" class="btn btn-sm active" id="deletebtn"> <span class="fas fa-trash-alt" style="margin-right: 5px;"> </span>Delete</a> @endif

  @endif


                           
                          
                       
                      </div>
                    </div>
                  </div>
                  
                </div>
                <div class="card-body text-justify">
                
                 <div class="row">
                  <div class="col-6">
                
                  
                    <div class="row">
                      <div class="col-4 col-sm-6">
                        <p class="fw-semi-bold mb-1 text-end">Date:</p>
                      </div>
                      <div class="col">{{$expense->dateDisp()}}</div>
                    </div>
                    
                    <div class="row">
                      <div class="col-4 col-sm-6">
                        <p class="fw-semi-bold mb-1 text-end">Unit Number:</p>
                      </div>
                      <div class="col">@if(!empty($expense->unit)){{$expense->unit->name}}@endif</div>
                    </div>


                    <div class="row">
                      <div class="col-4 col-sm-6">
                        <p class="fw-semi-bold mb-1 text-end">Done By:</p>
                      </div>
                      <div class="col">{{$expense->createdBy->employee->full_name()}}</div>
                    </div>

                    <div class="row">
                      <div class="col-4 col-sm-6">
                        <p class="fw-semi-bold mb-1 text-end">Amount:</p>
                      </div>
                      <div class="col">{{$expense->amountDisp()}}</div>
                    </div>

                    <div class="row">
                      <div class="col-4 col-sm-6">
                        <p class="fw-semi-bold mb-1 text-end">Property:</p>
                      </div>
                      <div class="col">{{$expense->property->name}}</div>
                    </div>

                    <div class="row">
                      <div class="col-4 col-sm-6">
                        <p class="fw-semi-bold mb-1 text-end">Unit:</p>
                      </div>
                      <div class="col">{{$expense->unit->name}}</div>
                    </div>


                    <div class="row">
                      <div class="col-4 col-sm-6">
                        <p class="fw-semi-bold mb-1 text-end">Category:</p>
                      </div>
                      <div class="col">{{$expense->category->name}}</div>
                    </div>

                    <div class="row">
                      <div class="col-4 col-sm-6">
                        <p class="fw-semi-bold mb-1 text-end">Currency:</p>
                      </div>
                      <div class="col">{{$expense->currency->name}}</div>
                    </div>

                    <div class="row">
                      <div class="col-4 col-sm-6">
                        <p class="fw-semi-bold mb-1 text-end">Description:</p>
                      </div>
                      <div class="col">{{$expense->description}}</div>
                    </div>
                    
                  </div>



                  <div class="col-6">
                
                  
                    <div class="row">
                      <div class="col-4 col-sm-6">
                        <p class="fw-semi-bold mb-1 text-end">Status:</p>
                      </div>
                      <div class="col">{!! $expense->expenseStatusDisp() !!}</div>
                    </div>

                  </div>

                </div>

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
                
                  @include('rent.expenses.actions_table')

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

let url = "{{route('rent.expense.documents', $expense)}}";
main.loadRemote(url, '#documents-loader')

$('#reload-docs').click(function(){
  let url = "{{route('rent.expense.documents', $expense)}}";
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
  confirmButtonText: `<a href="{{route('rent.expense.delete',$expense)}}"><i class="fa fa-thumbs-up"></i> Proceed
  </a>`,
  confirmButtonLink:"",
  cancelButtonText: `Cancel
  `,
  cancelButtonAriaLabel: "Thumbs down"
});
});

  </script>

@endsection

