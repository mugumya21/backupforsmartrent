

@if( $invoice->id > 0 )
 {{ html()->form('PUT')->route('accounts.invoices.update',$invoice)->class('row g-3 needs-validation')->novalidate()->open() }}

@else
{{ html()->form('POST')->route('accounts.invoices.store')->class('row g-3 needs-validation')->novalidate()->open() }}
@endif

{{ html()->hidden('tenant_unit_id')->class('form-control form-control-sm')->id('tenantunit') }}

{{ html()->hidden('')->value($invoice->date)->class('form-control form-control-sm')->id('currentdate') }}


<div class="col-md-4">
  <div class="col-md-12">
    <label class="form-label asterik" for="code">invoice Type</label>
    {{ html()->select('invoice_type_id')->options($invoicetypes->pluck('name','id'))->value($invoice->invoice_type_id)->required()->placeholder('Select an Option')->class('form-select form-select-sm js-choice')->id('invoice_type_id') }}
  </div>

  <div class="col-md-12">
    <label class="form-label asterik" for="code">Property</label>
    {{ html()->select('property_id')->options($properties->pluck('name','id'))->value($invoice->property_id)->required()->placeholder('Select an Option')->id('propertyid')->class('form-select form-select-sm js-choice') }}
  </div>

  <div class="col-md-12">
    <label class="form-label asterik" for="code">Unit</label>

    <select name="unit_id" class="form-select js-choice choices" required id="units" size="1" data-trigger data-options='{"removeItemButton":true,"placeholder":true}'>
      <option value="">Select a schedule ...</option>
    </select>
    


  </div>

  <div class="col-md-12">
    <label class="form-label asterik" for="last_name">Tenant</label>
    {{ html()->text('')->placeholder('Tenant')->class('form-control form-control-sm')->isReadOnly()->id('client') }}

    {{ html()->hidden('tenant_id')->class('form-control form-control-sm')->isReadOnly()->id('client_id') }}


    
  </div>

  <div class="col-md-12">
    <label class="form-label" for="tin_number">Address</label>
    {{ html()->textarea('address')->class('form-control form-control-sm')->id('address_id')->rows('3') }}
  </div>


</div>


<div class="col-md-4 text-center">
  <span id="invoicetype" style="font-size: 23px;font-weight: bold;text-align: center;text-transform: uppercase;"></span>
  </div>

  <div class="col-md-4">
    
    <div class="col-md-12">
      <label class="form-label asterik" for="code">Date</label>
      {{ html()->text('date')->placeholder('Date')->value($invoice->date)->class('form-control form-control-sm datetimepicker')->id('datepicker') }}
    </div>
    

    <div class="col-md-12">
      <label class="form-label asterik" for="code">Due Date</label>
      {{ html()->text('due_date')->placeholder('Due Date')->value($invoice->date)->class('form-control form-control-sm datetimepicker')->id('datepicker') }}
    </div>

    <div class="col-md-12">
      <label class="form-label asterik" for="code">Currency</label>
      {{ html()->select('currency_id')->options($currencies->pluck('name','id'))->value($invoice->currency_id)->required()->placeholder('Select an Option')->class('form-select form-select-sm js-choice')->id('currencyid') }}
    </div>

    <div class="col-md-12">
      <label class="form-label asterik" for="code">Done By</label>
      {{ html()->select('done_by')->options($employees->pluck('full_name','id'))->value($invoice->doneby)->required()->placeholder('Select an Option')->class('form-select form-select-sm js-choice')->id('currencyid') }}
    </div>
    
    <div class="col-md-12">
      <label class="form-label asterik" for="code">Supervisor</label>
      {{ html()->select('supervisor')->options($employees->pluck('full_name','id'))->value($invoice->supervisor)->required()->placeholder('Select an Option')->class('form-select form-select-sm js-choice')->id('currencyid') }}
    </div>

  </div>
  
  <div id="itemsloader" class="col-12">
  </div>


  <div class="col-md-4">
    <div class="col-md-12">
      <label class="form-label asterik" for="code">Bank</label>
      {{ html()->select('account_id')->options($accounts->pluck('name','id'))->value($invoice->bank)->required()->placeholder('Select an Option')->class('form-select form-select-sm js-choice')->id('currencyid') }}
    </div>

  </div>
  <div style="clear:both"></div>

    <div class="col-md-6">
      <label class="form-label" for="tin_number">Terms & Conditions</label>
      {{ html()->textarea('terms')->placeholder('Terms & Conditions')->value($invoice->terms)->class('form-control form-control-sm tinymce d-none')->rows('5') }}
    </div>


    <div class="col-12 actionbtn">
      <button class="btn btn-primary buttontriger" type="submit">Submit</button>
    </div>

    {{ html()->form()->close() }}


