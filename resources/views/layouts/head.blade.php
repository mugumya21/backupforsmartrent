<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">


<!-- ===============================================-->
<!--    Document Title-->
<!-- ===============================================-->
<title>{{ config('app.name', '') }} - @yield('title')</title>


<!-- ===============================================-->
<!--    Favicons-->
<!-- ===============================================-->
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/favicons/favicon.png') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/favicons/favicon.png') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/favicons/favicon.png') }}">
<link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/favicons/favicon.png') }}">
<meta name="msapplication-TileImage" content="{{ asset('assets/img/favicons/favicon.png') }}">
<meta name="theme-color" content="#ffffff">
<script src="{{ asset('assets/js/config.js') }}"></script>
<script src="{{ asset('vendors/overlayscrollbars/OverlayScrollbars.min.js') }}"></script>

{{-- @vite('resources/css/app.css') --}}

<!-- ===============================================-->
<!--    Stylesheets-->
<!-- ===============================================-->

<link href="{{ asset('vendors/overlayscrollbars/OverlayScrollbars.min.css') }}" rel="stylesheet">
{{-- <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet"> --}}
<link href="{{ asset('assets/css/theme-rtl.min.css') }}" rel="stylesheet" id="style-rtl">

<link href="{{ asset('assets/css/select2.min.css')}}" rel="stylesheet">
<link href="{{ asset('assets/css/theme.css') }}" rel="stylesheet" id="style-default">
<link href="{{ asset('assets/css/user-rtl.min.css') }}" rel="stylesheet" id="user-style-rtl">
<link href="{{ asset('assets/css/user.min.css') }}" rel="stylesheet" id="user-style-default">

@yield('head-css')

<script>
    var isRTL = JSON.parse(localStorage.getItem('isRTL'));
    if (isRTL) {
      var linkDefault = document.getElementById('style-default');
      var userLinkDefault = document.getElementById('user-style-default');
      linkDefault.setAttribute('disabled', true);
      userLinkDefault.setAttribute('disabled', true);
      document.querySelector('html').setAttribute('dir', 'rtl');
    } else {
      var linkRTL = document.getElementById('style-rtl');
      var userLinkRTL = document.getElementById('user-style-rtl');
      linkRTL.setAttribute('disabled', true);
      userLinkRTL.setAttribute('disabled', true);
    }
  </script>