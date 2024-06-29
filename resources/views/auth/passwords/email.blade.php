@extends('layouts.app-login')

@section('content')

<div class="container" style="max-width: 1140px !important;">

    <div class="row flex-center min-vh-100 py-6">
    <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
      <div class="card" style="border-radius: 15px;">
        <div class="card-body p-4 p-sm-4">
          <div class="row flex-between-center mb-2">
            <div class="col-auto">
              <h3>{{ __('Reset Password') }}</h3>
            </div>

          </div>

          @if (session('status'))
          <div class="alert alert-success" role="alert">
              {{ session('status') }}
          </div>
      @endif


          <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="row mb-3">

                <div class="col-md-12">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email Address" value="{{ old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                    <button type="submit" class="btn btn-primary d-block w-100 mt-3">
                        {{ __('Send Password Reset Link') }}
                    </button>
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
