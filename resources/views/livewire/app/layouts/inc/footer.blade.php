<div>
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
                                        <img src="{{ asset('assets/app/icons/instagram_icon.svg') }}" alt="instagram" />
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
        <div class="mobile_language_login_area d-flex justify-content-between flex-wrap">
            <div class="header_button_area">
                <a href="#" class="header_btn"><span>Download Vore</span> </a>
            </div>
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
</div>
