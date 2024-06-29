<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class='themeClassselector {{Auth::user()->theme}}'>
<head>

@include('layouts.head')


@if (session()->has('error'))
<style>
  .toast {
    background-color: var(--falcon-alert-danger-background);
     color: var(--falcon-alert-danger-color);
  }

  .me-auto {
    color: var(--falcon-alert-danger-color);
}
</style>
@endif


@if (session()->has('success'))
<style>
  .toast {
background-color: var(--falcon-alert-success-background);
color: var(--falcon-alert-success-color);
  }
  .me-auto {
     color: var(--falcon-alert-success-color);
}
</style>
@endif



</head>

<body>
  

<input type="hidden" value="{{Auth::user()->theme}}" id="themecustomselector">


<div class="toast end-0" role="alert" data-bs-autohide="true" aria-live="assertive" aria-atomic="true" id="liveToast" data-delay="2000">
  <div class="toast-header"><strong class="me-auto">@if (session()->has('error')) Error Message @endif @if (session()->has('success')) Success Message @endif</strong>
    <button class="ms-2 btn-close" type="button" data-bs-dismiss="toast" aria-label="Close"></button>
  </div>
  <div class="toast-body">@if (session()->has('error')){{session('error')}}@endif @if (session()->has('success')){{session('success')}}@endif</div>
  </div>



  <div class="toast end-0" role="alert" data-bs-autohide="true" aria-live="assertive" aria-atomic="true" id="liveToastError" data-delay="2000">
    <div class="toast-header"><strong class="me-auto">Error Message</strong>
      <button class="ms-2 btn-close" type="button" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body"><img
      src="{{ asset("assets/img/icons/error.png") }}" style="height:30px; margin-top:-5px;" /> </div>
    </div>

    <button class="btn btn-primary hidden" id="liveToastBtn" type="button"></button>
    <button class="btn btn-primary hidden" id="liveToastErrorBtn" type="button"></button>
  

    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">
      <div class="container" data-layout="container">
        <script>
          var isFluid = JSON.parse(localStorage.getItem('isFluid'));
          if (isFluid) {
            var container = document.querySelector('[data-layout]');
            container.classList.remove('container');
            container.classList.add('container-fluid');
          }
    </script>



@include('shared.sidebar-top')

<div class="content">
 
<div class="row mb-3 g-3">
  
  <div class="col-lg-2">
    @include('shared.sidebar-left')
  </div>

  <div class="col-lg-10">
    @yield('content')
  </div>

</div>

@include('layouts.footer')

</div>


</div>

<div class="modal fade" id="staticBackdrop" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  
</div>

</main>

{{-- @vite('resources/css/app.css') --}}

@include('sweetalert::alert')

<script src="{{ asset('assets/js/feather.min.js') }}"></script>
<script src="{{ asset('vendors/popper/popper.min.js') }}"></script>
<script src="{{ asset('vendors/bootstrap/bootstrap.min.js') }}"></script>
<script src="{{ asset('vendors/anchorjs/anchor.min.js') }}"></script>
<script src="{{ asset('vendors/is/is.min.js') }}"></script>
<script src="{{ asset('vendors/fontawesome/all.min.js') }}"></script>
<script src="{{ asset('vendors/lodash/lodash.min.js') }}"></script>
<script src="{{ asset('assets/js/polyfill.min.js?features=window.scroll') }}"></script>
<script src="{{ asset('assets/js/theme.js') }}"></script>
<script>
  feather.replace()
</script>

<script src="{{ asset('assets/js/jquery-3.7.1.js') }}"></script>


<script>

  var loadthemeset =  $('#themecustomselector').val();
  $('.themeClassselector').addClass(loadthemeset);
  
  if(loadthemeset == 'light'){
      var removedclass = 'dark';
      $('#sunicon').hide();
      $('#moonicon').show();

      $('#darklogo').removeClass('hidden');

    } else {
      var removedclass = 'light';
      $('#sunicon').show();
      $('#moonicon').hide();

      $('#whitelogo').removeClass('hidden');
    }

  $('#changethemebtn').click(function () {
  
  var themeset =  $('#themecustomselector').val();

  $.ajax({
  type:'get',
  url:'{{ route('admin.updatetheme') }}',
  data:{'id':themeset},
  success:function(data){

    if(data == 'light'){
      var removedclass = 'dark';
      $('#sunicon').hide();
      $('#moonicon').show();

      $('#whitelogo').addClass('hidden');
      $('#darklogo').removeClass('hidden');
    } else {
      var removedclass = 'light';
      $('#sunicon').show();
      $('#moonicon').hide();

      $('#darklogo').addClass('hidden');
      $('#whitelogo').removeClass('hidden');
    }

  $("#themecustomselector").val(data);
  $('.themeClassselector').removeClass(removedclass);
  $('.themeClassselector').addClass(data);
  
  },
  error:function(){
  }
  
  });
  
   
          });
  
  </script>

@if (session()->has('error'))
<script>
   $(document).ready(function () {
    var liveToast = new window.bootstrap.Toast(document.getElementById('liveToast'));
      liveToast && liveToast.show();

   });
</script>

@endif

@if (session()->has('success'))
<script>
   $(document).ready(function () {
    var liveToast = new window.bootstrap.Toast(document.getElementById('liveToast'));
      liveToast && liveToast.show();

   });
</script>

@endif


@yield('include-js')

</body>

</html>