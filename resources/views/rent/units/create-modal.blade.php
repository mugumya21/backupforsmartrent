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
          <h4 class="" id="staticBackdropLabel">Add a Unit</h4>
        
        </div>
<div class="p-3" style="margin-top:10px">
     
@if( $unit->id > 0 )
  {{ html()->form('PUT')->route('rent.units.update',$unit)->class('row g-3 needs-validation')->novalidate()->open() }}
 
 @else
 {{ html()->form('POST')->route('rent.units.store')->class('row g-3 needs-validation')->id('modal-form-submit')->novalidate()->open() }}
 @endif


 {{ html()->hidden('property_id')->value($unit->propertyid)->placeholder('Unit Number')->class('form-control form-control-sm') }}
 
             

  <div class="col-md-6">
    <label class="form-label asterik" for="code">Unit Type</label>
    {{ html()->select('unit_type')->options($unitTypes->pluck('name','id'))->value($unit->unit_type)->required()->placeholder('Select an Option')->class('form-select form-select-sm js-choice') }}
</div>

<div class="col-md-6">
  <label class="form-label asterik" for="code">Floor</label>
  {{ html()->select('floor_id')->options($floors->pluck('name','id'))->value($unit->floor_id)->required()->placeholder('Select an Option')->class('form-select form-select-sm js-choice') }}
</div>

<div class="col-md-6">
  <label class="form-label asterik" for="code">Unit Name/ Number</label>
  {{ html()->text('name')->autofocus()->required()->value($unit->name)->placeholder('Unit Name/ Number')->class('form-control form-control-sm')->id('validationCustom01') }}
</div>



 <div class="col-md-6">
  <label class="form-label" for="code">Square Meters</label>
  {{ html()->text('square_meters')->value($unit->square_meters)->placeholder('Square Meters')->class('form-control form-control-sm comma-separated') }}
</div>

<div class="col-md-12">
<label class="form-label asterik" for="code">Period</label>
  {{ html()->select('schedule_id')->options($periods->pluck('name','id'))->value($unit->schedule_id)->required()->placeholder('Select an Option')->class('form-select form-select-sm js-choice') }}
</div>


<div class="col-md-6">
    <label class="form-label asterik" for="code">Currency</label>
    {{ html()->select('currency_id')->options($currencies->pluck('name','id'))->value($unit->currency_id)->required()->placeholder('Select an Option')->class('form-select form-select-sm js-choice') }}
</div>
  
<div class="col-md-6">
  <label class="form-label asterik" for="code">Amount</label>
  {{ html()->text('amount')->value($unit->amount)->placeholder('Amount')->class('form-control form-control-sm comma-separated') }}
</div>
 
 <div class="col-md-12">
  <label class="form-label" for="code">Description</label>
   {{ html()->textarea('description')->value($unit->description)->placeholder('Description')->class('form-control form-control-sm')->rows('3') }}
 </div>
 
  <div class="d-grid gap-2">
       <button class="btn btn-primary" type="submit">Submit</button>
     </div>
 
{{ html()->form()->close() }}

     
        
        </div>
      </div>

@endsection

<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="{{ asset('assets/js/cleave.js') }}"></script>
<script src="{{ asset('assets/js/theme.js') }}"></script>

<script>
main.init();
</script>
