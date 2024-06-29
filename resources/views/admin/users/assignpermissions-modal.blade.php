@extends('layouts.app')

@section('title', 'Users')

@section('head-css')
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendors/prism/prism-okaidia.css') }}" rel="stylesheet">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/select2.min.css')}}" rel="stylesheet">
@include('shared.overide-select2-multiple')

@endsection

@section('content')


<div class="card mb-3 row col-md-6">
  <div class="card-header bg-light">
    <div class="row flex-between-end">
      <div class="col-auto align-self-center">
        <h5 class="mb-0" data-anchor="data-anchor" id="example">Assign User Permissions<a class="anchorjs-link " aria-label="Anchor" data-anchorjs-icon="#" href="#example" style="padding-left: 0.375em;"></a></h5>
      </div>

    </div>
    
  </div>
  <div class="card-body text-justify">
  
    {{ html()->form('POST')->route('admin.user.assignpermissionSubmit')->class('row g-3 needs-validation')->id('modal-form-submit')->novalidate()->open() }}

    {{ html()->hidden('id')->value($user->id)->required()->class('form-control form-control-sm') }}

 
    <div class="col-md-12">
      <label class="form-label asterik" for="code">Permissions</label>
      {{ html()->select('permissions_ids[]')->options($permissions->pluck('name','id'))->value($currentpermissions->pluck('id'))->required()->multiple('multiple')->class('form-select form-select-sm js-choice') }}
    </div>


    <div class="col-12">
      <button class="btn btn-primary" type="submit">Submit</button>
    </div>
   
  {{ html()->form()->close() }}
  
            

  </div>
  
</div>



@endsection




@section('include-js')
<script src="{{ asset('assets/js/main.js') }}"></script>
<script src="{{ asset('assets/js/jquery-3.7.1.js') }}"></script>


<script src="{{ asset('assets/js/flatpickr.js') }}"></script>
<script src="{{ asset('vendors/prism/prism.js') }}"></script>

<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
      
<script src="{{ asset('assets/js/cleave.js') }}"></script>


<script>
 $(".datetimepicker").flatpickr({ 
   dateFormat: "d/m/Y",
   allowInput: true,
   altInput: true, 
   altFormat: "d/m/Y",
});

new Choices('.js-choice', {
          allowHTML: false,
          placeholder: true,
          removeItemButton:true,
          shouldSort: false,
        });
        
  </script>


@endsection