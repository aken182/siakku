<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Siak - KPRI Usaha Jaya</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    @include('layouts.sections.styles.styles-admin')
    @yield('pageStyle')
    @include('layouts.sections.script.header-admin')
</head>

<body>

    @yield('contentLayout')

    @include('layouts.sections.script.footer-admin')
</body>

</html>
