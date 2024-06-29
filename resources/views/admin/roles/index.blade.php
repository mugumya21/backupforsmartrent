@extends('layouts.app')

@section('title', 'Roles')


@section('head-css')
<link href="{{ asset('assets/DataTables/datatables.min.css')}}" rel="stylesheet">
 

@section('content')


<div class="card mb-3">
  <div class="card-header bg-light">
    <div class="row flex-between-end">
      <div class="col-auto align-self-center">
        <h5 class="mb-0" data-anchor="data-anchor">Roles<a class="anchorjs-link " aria-label="Anchor" data-anchorjs-icon="#" href="#example" style="padding-left: 0.375em;"></a></h5>
      </div>
      <div class="col-auto ms-auto">
        <div class="nav nav-pills nav-pills-falcon flex-grow-1" role="tablist">
          <a href="{{route('admin.roles.create')}}" data-ajax="true" class="btn btn-sm active" aria-selected="true"><i class="fas fa-plus"></i> Create New</a>
         
        </div>
      </div>
    </div>
    
  </div>
  <div class="card-body text-justify">
  
      <div id="roles-loader"></div>
   

  </div>
  
</div>


@endsection


@section('include-js')

<script src="{{ asset('assets/js/main.js') }}"></script>
<script src="{{ asset('assets/js/jquery-3.7.1.js') }}"></script>
<script src="{{ asset('assets/DataTables/datatables.min.js')}}"></script>

<script>
main.init();
main.initAjax();

let url = "{{route('admin.roles.index')}}";
main.loadRemote(url, '#roles-loader')



</script>

@endsection
