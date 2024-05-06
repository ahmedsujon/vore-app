<div>
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
                                <a href="#" class="header_btn">
                                    <span>Download Vore</span>
                                </a>
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
</div>
