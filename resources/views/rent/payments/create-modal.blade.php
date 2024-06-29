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
          <h4 class="" id="staticBackdropLabel">Add a Payment</h4>

        </div>
<div class="p-3">

<span id="payerror" style=""></span>

 {{ html()->form('POST')->route('rent.payments.store')->class('row g-3 needs-validation nobottompadding')->id('modal-form-submit')->novalidate()->open() }}


 {{ html()->hidden('property_id')->value($payment->propertyid)->placeholder('')->class('form-control form-control-sm') }}

 {{ html()->hidden('')->value($payment->from_date)->placeholder('')->class('form-control form-control-sm')->id('currentdate') }}


 {{ html()->hidden('document_type_id')->value($payment->document_type_id->id)->placeholder('')->class('form-control form-control-sm') }}


 <div class="col-md-6">
  <label class="form-label asterik" for="code">Date</label>
  {{ html()->text('date')->placeholder('Date Money received')->value($payment->from_date)->class('form-control form-control-sm datetimepicker fromdate')->required()->value('')->id('datepicker') }}
</div>


<div class="col-md-6">
  <label class="form-label asterik" for="code">Tenant/ Unit</label>
  {{ html()->select('tenant_unit_id')->options($tenantunits->pluck('full_name','id'))->value($payment->tenant_unit_id)->required()->autofocus()->id('tenant_unit_id')->class('form-select form-select-sm js-choice')->placeholder('Select an option') }}
</div>


  <div class="col-md-12">
    <label class="form-label asterik" for="code">Period</label>

    <select name="payment_schedule_id[]" class="form-select js-choice choices" required id="schedule_id" multiple="multiple" size="1" data-trigger data-options='{"removeItemButton":true,"placeholder":true}'>
      <option value="">Select a schedule ...</option>
    </select>

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
  <script src="{{ asset('vendors/choices/choices.min.js')}}"></script>
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

 var example = new Choices('.choices', {
          allowHTML: false,
          placeholder: true,
          removeItemButton:true,
          shouldSort: false,
        });

        $('#tenant_unit_id').on('change', function () {
          var tenantunit_id = $(this).val();
       var url = "{{ route('rent.gettenantunitschedules',0) }}";
       var urlstriped = url.replace(/.$/,tenantunit_id);
       example.clearStore();
          example.setChoices(function() {
          return fetch(urlstriped,
          )
            .then(function(response) {
              return response.json();
            })
            .then(function(data) {

              return data.releases.map(function(release) {
                return { value: release.id, label: release.fromdate +' - '+ release.todate +' - '+ release.balance};
              });
            });
        });
        });





 var curdate =   $('#currentdate').val();
 $('.fromdate').val(curdate);


$('[data-toggle="select2"]').select2({
        dropdownParent: $('#myModal')
    })


$('#schedule_id').on('change', function () {

var ids = $('#schedule_id').val();
var t_unit_id = $('#tenant_unit_id').val();

$.ajax({
type:'get',
url:'{{ route('rent.computedueamount') }}',
data:{'ids':ids,'t_unit_id':t_unit_id},
success:function(data){
$('.unit_amount_value').attr("value", data.amount);
$('.paid_amount_value').attr("value", data.amountfull);
},
error:function(){
}
});

});

$("#schedule_id").on("select2:select", function (evt) {
  var element = evt.params.data.element;
  var $element = $(element);

  $element.detach();
  $(this).append($element);
  $(this).trigger("change");
});




$('#periodid').on('change', function () {
var period_id = $(this).val();
var from_date = $('.fromdateid').val();
var specific_days = $('#specificDays').val();

$.ajax({
type:'get',
url:'{{ route('rent.computetodate') }}',
data:{'period':period_id,'from_date':from_date,'specific_days':specific_days},
success:function(data){

$('.todate').attr("value", data);

},
error:function(){
}

});

});



$("#specificDays").keyup(function(){
var period_id = $('#periodid').val();
var from_date = $('.fromdateid').val();
var specific_days = $('#specificDays').val();

$.ajax({
type:'get',
url:'{{ route('rent.computetodate') }}',
data:{'period':period_id,'from_date':from_date,'specific_days':specific_days},
success:function(data){

$('.todate').attr("value", data);

},
error:function(){
}

});

});


$(".paidamount").keyup(function(){

  var dueamount = $('.unit_amount_value').val().replace(/[^0-9\.]/g, '');
  var paidamount = $('.paidamount').val().replace(/[^0-9\.]/g, '');

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
