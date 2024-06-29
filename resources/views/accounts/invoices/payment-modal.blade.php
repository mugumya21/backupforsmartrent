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
          <h4 class="" id="staticBackdropLabel">Payout Invoice</h4>
        
        </div>
<div class="p-3" style="margin-top:10px">

  {{ html()->form('POST')->route('accounts.invoices.paymentSubmit')->class('row g-3 needs-validation')->novalidate()->open() }}

  {{ html()->hidden('invoice_id')->value($invoice->id)->placeholder('')->class('form-control form-control-sm') }}
  
  {{ html()->hidden('is_invoiced')->value(1)->class('') }}
  
  {{ html()->hidden('property_id')->value($invoice->property_id)->placeholder('')->class('form-control form-control-sm') }}

  {{ html()->hidden('')->value($payment->date)->placeholder('')->class('form-control form-control-sm')->id('currentdate') }}

  {{ html()->hidden('unit_id')->value($invoice->unit_id)->placeholder('')->class('form-control form-control-sm') }}

  {{ html()->hidden('tenant_unit_id')->value($invoice->tenant_unit_id)->placeholder('')->class('form-control form-control-sm') }}


  <div class="col-md-6">
    <label class="form-label asterik" for="code">Date</label>
    {{ html()->text('date')->placeholder('Date Money received')->value($payment->date)->class('form-control form-control-sm datetimepicker fromdate')->required()->value('')->id('datepicker') }}
  </div>

  <div class="col-md-6">
    <label class="form-label asterik" for="code">Invoice Number</label>
    {{ html()->text('')->placeholder('Date Money received')->value($invoice->number)->class('form-control form-control-sm')->required()->isReadonly() }}
  </div>


  <div class="col-md-6">
    <label class="form-label asterik" for="code">Tenant/ Unit</label>
    {{ html()->text('')->placeholder('Tenant/Unit')->value($invoice->full_name)->class('form-control form-control-sm')->required()->isReadonly() }}
  </div>

  <div class="col-md-12">
    <label class="form-label asterik" for="code">Period</label>
<div class="customperiodscontainer">
    @foreach($invoice->items as $item)

    <div class="customperiods">{{$item->schedule->shortFromDate()}} - {{$item->schedule->shortToDate()}} - {{$item->schedule->balanceDisp()}} 
    </div>

    @endforeach
</div>
  </div>

<div class="col-md-12">
  <label class="form-label asterik" for="code">Amount Due</label>
    {{ html()->text('')->value($invoice->balanceDisp())->required()->placeholder('Amount Due')->class('form-control form-control-sm unit_amount_value comma-separated')->isReadonly('true')->id('validationCustom01') }}
</div>


<div class="col-md-6">
  <label class="form-label asterik" for="code">Paid Amount</label>
  {{ html()->text('paid_amount')->required()->placeholder('Paid Amount')->class('form-control form-control-sm paidamount paid_amount_value comma-separated')->id('validationCustom01') }}
</div>


<div class="col-md-6">
  <label class="form-label asterik" for="code">Balance</label>
  {{ html()->text('amount_due')->placeholder('Balance')->class('form-control form-control-sm balance_amount_value comma-separated')->value($invoice->balanceDisp())->isReadonly()->id('balanceValue') }}
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
  {{ html()->textarea('description')->placeholder('Enter your comment')->rows('5')->class('form-control form-control-sm') }}
</div>
 
<div class="d-grid gap-2">
    <button class="btn btn-success" type="submit">Payout</button>
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

function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

var curdate =   $('#currentdate').val();
 $('.fromdate').val(curdate);

 $(document).ready(function () {
  var amount = $('.unit_amount_value').val();
  $('.paid_amount_value').val(amount);




$(".paid_amount_value").on('input', function() {

  var paidamntval = $(this).val();
  var paidamntvalstripped = paidamntval.replace(/,/g, "");

  var amntval =  $('.unit_amount_value').val();
  var amntvalstripped = amntval.replace(/,/g, "");

  var balance = (parseFloat(amntvalstripped) - parseFloat(paidamntvalstripped));
  $('#balanceValue').val(numberWithCommas(balance));

});




});


</script>
