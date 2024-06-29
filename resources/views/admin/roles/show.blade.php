@extends('layouts.app')

@section('title', 'Role')

@section('head-css')
<link href="{{ asset('assets/DataTables/datatables.min.css')}}" rel="stylesheet">
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendors/prism/prism-okaidia.css') }}" rel="stylesheet">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet">



@section('content')

          <div class="row g-0">
            <div class="col-lg-12 pe-lg-2">
              <div class="card mb-3">
                <div class="card-header bg-light">
                  <div class="row flex-between-end">
                    <div class="col-auto align-self-center">
                      <h5 class="mb-0" data-anchor="data-anchor" id="example">Role Details<a class="anchorjs-link " aria-label="Anchor" data-anchorjs-icon="#" href="#example" style="padding-left: 0.375em;"></a></h5>
                    </div>
                    <div class="col-auto ms-auto">
                      <div class="nav nav-pills nav-pills-falcon flex-grow-1" role="tablist">
                     
<a  href="{{route('admin.roles.assignpermissions',$role)}}" data-ajax="true" class="btn btn-sm active" type="button"  ><i class="fas fa-edit"></i> Assign Permissions to role</a>
                       
                      </div>
                    </div>
                  </div>
                  
                </div>
                <div class="card-body text-justify">
                
                  <div class="col-6">
                
                  
                    <div class="row">
                      <div class="col-4 col-sm-6">
                        <p class="fw-semi-bold mb-1 text-end">Role:</p>
                      </div>
                      <div class="col">{{$role->name}}</div>
                    </div>

                    
                    <div class="row">
                      <div class="col-4 col-sm-6">
                        <p class="fw-semi-bold mb-1 text-end">Number of users:</p>
                      </div>
                      <div class="col"></div>
                    </div>


                  </div>

                </div>
              </div>

              <div class="card mb-3">
                <div class="card-header bg-light">
                  <div class="row flex-between-end">
                    <div class="col-auto align-self-center">
                      <h5 class="mb-0" data-anchor="data-anchor" id="example">Users with role<a class="anchorjs-link " aria-label="Anchor" data-anchorjs-icon="#" href="#example" style="padding-left: 0.375em;"></a></h5>
                    </div>
                    <div class="col-auto ms-auto">
                      <div class="nav nav-pills nav-pills-falcon flex-grow-1" role="tablist">
                      </div>
                    </div>
                  </div>
                  
                </div>
                <div class="card-body text-justify">
                
             
                  
<table class="table table-striped table-bordered fs--1 mb-0" id="rolestbl">
  <thead class="bg-200 text-900">
    <tr>
      <th class="sort" data-sort="name">Name</th>
      <th class="sort" data-sort="name">Description</th>
      <th class="sort actionth" data-sort="name"><i class="fas fa-cogs"></i></th>
    </tr>
  </thead>
  <tbody class="list">
      @foreach ($users as $user)
    <tr>
     <td><a href="{{route('hr.employees.show', $user->employee->id)}}" style="font-weight:bold;" class="name">{{$user->employee->full_name}}</a></td>
  
    </tr>
    @endforeach
  </tbody>
</table>



                </div>
              </div>

              
                    
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
<script src="{{ asset('assets/DataTables/datatables.min.js')}}"></script>

<script type="text/javascript">
main.initAjax();
$('#rolestbl').DataTable({
   ordering: false
});
</script>

@endsection

