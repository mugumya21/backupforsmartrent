@extends('layouts.app')

@section('title', 'Client')

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
        <h5 class="mb-0" data-anchor="data-anchor" id="example">Create new Client<a class="anchorjs-link " aria-label="Anchor" data-anchorjs-icon="#" href="#example" style="padding-left: 0.375em;"></a></h5>
      </div>
      <div class="col-auto ms-auto">
        <div class="nav nav-pills nav-pills-falcon flex-grow-1" role="tablist">
          <a href="{{route('crm.clients.index')}}" class="btn btn-sm active" aria-selected="true">View Clients</a>
        </div>
      </div>
    </div>
    
  </div>
  <div class="card-body text-justify">
  
    @include('crm.clients.form')          

  </div>
  
</div>

 
@endsection

@section('include-js')

<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="{{ asset('assets/js/flatpickr.js') }}"></script>
<script src="{{ asset('vendors/prism/prism.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>
<script src="{{ asset('assets/js/jquery-3.7.1.js') }}"></script>

<script>

$('.client_type_id').on('change', function () {
    
            var clientype = $("#client_type_id").val();

            if (clientype == 'IND') {

                let individualclient = "{{ route('crm.clients.create', ['source' => 'IND']) }}";
                main.loadRemote(individualclient, '#clientformloader');

            } else {

                let companyclient = "{{ route('crm.clients.create', ['source' => 'COM']) }}";
                main.loadRemote(companyclient, '#clientformloader');

            }

        });

        main.init();
  
      </script>




@endsection

