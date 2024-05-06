<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>Home</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" href="assets/images/header/logo.png" type="image/x-icon" />
    <link rel="stylesheet" href="{{ asset('assets/app/plugins/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/app/plugins/css/swiper-bundle.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/app/plugins/css/magnific-popup.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/app/plugins/css/aos/aos.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/app/sass/style.css') }}" />
    @livewireStyles
</head>

<body>
    <!-- Scroll To Top -->
    <div class="scrolltop" id="scrollTop">
        <i class="fas fa-chevron-up"></i>
    </div>


    @livewire('app.layouts.inc.header')
    {{ $slot }}
    @livewire('app.layouts.inc.footer')

    <!-- JS Here -->
    <script src="{{ asset('assets/app/plugins/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/app/plugins/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/app/plugins/js/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/app/plugins/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script src="https://kit.fontawesome.com/46f35fbc02.js" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/app/js/main.js') }}"></script>
    @livewireScripts
</body>

</html>
