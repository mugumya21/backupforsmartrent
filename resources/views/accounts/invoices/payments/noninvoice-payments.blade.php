
<div class="row">
    
    
    <div class="col-md-6">
    <label class="form-label asterik" for="code">Property</label>
    {{ html()->select('payment_mode_id')->options($properties->pluck('name','id'))->required()->placeholder('Select an Option')->class('form-select form-select-sm js-choice')->id('propertyid') }}
  </div>
  
  
        <div class="col-md-6">
        <label class="form-label asterik" for="code">Tenant/ Unit</label>
        <select class="form-select js-choice getunitschoices">
        <option value="">Select an option</option>
        </select>
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

</div>
      
     <script src="{{ asset('assets/js/flatpickr.js') }}"></script>
     <script src="{{ asset('vendors/prism/prism.js') }}"></script>
     <script src="{{ asset('assets/js/theme.js') }}"></script>
       <script src="../../../vendors/choices/choices.min.js"></script>
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

     
$('#propertyid').on('change', function () {
    alert();
    var choices = new Choices('.getunitschoices', {
               allowHTML: false,
               placeholder: true,
               removeItemButton:true,
               shouldSort: false,
             });

            var propertyid  = $(this).val();
            alert(propertyid);
            var url = "{{ route('rent.getpropertydetails',0) }}";
            var urlstriped = url.replace(/.$/,propertyid);
            choices.clearStore();
            choices.setChoices(function() {
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

})
     
     
     </script>
     
     