@extends('layouts.app')

@section('title', 'Properties')

@section('head-css')
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendors/prism/prism-okaidia.css') }}" rel="stylesheet">

<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet">
@include('shared.overide-select2-multiple')

@endsection

@section('content')

<div class="card mb-3">
  <div class="card-header bg-light">
    <div class="row flex-between-end">
      <div class="col-auto align-self-center">
        <h5 class="mb-0" data-anchor="data-anchor" id="example">Edit Invoice<a class="anchorjs-link " aria-label="Anchor" data-anchorjs-icon="#" href="#example" style="padding-left: 0.375em;"></a></h5>
      </div>
      <div class="col-auto ms-auto">
        <div class="nav nav-pills nav-pills-falcon flex-grow-1" role="tablist">
          <a href="{{route('accounts.invoices.index')}}" class="btn btn-sm active" aria-selected="true">View Invoices</a>
        </div>
      </div>
    </div>
    
  </div>
  <div class="card-body text-justify">
  
      @include('accounts.invoices.edit-form')            

  </div>
  
</div>



@endsection




@section('include-js')


<script src="{{ asset('assets/js/flatpickr.js') }}"></script>
<script src="{{ asset('vendors/prism/prism.js') }}"></script>
<script src="{{ asset('assets/js/theme.js') }}"></script>
  <script src="{{ asset('vendors/choices/choices.min.js')}}"></script>
<link href="{{ asset('assets/css/select2.min.css')}}" rel="stylesheet">
<script src="../../../vendors/tinymce/tinymce.min.js"></script>
<script src="{{ asset('assets/js/cleave.js') }}"></script>

<script src="{{ asset('assets/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/form-advanced.init.js') }}"></script>

<script src="{{ asset('assets/js/main.js') }}"></script>

<script>
main.init();

$(document).ready(function() {
$(".datetimepicker").flatpickr({ 
   dateFormat: "d/m/Y",
   allowInput: true,
   altInput: true, 
   altFormat: "d/m/Y",
});

});

$(document).ready(function() {
  var invoiceid = '{{$invoice->id}}';
  var invurl = "{{ route('accounts.loadinvoiceitemesOnEdit',0) }}";
  var invurlstriped = invurl.replace(/.$/,invoiceid);
  main.loadRemote(invurlstriped, '#itemsloader');

});


tinymce.init({
  selector: 'textarea',
  toolbar: [
    'bold italic',
  ],
  branding: false,
  menubar : false,
  placeholder: 'Type here...'
});

var example = new Choices('.choices', {
          allowHTML: false,
          placeholder: true,
          removeItemButton:true,
          shouldSort: false,
        });



$('#propertyid').on('change', function () {

var id = $(this).val();

var url = "{{ route('rent.getpropertydetails',0) }}";
       var urlstriped = url.replace(/.$/,id);
       example.clearStore();
          example.setChoices(function() {
          return fetch(urlstriped,
          )
            .then(function(response) {
              return response.json();
            })
            .then(function(data) {
           
              return data.releases.map(function(release) {
                return { value: release.id, label: release.name};
              });
            });
        });

});


$('#units').on('change', function () {
  var unitid = $(this).val();
  var uniturl = "{{ route('accounts.loadinvoiceitemes',0) }}";
  var uniturlstriped = uniturl.replace(/.$/,unitid);
  main.loadRemote(uniturlstriped, '#itemsloader');


  $.ajax({
  type:'get',
  url:'{{ route('rent.getunitdetails') }}',
  data:{'id':unitid},
  success:function(data){
  $('#client').val(data.clientname);
  $('#client_id').val(data.client.id);
  
  tinymce.get('address_id').setContent(data.address);
$('#tenantunit').val(data.tenantunit.id);
  },
  error:function(){
  }
  });

});

$('#invoice_type_id').on('change', function () {
  var invtype = $('#invoice_type_id').text(); 
  $('#invoicetype').text(invtype);
});
  
</script>

      
<script src="{{ asset('assets/js/flatpickr.js') }}"></script>
<script src="{{ asset('vendors/prism/prism.js') }}"></script>


@endsection

