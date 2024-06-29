@extends('layouts.app')

@section('title', 'Units')

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
                      <h5 class="mb-0" data-anchor="data-anchor" id="example">Unit<a class="anchorjs-link " aria-label="Anchor" data-anchorjs-icon="#" href="#example" style="padding-left: 0.375em;"></a></h5>
                    </div>
                    <div class="col-auto ms-auto">
                      <div class="nav nav-pills nav-pills-falcon flex-grow-1" role="tablist">
                        @if(Auth::user()->hasAnyDirectPermission(['edit_units']))
                        <a  href="{{route('rent.units.edit',$unit)}}" data-ajax="true" class="btn btn-sm active" type="button"  ><i class="fas fa-edit"></i> Edit</a>    
                        @endif           
                      </div>
                    </div>
                  </div>
                  
                </div>
                <div class="card-body text-justify">
                
                  <div class="col-6">
                
                  
               
                    <div class="row">
                      <div class="col-4 col-sm-6">
                        <p class="fw-semi-bold mb-1 text-end">unit:</p>
                      </div>
                      <div class="col">{{$unit->name}}</div>
                    </div>

                    
                    <div class="row">
                      <div class="col-4 col-sm-6">
                        <p class="fw-semi-bold mb-1 text-end">Floors:</p>
                      </div>
                      <div class="col">{{$unit->floor->name}}</div>
                    </div>

                    <div class="row">
                      <div class="col-4 col-sm-6">
                        <p class="fw-semi-bold mb-1 text-end">Type:</p>
                      </div>
                      <div class="col">{{$unit->unitType->name}}</div>
                    </div>



                    <div class="row">
                      <div class="col-4 col-sm-6">
                        <p class="fw-semi-bold mb-1 text-end">Square Meters:</p>
                      </div>
                      <div class="col">{{$unit->square_meters}}</div>
                    </div>

                   
                  <div class="row">
                    <div class="col-4 col-sm-6">
                      <p class="fw-semi-bold mb-1 text-end">Period: </p>
                    </div>
                    <div class="col">   {{$unit->period->name}}</div>
                  </div>


                  <div class="row">
                    <div class="col-4 col-sm-6">
                      <p class="fw-semi-bold mb-1 text-end">Amount: </p>
                    </div>
                    <div class="col">  <span class="curr">{{ $unit->currency->code }}</span> {{$unit->amountDisp()}}</div>
                  </div>


                  <div class="row">
                    <div class="col-4 col-sm-6">
                      <p class="fw-semi-bold mb-1 text-end">Availability: </p>
                    </div>
                    <div class="col"> {!! $unit->availabilityDisp() !!}</div>
                  </div>



                  </div>

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

