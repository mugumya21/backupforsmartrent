<div class="row">
    <div class="col-md-4">
    <label class="form-label asterik" for="first_name">Company_name</label>
    {{ html()->text('company_name')->autofocus()->required()->placeholder('Company Name')->class('form-control form-control-sm')->id('validationCustom01') }}
</div>

<div class="col-md-4">
    <label class="form-label asterik" for="telephone">Telephone</label>
    {{ html()->text('telephone')->required()->placeholder('Telephone')->class('form-control form-control-sm') }}
</div>

<div class="col-md-4">
    <label class="form-label" for="code">Designation</label>
    {{ html()->select('designation_id')->options($roles->pluck('description','id'))->placeholder('Select an Option')->class('form-control form-select-sm js-choice') }}
</div>

<div class="col-md-4">
    <label class="form-label asterik" for="personal_email">Email</label>
    {{ html()->text('email')->placeholder('Email')->required()->class('form-control form-control-sm') }}
</div>

<div class="col-md-4">
    <label class="form-label" for="tin_number">Tin Number</label>
    {{ html()->text('tin')->placeholder('TIN Number')->class('form-control form-control-sm') }}
</div>

<div class="col-md-4">
    <label class="form-label asterik" for="code">Nation</label>
    {{ html()->select('nation_id')->options($nations->pluck('name','id'))->value($client->nation_id)->required()->placeholder('Select an Option')->class('form-select form-select-sm js-choice') }}

</div>


<div class="col-md-4">
    <label class="form-label" for="permanent_address"> Address</label>
    {{ html()->text('address')->placeholder('Address')->class('form-control form-control-sm') }}
</div>

<div class="col-md-12">
    <label class="form-label" for="description">Other Information</label>
    {{ html()->textarea('description')->placeholder('Other Information')->rows('5')->class('form-control form-control-sm') }}
</div>

<div class="col-12" style="margin-top:10px">
    <button class="btn btn-primary" type="submit">Submit</button>
  </div>

</div>

<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="{{ asset('assets/js/flatpickr.js') }}"></script>
<script src="{{ asset('vendors/prism/prism.js') }}"></script>
<script src="{{ asset('assets/js/theme.js') }}"></script>

<script>
main.init();
</script>
