<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>Home</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" href="{{ asset('assets/app/images/header/logo.png') }}" type="image/x-icon" />
    <link rel="stylesheet" href="{{ asset('assets/app/plugins/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/app/plugins/css/swiper-bundle.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/app/plugins/css/magnific-popup.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/app/plugins/css/aos/aos.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/app/sass/style.css') }}" />
</head>

<body>
    <!-- Scroll To Top -->
    <div class="scrolltop" id="scrollTop">
        <i class="fas fa-chevron-up"></i>
    </div>

    <!-- Header Section  -->
    <header class="header_wrapper" id="headerWrapper">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="haeder_flex d-flex align-items-center justify-content-between flex-wrap g-lg">
                        <div class="logo">
                            <a href="{{ route('app.home') }}">
                                <img src="{{ asset('assets/app/images/layout/header_logo.png') }}" alt="logo" />
                            </a>
                        </div>
                        <div class="nav_btn_area">
                            <nav class="nav_area">
                                <ul class="main_menu_list d-flex align-items-center justify-content-center flex-wrap">
                                    <li>
                                        <a href="{{ route('app.aboutus') }}"
                                            class="{{ request()->is('about-us') ? 'active_menu' : '' }}">About</a>
                                    </li>

                                    <li>
                                        <a href="{{ route('app.contact.us') }}"
                                            class="{{ request()->is('contact-us') ? 'active_menu' : '' }}">Contact
                                            Us</a>
                                    </li>
                                </ul>
                            </nav>
                            <div class="header_btn_area d-flex align-items-center justify-content-end flex-wrap g-lg">
                                <button type="button" class="menu_toggle_btn" id="menuToggleBtn">
                                    <i class="fa-solid fa-bars"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main>
        {{ $slot }}
    </main>

    <!-- Footer Section  -->
    <footer class="footer_wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-12">
                    <div class="logo_area">
                        <a href="{{ route('app.home') }}">
                            <img src="{{ asset('assets/app/images/layout/footer_logo.png') }}" alt="footer logo" />
                        </a>
                    </div>
                </div>
                <div class="col-md-2 col-4">
                    <div class="footer_menu_item">
                        <h3>Company</h3>
                        <ul>
                            <li><a href="{{ route('app.aboutus') }}">About</a></li>
                            <li><a href="#">Company</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-2 col-4">
                    <div class="footer_menu_item">
                        <h3>Legal</h3>
                        <ul>
                            <li><a href="{{ route('terms.conditions') }}">Terms of Service</a></li>
                            <li><a href="#">Company</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-2 col-4">
                    <div class="footer_menu_item">
                        <h3>Career</h3>
                        <ul>
                            <li><a href="#">Coming soon</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="copy_right_wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex align-items-center justify-content-between flex-wrap g-lg">
                            <h4>© 2024 Vore Inc. All Rights Reserved.</h4>
                            <ul class="social_list d-flex align-items-center flex-wrap">
                                <li>
                                    <a href="https://www.instagram.com/vore.app/" target="_blank">
                                        <img src="{{ asset('assets/app/icons/instagram_icon.svg') }}"
                                            alt="instagram" />
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.facebook.com/voreapp" target="_blank">
                                        <img src="{{ asset('assets/app/icons/facebook_icon.svg') }}" alt="facebook" />
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.linkedin.com/company/vore" target="_blank">
                                        <img src="{{ asset('assets/app/icons/linkedin_icon.svg') }}" alt="linkedin" />
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- navigation drawaer from left start -->
    <div class="mobile_menu_area">
        <div class="mobile_menu_overlay"></div>
        <div class="menu_close_icon text-end">
            <i class="fas fa-times close_icon"></i>
        </div>

        <div class="accordion" id="accordionMenu">
            <div class="accordion-item">
                <h2><a href="{{ route('app.aboutus') }}"
                        class="{{ request()->is('about-us') ? 'mobile_active_menu' : '' }}">About</a></h2>
            </div>

            <div class="accordion-item">
                <h2><a href="{{ route('app.contact.us') }}"
                        class="{{ request()->is('contact-us') ? 'mobile_active_menu' : '' }}">Contact Us</a></h2>
            </div>
        </div>
    </div>
    <!-- navigation drawaer from left end -->
    <!-- JS Here -->
    <script src="{{ asset('assets/app/plugins/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/app/plugins/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/app/plugins/js/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/app/plugins/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script src="https://kit.fontawesome.com/46f35fbc02.js" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/app/js/main.js') }}"></script>
</body>

</html>
