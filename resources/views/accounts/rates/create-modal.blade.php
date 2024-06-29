@extends('layouts.modal-app')
@section('size')
{{-- modal-lg mt-6 --}}
@endsection
@section('modal-content')

 <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">

                          <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

<div class="modal-body p-0">
        <div class="bg-light rounded-top-lg py-2 ps-3 pe-6">
          <h4 class="" id="staticBackdropLabel">Add a currency rate</h4>
        
        </div>
<div class="p-3" style="margin-top:10px">
     
@if( $currencyrate->id > 0 )
  {{ html()->form('PUT')->route('accounts.rates.update',$currencyrate)->class('row g-3 needs-validation')->novalidate()->open() }}
 
 @else
 {{ html()->form('POST')->route('accounts.rates.store')->class('row g-3 needs-validation')->id('modal-form-submit')->novalidate()->open() }}
 @endif



  <div class="col-md-6">
    <label class="form-label asterik" for="code">Currency</label>
    {{ html()->select('currency_id')->options($currencies->pluck('name','id'))->value($currencyrate->currency_id)->required()->placeholder('Select an Option')->class('form-select form-select-sm') }}
</div>

<div class="col-md-6">
  <label class="form-label asterik" for="code">Date</label>
  {{ html()->text('date')->placeholder('Start Date')->value($currencyrate->date)->class('form-control form-control-sm datetimepicker')->value('')->id('datepicker') }}
</div>


<div class="col-md-6">
  <label class="form-label asterik" for="code">Buying </label>
  {{ html()->text('buying')->autofocus()->required()->value($currencyrate->buying)->placeholder('Buying')->class('form-control form-control-sm comma-separated')->id('validationCustom01') }}
</div>


 <div class="col-md-6">
  <label class="form-label" for="code">Selling</label>
  {{ html()->text('selling')->value($currencyrate->selling)->placeholder('Selling')->class('form-control form-control-sm comma-separated') }}
</div>

 
  <div class="d-grid gap-2">
       <button class="btn btn-primary" type="submit">Submit</button>
     </div>
 
{{ html()->form()->close() }}

     
        
        </div>
      </div>

      @endsection

   
<script src="{{ asset('assets/js/cleave.js') }}"></script>
<script src="{{ asset('assets/js/flatpickr.js') }}"></script>
<script src="{{ asset('vendors/prism/prism.js') }}"></script>
<script src="{{ asset('assets/js/theme.js') }}"></script>
<script>
main.init();
</script>
