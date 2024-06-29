@extends('layouts.app')

@section('title', 'Update Avatar')


@section('content')



<div class="card mb-3">
            <div class="card-header">
              <div class="row flex-between-end">
                <div class="col-auto align-self-center">
                  <h5 class="mb-0" data-anchor="data-anchor">Update Employee Avatar</h5>
                 
                </div>
                <div class="col-auto ms-auto">
                  
                </div>
              </div>
            </div>
            <div class="card-body bg-light">
              <div class="tab-content">
                <div class="tab-pane preview-tab-pane active" role="tabpanel" aria-labelledby="tab-dom-f1d388f8-6223-48cd-b720-917f0290eedd" id="dom-f1d388f8-6223-48cd-b720-917f0290eedd">
                 
                    @include('hr.employees.update-avatar-form')


                </div>
              
              </div>
            </div>
          </div>
         




@endsection


@section('include-js')
<script src="{{ asset('assets/js/flatpickr.js') }}"></script>
<script src="{{ asset('vendors/prism/prism.js') }}"></script>


@endsection

