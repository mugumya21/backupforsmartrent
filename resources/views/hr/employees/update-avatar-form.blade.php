{{ html()->form('POST')->route('hr.employees.update_avatarSubmit',$employee)->acceptsFiles()->class('row g-3 needs-validation')->novalidate()->open() }}

<div class="col-md-6">
    <label class="form-label asterik" for="inputCity">Avatar</label>

    {{ html()->file('avatar')->autofocus()->required()->class('form-control form-control-sm')->id('customFile') }}

    {{ html()->hidden('employee_id')->value($employee->id)->required() }}
    
</div>


<div class="col-12">
  <button class="btn btn-primary" type="submit">Update</button>
</div>

{{ html()->form()->close() }}