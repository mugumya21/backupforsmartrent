<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class='themeClassselector {{Auth::user()->theme}}'>
<head>

@include('layouts.head')

</head>

<body>

<input type="hidden" value="{{Auth::user()->theme}}" id="themecustomselector">
  <div class="toast position-absolute top-0 end-0 text-white  bg-success"  role="alert" aria-live="assertive" aria-atomic="true" id="liveToast"  data-delay="2000" style="margin-top:10px; margin-right:10px">
    <div class="toast-header">
      <strong class="me-auto">Message</strong>
  
      <button class="ms-2 btn-close" type="button" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  <div class="toast-body"><span style="font-size:14px;"> <b>Ausome!</b>  that was successful</span></div>
  </div>

  <div class="toast position-absolute top-0 end-0 text-white  bg-danger"  role="alert" aria-live="assertive" aria-atomic="true" id="liveToasterror"  data-delay="2000" style="margin-top:10px; margin-right:10px">
    <div class="toast-header">
      <strong class="me-auto">Message</strong>
  
      <button class="ms-2 btn-close" type="button" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  <div class="toast-body"><span style="font-size:14px;"> <b>Oops!</b>  something went wrong</span></div>
  </div>


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



@include('shared.sidebar-left')

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
@if(Session::has('success'))
<div class="toast show position-absolute top-0 end-0 text-white  bg-success"  role="alert" aria-live="assertive" aria-atomic="true" id="liveToastSuccessBtn"  data-delay="2000" style="margin-top:10px; margin-right:10px">
  <div class="toast-header">
    <strong class="me-auto">Message</strong>

    <button class="ms-2 btn-close" type="button" data-bs-dismiss="toast" aria-label="Close"></button>
  </div>
<div class="toast-body"><span style="font-size:14px;"> <b>Ausome!</b>  that was successful</span></div>
</div>
@endif

<button class="btn btn-primary hidden" id="liveToastBtn" type="button">Show live toast</button>



{{-- 
@if(Session::has('error'))
<div class="toast show position-absolute top-0 end-0 text-white  bg-danger"  role="alert" aria-live="assertive" aria-atomic="true"  data-delay="2000" style="margin-top:10px; margin-right:10px">
  <div class="toast-header">
    <strong class="me-auto">Message</strong>

    <button class="ms-2 btn-close" type="button" data-bs-dismiss="toast" aria-label="Close"></button>
  </div>
<div class="toast-body"><span style="font-size:14px;"> <b>Oops!</b>  something went wrong</span></div>
</div>
@endif --}}


<div class="modal fade" id="staticBackdrop" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  
</div>

</main>

{{-- @vite('resources/css/app.css') --}}
<script src="{{ asset('vendors/popper/popper.min.js') }}"></script>
<script src="{{ asset('vendors/bootstrap/bootstrap.min.js') }}"></script>
<script src="{{ asset('vendors/anchorjs/anchor.min.js') }}"></script>
<script src="{{ asset('vendors/is/is.min.js') }}"></script>
<script src="{{ asset('vendors/fontawesome/all.min.js') }}"></script>
<script src="{{ asset('vendors/lodash/lodash.min.js') }}"></script>
<script src="{{ asset('assets/js/polyfill.min.js?features=window.scroll') }}"></script>
<script src="{{ asset('assets/js/theme.js') }}"></script>

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


@yield('include-js')

</body>

</html>


