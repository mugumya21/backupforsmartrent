@extends('layouts.modal-app')
@section('size')
{{-- modal-lg mt-6 --}}
@endsection

<link href="{{ asset('assets/css/select2.min.css')}}" rel="stylesheet">
@include('shared.overide-select2-multiple')
<style>
  .choices {
    position: relative;
    margin-bottom: 0px;
    font-size: 16px;
}
</style>

@section('modal-content')

 <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">

                          <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

<div class="modal-body p-0">
        <div class="bg-light rounded-top-lg py-2 ps-3 pe-6">
          <h4 class="" id="staticBackdropLabel">Add a Payment</h4>
        </div>
<div class="p-3" style="margin-top: 10px;">

<span id="payerror" style=""></span>

 {{ html()->form('POST')->route('rent.payments.store')->class('row g-3 needs-validation nobottompadding')->id('modal-form-submit')->novalidate()->open() }}


 {{ html()->hidden('')->value($payment->from_date)->placeholder('')->class('form-control form-control-sm')->id('currentdate') }}

 {{ html()->hidden('document_type_id')->value($payment->document_type_id->id)->placeholder('')->class('form-control form-control-sm') }}


 <div class="col-md-6">
  <label class="form-label asterik" for="code">Date</label>
  {{ html()->text('date')->placeholder('Date Money received')->value($payment->from_date)->class('form-control form-control-sm datetimepicker fromdate')->required()->value('')->id('datepicker') }}
</div>


<div class="col-md-6">
    <label class="form-label asterik" for="code">Invoice</label>
    {{ html()->select('invoice_id')->options($invoices->pluck('number','id'))->required()->autofocus()->id('invoiceid')->class('form-select form-select-sm js-choice')->placeholder('Select an option') }}
</div> 

<div class="col-md-6">
  <label class="form-label asterik" for="code">Tenant/ Unit</label>
  {{ html()->text('')->required()->placeholder('Tenant Unit')->class('form-control form-control-sm')->isReadonly('true')->id('tenantunitid') }}

  {{ html()->hidden('tenant_unit_id')->required()->placeholder('')->class('form-control form-control-sm')->isReadonly('true')->id('tenantunitidval') }}

</div> 

<div class="col-md-6">
  <label class="form-label asterik" for="code">Property</label>
  {{ html()->text('')->required()->placeholder('Property')->class('form-control form-control-sm')->isReadonly('true')->id('propertyid') }}

  {{ html()->hidden('property_id')->required()->placeholder('')->class('form-control form-control-sm')->isReadonly('true')->id('propertyidval') }}
</div> 

  <div class="col-md-12">
    <label class="form-label asterik" for="code">Periods</label>
    <span id="periodsloader"></span>
  </div>

  <div class="col-md-12">
  <label class="form-label asterik" for="code">Amount Due</label>
    {{ html()->text('amount_due')->required()->placeholder('Amount Due')->class('form-control form-control-sm unit_amount_value comma-separated')->isReadonly('true')->id('validationCustom01') }}
  </div>

  <div class="col-md-6">
    <label class="form-label asterik" for="code">Paid Amount</label>
    {{ html()->text('paid')->required()->placeholder('Paid Amount')->class('form-control form-control-sm paidamount paid_amount_value comma-separated')->id('validationCustom01') }}
  </div>


  <div class="col-md-6">
    <label class="form-label asterik" for="code">Balance</label>
    {{ html()->text('balance')->required()->placeholder('Balance')->class('form-control form-control-sm paidamount balanceValue comma-separated')->id('validationCustom01') }}
  </div>

  <div class="col-md-6">
    <label class="form-label asterik" for="code">Payment Mode</label>
    {{ html()->select('payment_mode_id')->options($paymentmodes->pluck('name','id'))->value($payment->payment_mode_id)->required()->placeholder('Select an Option')->class('form-select form-select-sm js-choice')->id('currencyid') }}
  </div>


  <div class="col-md-6">
    <label class="form-label asterik" for="code">Credited Account</label>
    {{ html()->select('account_id')->options($accounts->pluck('name','id'))->value($payment->account_id)->required()->placeholder('')->class('form-select form-select-sm js-choice')->id('currencyid') }}
  </div>

  <div class="col-md-12">
    <label class="form-label" for="code">Description</label>
     {{ html()->textarea('description')->placeholder('Description')->class('form-control form-control-sm')->rows('3') }}
   </div>
   
 
  <div class="d-grid gap-2">
       <button class="btn btn-primary" id="submitbtn" type="submit">Submit</button>
  </div>
 
{{ html()->form()->close() }}

     
        
        </div>
      </div>

      @endsection

      
<script src="{{ asset('assets/js/flatpickr.js') }}"></script>
<script src="{{ asset('vendors/prism/prism.js') }}"></script>
<script src="{{ asset('assets/js/theme.js') }}"></script>
  <script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<link href="{{ asset('assets/css/select2.min.css')}}" rel="stylesheet">
<script src="{{ asset('assets/js/cleave.js') }}"></script>
<script src="{{ asset('assets/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/form-advanced.init.js') }}"></script>



<script>
 main.init();

 $(".datetimepicker").flatpickr({ 
   dateFormat: "d/m/Y",
   allowInput: true,
   altInput: true, 
   altFormat: "d/m/Y",
});

function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

$('#invoiceid').on('change', function () {
  var invoice_id = $(this).val();
if(invoice_id == '') {
alert('Please select an invoice');
} else {
    
var invoice_id = $(this).val();
var geturl = "{{ route('accounts.payments.getitems',0) }}";
var urlstriped = geturl.replace(/.$/,invoice_id);
main.loadRemote(urlstriped, '#periodsloader');


$.ajax({
type:'get',
url:"{{ route('accounts.invoices.getdetails') }}",
data:{'id':invoice_id},
success:function(data){

$('#propertyidval').val(data.property.id);  
$('#propertyid').val(data.property.name);  
$('#tenantunitidval').val(data.tenantunit.id); 
$('#tenantunitid').val(data.unit.name); 
$('.unit_amount_value').val(data.amountdue); 
$('.balanceValue').val(data.amountdue); 

},
error:function(){
}
});


}

});


 var curdate =   $('#currentdate').val();
 $('.fromdate').val(curdate);

 
$('[data-toggle="select2"]').select2({
        dropdownParent: $('#myModal')
    })


$(".paid_amount_value").on('input', function() {

var paidamntval = $(this).val();
var paidamntvalstripped = paidamntval.replace(/,/g, "");

var amntval =  $('.unit_amount_value').val();
var amntvalstripped = amntval.replace(/,/g, "");

var balance = (parseFloat(amntvalstripped) - parseFloat(paidamntvalstripped));
$('.balanceValue').val(numberWithCommas(balance));

});


$(".paid_amount_value").keyup(function(){
  
  var dueamount = $('.unit_amount_value').val().replace(/[^0-9\.]/g, '');
  var paidamount = $('.paid_amount_value').val().replace(/[^0-9\.]/g, '');

if(parseFloat(paidamount) > parseFloat(dueamount)){
  
  $("#modal-form-submit").on("submit", function (e) {
            e.preventDefault();
        });

$('#submitbtn').prop('disabled', true);
$("#payerror").html('<div style="padding: 2px;" class="alert alert-danger border-2 d-flex align-items-center" role="alert"><p class="mb-0 flex-1"><b>Ooops!</b>, the payment is more than the amount due, please add a schedule</p><button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button></div>').show().delay(9000).fadeOut("slow");

} else {
  $('#submitbtn').prop('disabled', false);
}

});



</script>
