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
          <h4 class="" id="staticBackdropLabel">Add a Tenant Unit</h4>

</div>
<div class="p-3" style="margin-top:10px">

@if( $tenantUnit->id > 0 )
  {{ html()->form('PUT')->route('rent.tenantUnits.update',$tenantUnit)->class('row g-3 needs-validation')->novalidate()->open() }}

 @else
 {{ html()->form('POST')->route('rent.tenantUnits.store')->class('row g-3 needs-validation nobottompadding')->id('modal-form-submit')->novalidate()->open() }}
 @endif

 {{ html()->hidden('property_id')->value($tenantUnit->propertyid)->placeholder('')->class('form-control form-control-sm') }}

<div class="col-md-6">
  <label class="form-label asterik" for="code">Tenant</label>
  {{ html()->select('tenant_id')->options($clients->pluck('full_name','id'))->required()->autofocus()->placeholder('Select an Option')->class('form-select form-select-sm js-choice') }}
</div>

<div class="col-md-6">
  <label class="form-label asterik" for="code">Unit Name/ Number</label>
  {{ html()->select('unit_id')->options($units->pluck('name','id'))->value($tenantUnit->unit_id)->required()->autofocus()->placeholder('Select an Option')->class('form-select form-select-sm js-choice')->id('unitid') }}
</div>

<div class="col-md-6">
  <label class="form-label asterik" for="code">Period</label>
  {{ html()->select('schedule_id')->options($periods->pluck('name','id'))->value($tenantUnit->schedule_id)->required()->placeholder('Period')->class('form-select form-select-sm js-choice')->id('periodid') }}
</div>

<div class="col-md-6">
  <label class="form-label asterik" for="code">Duration</label>
  {{ html()->text('duration')->required()->placeholder('Duration')->required()->class('form-control form-control-sm digits')->id('specificDays')->autofocus('false') }}
</div>

<div class="col-md-6">
  <label class="form-label asterik" for="code">Start Date</label>
  {{ html()->text('from_date')->placeholder('Start Date')->value($tenantUnit->from_date)->class('form-control form-control-sm fromdateid datetimepicker')->id('datepicker') }}
</div>

<div class="col-md-6">
  <label class="form-label asterik" for="code">To Date</label>
  {{ html()->text('to_date')->required()->value($tenantUnit->to)->placeholder('End Date')->class('form-control form-control-sm todate')->isReadonly('true')->id('validationCustom01') }}
</div>

   <div class="col-md-12">
    <label class="form-label asterik" for="code">Unit Amount</label>
   {{ html()->text('amount')->required()->value($tenantUnit->amount)->placeholder('Amount')->class('form-control form-control-sm amount_value comma-separated')->isReadonly('true')->id('validationCustom01') }}
 </div>

 <div class="col-md-12">
  <label class="form-label" for="code"> <b><u>Agreed Amount</u></b></label>
 </div>

<div class="col-md-6">
  <label class="form-label asterik" for="code">Currency</label>

  <select name="currency_id" class="form-select form-select-sm js-choice choices" required id="currencyid">
    <option value="">Select a currency ...</option>
  </select>

</div>

 <div class="col-md-6">
  <label class="form-label asterik" for="code">Amount</label>
  {{ html()->text('discount_amount')->required()->value($tenantUnit->discount_amount)->placeholder('Amount')->class('form-control form-control-sm comma-separated discounted_amount_value')->id('validationCustom01') }}
</div>

<div class="col-md-6">
  <label class="form-label asterik" for="code">Payment Terms</label>
  {{ html()->text('terms')->required()->value($tenantUnit->terms)->placeholder('Peyment Terms')->class('form-control form-control-sm comma-separated')->id('validationCustom01') }}
</div>

 <div class="col-md-12">
  <label class="form-label" for="code">Description</label>
   {{ html()->textarea('description')->value($tenantUnit->description)->placeholder('Description')->class('form-control form-control-sm')->rows('3') }}
 </div>

  <div class="d-grid gap-2">
       <button class="btn btn-primary" type="submit">Submit</button>
     </div>

{{ html()->form()->close() }}



        </div>
      </div>

@endsection

<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="{{ asset('assets/js/cleave.js') }}"></script>
<script src="{{ asset('assets/js/flatpickr.js') }}"></script>
<script src="{{ asset('vendors/prism/prism.js') }}"></script>
<script src="{{ asset('assets/js/theme.js') }}"></script>

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

$('#unitid').on('change', function () {
  var unit_id = $(this).val();
  if(unit_id === ''){
    $('.amount_value').attr("value", '');
  }

$.ajax({
type:'get',
url:'{{ route('rent.getunitdetails') }}',
data:{'id':unit_id},
success:function(data){

var newamount = data.amount.toLocaleString('en-US');
$('.amount_value').attr("value", newamount);
$('.discounted_amount_value').attr("value", newamount);

var curdata = data.currency.id;

var url = "{{ route('rent.getunitcurrencies',0) }}";
       var urlstriped = url.replace(/.$/,unit_id);
       example.clearStore();
          example.setChoices(function() {
          return fetch(urlstriped,
          )
            .then(function(response) {
              return response.json();
            })
            .then(function(data) {
              return data.releases.map(function(release) {
                if(curdata == release.id){
                  return { value: release.id, label: release.name,selected: true};
                } else {
                  return { value: release.id, label: release.name};
                }

              });
            });
        });

},
error:function(){
}

});



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




jQuery('.fromdateid').on('change', function() {
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


$(".digits").keypress(function (e) {
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        $("#errmsg").html("Digits Only").show().fadeOut("slow");
               return false;
    }
   });


</script>
