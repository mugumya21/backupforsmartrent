<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

@include('layouts.head')
<style>
    .password-wrapper {
        position: relative;
        display: inline-block; /* Ensure the wrapper only takes as much space as the input and icon */
    }

    .password-toggler {
        position: absolute;
        top: 50%; /* Position vertically centered */
        right: 10px; /* Distance from the right edge of the wrapper */
        transform: translateY(-50%); /* Center vertically */
        cursor: pointer;
    }</style>

</head>


<body>

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


@yield('content')


</div>
</main>


<script src="vendors/popper/popper.min.js"></script>
<script src="vendors/bootstrap/bootstrap.min.js"></script>
<script src="vendors/anchorjs/anchor.min.js"></script>
<script src="vendors/is/is.min.js"></script>
<script src="vendors/echarts/echarts.min.js"></script>
<script src="vendors/fontawesome/all.min.js"></script>
<script src="vendors/lodash/lodash.min.js"></script>
<script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script>
<script src="vendors/list.js/list.min.js"></script>
<script src="assets/js/theme.js"></script>

@yield('include-js')

</body>

</html>


