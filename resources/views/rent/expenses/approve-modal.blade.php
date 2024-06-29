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
          <h4 class="" id="staticBackdropLabel">Approve Expense</h4>
        
        </div>
<div class="p-3" style="margin-top:10px">
     

  {{ html()->form('PUT')->route('rent.expense.approveSubmit',$expense)->class('row g-3 needs-validation')->novalidate()->open() }}


 <div class="col-md-12">
  <label class="form-label" for="code">Comment</label>
  {{ html()->textarea('comment')->placeholder('Enter your comment')->rows('5')->class('form-control form-control-sm') }}
</div>

 
<div class="d-grid gap-2">
    <button class="btn btn-success" type="submit">Approve</button>
  </div>
 
{{ html()->form()->close() }}

     
        
        </div>
      </div>

      @endsection

<script src="{{ asset('vendors/prism/prism.js') }}"></script>
<script src="{{ asset('assets/js/theme.js') }}"></script>
<script>
main.init();
</script>
