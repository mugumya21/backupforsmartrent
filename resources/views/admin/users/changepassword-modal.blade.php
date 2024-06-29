@extends('layouts.app')

@section('title', 'Properties')

@section('head-css')
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendors/prism/prism-okaidia.css') }}" rel="stylesheet">

<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet">
@endsection

@section('content')


<div class="card mb-3 col-md-5">
  <div class="card-header bg-light">
    <div class="row flex-between-end">
      <div class="col-auto align-self-center">
        <h5 class="mb-0" data-anchor="data-anchor" id="example">Change Password<a class="anchorjs-link " aria-label="Anchor" data-anchorjs-icon="#" href="#example" style="padding-left: 0.375em;"></a></h5>
      </div>
      <div class="col-auto ms-auto">
        <div class="nav nav-pills nav-pills-falcon flex-grow-1" role="tablist">
         
        </div>
      </div>
    </div>
    
  </div>
  <div class="card-body text-justify">
  
    
    <form method="POST" action="{{ route('admin.user.changepasswordSubmit') }}" class="row g-3">
      @csrf

    {{ html()->hidden('user_id')->value($user->id)->required()->class('form-control form-control-sm') }}


    <div class="form-group {{ $errors->has('old_password') ? 'has-error' : '' }}">
      <label for="password" class="form-label asterik">Old Password</label>
   
      {{ html()->password('old_password')->required()->placeholder('Old Password')->required()->class('form-control form-control-sm ') }}

      </div>


    <div class="col-md-12">      
    <label for="password" class="form-label asterik">{{ __('Password') }}</label>

    <input id="password" type="password" required class="form-control form-select-sm  @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

    @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror

  </div>

    <div class="col-md-12">   
      <label for="password-confirm" class="form-label asterik">{{ __('Confirm Password') }}</label>
          <input id="password-confirm" required type="password" class="form-control form-select-sm " name="password_confirmation" required autocomplete="new-password">
          
  </div>

  <div class="d-grid gap-2">
      <button class="btn btn-primary" type="submit"> {{ __('Reset Password') }}</button>
    </div>
   
    </form>   

  </div>
  
</div>



@endsection




@section('include-js')

<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="{{ asset('assets/js/cleave.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>

<script>
main.init();
  
</script>
    
<script src="{{ asset('assets/js/flatpickr.js') }}"></script>
<script src="{{ asset('vendors/prism/prism.js') }}"></script>

@endsection