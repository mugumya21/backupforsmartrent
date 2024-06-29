

{{ html()->hidden('')->value($client->dateofbirth)->placeholder('')->class('form-control form-control-sm')->id('currentdate') }}

{{ html()->hidden('client_id')->value($client->id)->placeholder('')->class('form-control form-control-sm') }}

<div class="row">
    <div class="col-md-4">
    <label class="form-label asterik" for="first_name">First name</label>
    {{ html()->text('first_name')->autofocus()->value($client->currentclientProfile()->first_name)->required()->placeholder('First name')->class('form-control form-control-sm')->id('validationCustom01') }}
  
</div>


<div class="col-md-4">
    <label class="form-label" for="middle_name">Middle Name</label>
    {{ html()->text('middle_name')->value($client->currentclientProfile()->middle_name)->placeholder('Middle Name')->class('form-control form-control-sm') }}
  
</div>

<div class="col-md-4">
    <label class="form-label asterik" for="last_name">Last Name</label>
    {{ html()->text('last_name')->value($client->currentclientProfile()->last_name)->placeholder('Last Name')->class('form-control form-control-sm') }}
   
</div>

<div class="col-md-4">
    <label class="form-label asterik" for="telephone">Telephone</label>
{{ html()->text('telephone')->value($client->currentclientProfile()->currentProfileTel())->required()->placeholder('Telephone')->class('form-control form-control-sm') }}
  
</div>

<div class="col-md-4">
    <label class="form-label asterik" for="date_of_birth">Date Of Birth</label>
    {{ html()->text('date_of_birth')->value($client->dateofbirth)->placeholder('d/m/Y')->class('form-select form-select-sm datetimepicker date')->id('datepicker') }}

   
</div>

 
<div class="col-md-4">
    <label class="form-label asterik" for="gender">Gender</label>
    {{ html()->select('gender')->options(['1'=>'Male','2'=>'Female'])->value($client->currentclientProfile()->gender)->required()->placeholder('Select an Option')->class('form-select form-select-sm js-choice') }}

</div>

<div class="col-md-4">
    <label class="form-label asterik" for="code">Nation</label>
    {{ html()->select('nation_id')->options($nations->pluck('name','id'))->value($client->nation_id)->required()->placeholder('Select an Option')->class('form-select form-select-sm js-choice') }}

</div>


<div class="col-md-4">
    <label class="form-label" for="code">Designation</label>
    {{ html()->select('designation')->options($roles->pluck('description','id'))->placeholder('Select an Option')->value($client->currentclientProfile()->designation)->class('form-control form-select-sm js-choice') }}
</div>

<div class="col-md-4">
    <label class="form-label" for="email">Email</label>
    {{ html()->email('email')->value($client->currentclientProfile()->currentProfileEmail())->required()->placeholder('Email')->class('form-control form-control-sm') }}
</div>
 

<div class="col-md-4">
    <label class="form-label" for="id_number">ID Number</label>
    {{ html()->text('id_number')->placeholder('ID Number')->value($client->currentclientProfile()->id_number)->required()->class('form-control form-control-sm') }}
</div>

<div class="col-md-4">
    <label class="form-label" for="nssf_number">NIN</label>
    {{ html()->text('nin')->placeholder('NIN')->value($client->currentclientProfile()->nin)->class('form-control form-control-sm') }}
</div>

<div class="col-md-4">
    <label class="form-label" for="tin_number">Tin Number</label>
    {{ html()->text('tin')->placeholder('TIN')->value($client->currentclientProfile()->tin)->class('form-control form-control-sm') }}
</div>




<div class="col-md-4">
    <label class="form-label" for="permanent_address"> Address</label>
    {{ html()->text('address')->placeholder('Address')->value($client->currentclientProfile()->address)->class('form-control form-control-sm') }}
</div>
<div class="col-md-12">
    <label class="form-label" for="description">Other Information</label>
    {{ html()->textarea('description')->value($client->currentclientProfile()->description)->placeholder('Other Information')->rows('5')->class('form-control form-control-sm') }}
</div>


<div class="col-12 actions" style="margin-top:10px">
    <button class="btn btn-primary" type="submit">Submit</button>
  </div>

</div>

