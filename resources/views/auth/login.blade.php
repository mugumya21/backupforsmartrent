@extends('layouts.app-login')

@section('content')

<div class="container" style="max-width: 1140px !important;">

    <div class="row flex-center min-vh-100 py-6">
    <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
      <div class="card" style="border-radius: 15px;">
        <div class="card-body p-4 p-sm-4">
          <div class="row flex-between-center mb-2">

       <center>
        <img class="me-2" src="{{ asset('assets/img/logo.png')}}" alt="" style="width: 66%; margin-bottom: 13px;" />
       </center>
      
          </div>
          <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
              <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email address">

              @error('email')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror

            </div>
            <div class="mb-3 col-12 password-wrapper">
                <input value="" id="myInput" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="current-password">
                <i class="far fa-eye password-toggler" id="togglePassword" onclick="myFunction()" ></i>

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

              </div>
            <div class="row flex-between-center">
              <div class="col-auto">
                <div class="form-check mb-0">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                  <label class="form-check-label mb-0" for="basic-checkbox">Remember me</label>
                </div>
              </div>
              <div class="col-auto">
                @if (Route::has('password.request'))
                <a class="fs--1" href="{{ route('password.request') }}">
                    {{ __('Forgot Password?') }}
                </a>
            @endif

            </div>
            </div>
            <div class="mb-3">
              <button class="btn btn-primary d-block w-100 mt-3" type="submit" name="submit">Log in</button>
            </div>
          </form>
          <div class="position-relative mt-4">
            <div class="col-sm-12 text-center">
                <p class="fs--2" style="margin-bottom: 0px;">&copy; 2024 SmartRent.</p>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

@endsection

@section('include-js')
<script>
    function  myFunction(){

        const passwordshow = document.getElementById("myInput");
        if(passwordshow.type === "password"){
            passwordshow.type = "text";

        }
        else{
             passwordshow.type = "password";
        }
    };
    </script>
@endsection
