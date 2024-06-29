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
          <h4 class="mb-1" id="staticBackdropLabel">Add a floor</h4>
        
        </div>
<div class="p-3">
     
@if( $floor->id > 0 )
  {{ html()->form('PUT')->route('rent.floors.update',$floor)->class('row g-3 needs-validation')->novalidate()->open() }}
 
 @else
 {{ html()->form('POST')->route('rent.floors.store')->class('row g-3 needs-validation')->id('modal-form-submit')->novalidate()->open() }}
 @endif


 {{ html()->hidden('property_id')->value($floor->propertyid)->placeholder('floor Number')->class('form-control form-control-sm') }}
 

 
   <div class="col-md-12">
    <label class="form-label asterik" for="code">Floor Name</label>
   {{ html()->text('name')->autofocus()->required()->value($floor->name)->placeholder('')->class('form-control form-control-sm')->id('validationCustom01') }}
 
</div>

 
 <div class="col-md-12">
  <label class="form-label" for="code">Description</label>
   {{ html()->textarea('description')->value($floor->description)->placeholder('')->class('form-control form-control-sm')->rows('3') }}
 </div>
 
  <div class="d-grid gap-2">
       <button class="btn btn-primary" type="submit">Submit</button>
     </div>
 
{{ html()->form()->close() }}

     
        
        </div>
      </div>

      @endsection

<script src="{{ asset('assets/js/theme.js') }}"></script>

<script>
main.init();
</script>
