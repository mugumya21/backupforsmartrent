  {{ html()->form('POST')->route('admin.users.store')->class('row g-3 needs-validation')->novalidate()->open() }}

    <div class="col-md-4">
        <label class="form-label asterik" for="inputCity">First name</label>
        {{ html()->text('first_name')->autofocus()->required()->placeholder('First name')->class('form-control form-control-sm')->id('validationCustom01') }}
      
    </div>

    <div class="col-md-4">
        <label class="form-label" for="inputCity">Middle Name</label>
        {{ html()->text('middle_name')->placeholder('Middle Name')->class('form-control form-control-sm') }}
      
    </div>

    <div class="col-md-4">
        <label class="form-label asterik" for="last_name">Last Name</label>
        {{ html()->text('last_name')->required()->placeholder('Last Name')->class('form-control form-control-sm') }}
       
    </div>

    <div class="col-md-4">
        <label class="form-label asterik" for="telephone">Telephone</label>
        {{ html()->text('telephone')->required()->placeholder('Telephone')->class('form-control form-control-sm') }}
      
    </div>

    <div class="col-md-4">
        <label class="form-label asterik" for="date_of_birth">Date Of Birth</label>
        {{ html()->text('date_of_birth')->required()->placeholder('d/m/Y')->class('form-control form-control-sm datetimepicker')->id('datepicker') }}

       
    </div>

      
    <div class="col-md-4">
        <label class="form-label asterik" for="code">Role</label>
        {{ html()->select('role_id')->options($roles->pluck('name','id'))->required()->placeholder('Select an Option')->class('form-select form-select-sm js-choice') }}

    </div>


     
    <div class="col-md-4">
        <label class="form-label asterik" for="gender">Gender</label>
        {{ html()->select('gender')->options(['1'=>'Male','2'=>'Female'])->required()->placeholder('Select an Option')->class('form-select form-select-sm js-choice') }}

    </div>


    <div class="col-md-4">
        <label class="form-label asterik" for="code">Marital Status</label>
        {{ html()->select('marital_status_id')->options($maritalstatuses->pluck('name','id'))->required()->placeholder('Select an Option')->class('form-select form-select-sm js-choice') }}

    </div>

    <div class="col-md-4">
        <label class="form-label" for="code">Code</label>
        {{ html()->text('code')->placeholder('Code')->class('form-control form-control-sm') }}
    </div>

    <div class="col-md-4">
        <label class="form-label asterik" for="code">Branch</label>
        {{ html()->select('branch_id')->options($branches->pluck('name','id'))->required()->placeholder('Select an Option')->class('form-select form-select-sm js-choice') }}

    </div>

     

    <div class="col-md-4">
        <label class="form-label" for="id_number">ID Number</label>
        {{ html()->text('id_number')->placeholder('ID Number')->class('form-control form-control-sm') }}
    </div>

    <div class="col-md-4">
        <label class="form-label" for="nssf_number">Nssf Number</label>
        {{ html()->text('nssf_number')->placeholder('Nssf Number')->class('form-control form-control-sm') }}
    </div>

    <div class="col-md-4">
        <label class="form-label" for="tin_number">Tin Number</label>
        {{ html()->text('tin_number')->placeholder('Tin Number')->class('form-control form-control-sm') }}
    </div>

    <div class="col-md-4">
        <label class="form-label" for="personal_email">Personal Email</label>
        {{ html()->text('personal_email')->placeholder('Personal Email')->class('form-control form-control-sm') }}
    </div>

    <div class="col-md-4">
        <label class="form-label" for="permanent_address">Permanent Address</label>
        {{ html()->text('permanent_address')->placeholder('Permanent Address')->class('form-control form-control-sm') }}
    </div>

    <div class="col-md-4">
        <label class="form-label" for="present_address">Present Address</label>
        {{ html()->text('present_address')->placeholder('Present Address')->class('form-control form-control-sm') }}
    </div>

    <div class="col-md-4">
        <label class="form-label" for="office_number">Office Number</label>
        {{ html()->text('office_number')->placeholder('Office Number')->class('form-control form-control-sm') }}
    </div>

    <div class="col-md-4">
        <label class="form-label" for="mobile_number">Mobile Number</label>
        {{ html()->text('mobile_number')->placeholder('Mobile Number')->class('form-control form-control-sm') }}
    </div>


  

    <div class="col-md-4">
        <label class="form-label asterik" for="inputEmail4">Username</label>
        <input id="name" type="text" class="form-control form-control-sm @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" placeholder="Username" aria-label="username">

        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
      </div>

    <div class="col-md-4">
      <label class="form-label asterik" for="">Email</label>
      <input id="email" type="text" class="form-control form-control-sm" name="email" value="{{ old('email') }}" required autocomplete="email"  placeholder="Email" aria-label="email">

      @error('email')
      <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
      </span>
  @enderror
    </div>
    
    <div class="col-md-4">
      <label class="form-label asterik" for="password">Password</label>
      <input id="password" type="password" class="form-control form-control-sm @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Password">

      @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
    </div>
    
    <div class="col-4">
      <label class="form-label" for="password-confirm">{{ __('Confirm Password') }}</label>
      <input id="password-confirm" type="password" class="form-control form-control-sm" name="password_confirmation" required autocomplete="new-password">

    </div>
    
    <div class="col-12">
      <button class="btn btn-primary" type="submit">Submit</button>
    </div>

    {{ html()->form()->close() }}