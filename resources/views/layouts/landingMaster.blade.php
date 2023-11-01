<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>@yield('title') | Siak - KPRI Usaha Jaya</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    @yield('pageStyle')
    @include('layouts.sections.styles.styles-landing')
    <!-- =======================================================
  * Template Name: SoftLand
  * Updated: Sep 18 2023 with Bootstrap v5.3.2
  * Template URL: https://bootstrapmade.com/softland-bootstrap-app-landing-page-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

    <!-- ======= Header ======= -->
    @include('layouts.sections.header.landing-header')
    <!-- End Header -->

    @yield('content')

    <!-- ======= Footer ======= -->
    @include('layouts.sections.footer.landing-footer')

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    @include('layouts.sections.script.footer-landing')
    @yield('pageScript')
</body>

</html>
