@extends('layouts.modal-app')
@section('size')
{{-- modal-lg mt-6 --}}
@endsection

<link href="{{ asset('assets/css/select2.min.css')}}" rel="stylesheet">

@section('modal-content')

 <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">

                          <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

<div class="modal-body p-0">
        <div class="bg-light rounded-top-lg py-2 ps-3 pe-6">
          <h4 class="" id="staticBackdropLabel">Edit Expenses</h4>
        
        </div>
<div class="p-3">

<span id="payerror" style=""></span>

 {{ html()->form('PUT')->route('rent.expenses.update',$expense)->class('row g-3 needs-validation')->novalidate()->open() }}


 {{ html()->hidden('property_id')->value($expense->property_id)->placeholder('')->class('form-control form-control-sm') }}


 <div class="col-md-6">
  <label class="form-label asterik" for="code">Date</label>
  {{ html()->text('date')->placeholder('Date')->value($expense->date)->class('form-control form-control-sm datetimepicker')->required()->id('datepicker') }}
</div>


<div class="col-md-6">
  <label class="form-label asterik" for="code">Currency</label>
  {{ html()->select('currency_id')->options($currencies->pluck('name','id'))->value($expense->currency_id)->required()->placeholder('Select an Option')->class('form-select form-select-sm js-choice')->id('currencyid') }}
</div>
  


<div class="col-md-6">
  <label class="form-label" for="code">Unit</label>
  {{ html()->select('unit_id')->options($units->pluck('name','id'))->value($expense->unit_id)->placeholder('Select an Option')->class('form-select form-select-sm js-choice')->id('currencyid') }}
</div>
  


<div class="col-md-6">
  <label class="form-label" for="code">Category</label>
  {{ html()->select('category_id')->options($categories->pluck('name','id'))->value($expense->category_id)->placeholder('Select an Option')->class('form-select form-select-sm js-choice')->id('currencyid') }}
</div>
  

  <div class="col-md-6">
  <label class="form-label asterik" for="code">Amount</label>
    {{ html()->text('amount')->required()->placeholder('Amount')->value($expense->amount)->class('form-control form-control-sm unit_amount_value comma-separated')->id('validationCustom01') }}
  </div>


  <div class="col-md-12">
    <label class="form-label" for="code">Description</label>
     {{ html()->textarea('description')->placeholder('Description')->value($expense->description)->class('form-control form-control-sm')->rows('3') }}
   </div>
   
 
  <div class="d-grid gap-2">
       <button class="btn btn-primary" id="submitbtn" type="submit">Submit</button>
  </div>
 
{{ html()->form()->close() }}

     
        
        </div>
      </div>

      @endsection

      
<script src="{{ asset('assets/js/flatpickr.js') }}"></script>
<script src="{{ asset('vendors/prism/prism.js') }}"></script>
<script src="{{ asset('assets/js/theme.js') }}"></script>
<link href="{{ asset('assets/css/select2.min.css')}}" rel="stylesheet">
      
<script src="{{ asset('assets/js/cleave.js') }}"></script>
<script src="{{ asset('assets/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/form-advanced.init.js') }}"></script>



<script>
 main.init();

 $(".datetimepicker").flatpickr({ 
   dateFormat: "d/m/Y",
   allowInput: true,
   altInput: true, 
   altFormat: "d/m/Y",
});

</script>
