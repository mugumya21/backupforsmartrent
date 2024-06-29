@extends('layouts.app')

@section('title', 'Users')

@section('head-css')
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendors/prism/prism-okaidia.css') }}" rel="stylesheet">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet">

@endsection

@section('content')


<div class="card mb-3">
  <div class="card-header bg-light">
    <div class="row flex-between-end">
      <div class="col-auto align-self-center">
        <h5 class="mb-0" data-anchor="data-anchor" id="example">Create new User<a class="anchorjs-link " aria-label="Anchor" data-anchorjs-icon="#" href="#example" style="padding-left: 0.375em;"></a></h5>
      </div>
      <div class="col-auto ms-auto">
        <div class="nav nav-pills nav-pills-falcon flex-grow-1" role="tablist">
          <a href="{{route('admin.users.index')}}" class="btn btn-sm active" aria-selected="true">View Users</a>
         
        </div>
      </div>
    </div>
    
  </div>
  <div class="card-body text-justify">
  
    @include('admin.users.form')       

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
  </script>


@endsection