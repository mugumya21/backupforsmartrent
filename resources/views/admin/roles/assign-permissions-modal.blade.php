@extends('layouts.modal-app')
@section('size')
{{-- modal-lg mt-6 --}}
@endsection

<link href="{{ asset('assets/css/select2.min.css')}}" rel="stylesheet">
@include('shared.overide-select2-multiple')

@section('modal-content')

 <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">

                          <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

<div class="modal-body p-0">
        <div class="bg-light rounded-top-lg py-2 ps-3 pe-6">
          <h4 class="" id="staticBackdropLabel">Create Role</h4>
        </div>
<div class="p-3" style="margin-top:10px">
     
  {{ html()->form('POST')->route('admin.roles.assignpermissionSubmit')->class('row g-3 needs-validation')->id('modal-form-submit')->novalidate()->open() }}



    {{ html()->hidden('role_id')->placeholder('Role name')->value($role->id)->isReadonly('true')->required()->class('form-control form-control-sm') }}

  
  <div class="col-md-12">
    <label class="form-label asterik" for="code">Permissions</label>
    {{ html()->select('permission_ids[]')->options($permissions->pluck('name','id'))->value($rolepermissions->pluck('id'))->placeholder('Select an option')->required()->multiple('multiple')->class('form-select form-select-sm js-choice') }}
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
<script src="{{ asset('assets/js/flatpickr.js') }}"></script>
<script src="{{ asset('vendors/prism/prism.js') }}"></script>
<script src="{{ asset('assets/js/theme.js') }}"></script>
      
<script>
main.init();

new Choices('.js-choice', {
          allowHTML: false,
          placeholder: true,
          removeItemButton:true,
          shouldSort: false,
        });

</script>