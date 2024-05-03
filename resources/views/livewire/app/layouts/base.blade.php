<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Vore</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/admin/images/favicon.ico') }}">

    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/admin/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet"
        type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/admin/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets/admin/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <!-- App js -->
    <script src="{{ asset('assets/admin/js/plugin.js') }}"></script>

</head>

<body>

    @livewire('app.layouts.inc.header')
    {{ $slot }}
    @livewire('app.layouts.inc.footer')

    <!-- JAVASCRIPT -->
    <script src="{{ asset('assets/admin/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/node-waves/waves.min.js') }}"></script>

    <!-- Plugins js-->
    <script src="{{ asset('assets/admin/libs/jquery-countdown/jquery.countdown.min.js') }}"></script>

    <!-- Countdown js -->
    <script src="{{ asset('assets/admin/js/pages/coming-soon.init.js') }}"></script>

    <script src="{{ asset('assets/admin/js/app.js') }}"></script>

</body>

</html>
