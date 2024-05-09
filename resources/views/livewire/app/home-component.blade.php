<div>
    <!-- Hero  Section  -->
    <section class="hero_wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="hero_content_area" data-aos="fade-up">
                        <h1>Take charge of your well-being</h1>
                        <h4>
                            Log your meals, training sessions, and track your progress
                            towards your goal on our free app.
                        </h4>
                        <div class="social-share-button">
                            <a href="#" class="default_btn"> <span>Follow Us</span> </a>
                            <ul class="hero_social_list d-flex align-items-center flex-wrap">
                                <li>
                                    <a href="https://www.instagram.com/vore.app/" target="_blank">
                                        <i class="fa-brands fa-instagram"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.facebook.com/voreapp" target="_blank">
                                        <i class="fa-brands fa-facebook"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.linkedin.com/company/vore" target="_blank">
                                        <i class="fa-brands fa-linkedin"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="avaiable_area">
                            <h4>Available on</h4>
                            <div class="app_area d-flex align-items-center flex-wrap">
                                <a href="https://apps.apple.com/sa/app/vore/id6480172276" target="_blank">
                                    <img src="{{ asset('assets/app/icons/app_store.png') }}" alt="app store icon" />
                                </a>
                                <a href="https://play.google.com/store/apps/details?id=com.vore.app.vore&hl=en&gl=US" target="_blank">
                                    <img src="{{ asset('assets/app/icons/google_play.png') }}" alt="google play icon" />
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="hero_img_area text-center">
                        <img src="{{ asset('assets/app/images/hero/hero_screen_image1.png') }}" alt="food image"
                            class="hero_screen1" data-aos="fade-right" />
                        <img src="{{ asset('assets/app/images/hero/hero_screen_image2.png') }}" alt="food image"
                            class="hero_screen2" data-aos="fade-up" data-aos-delay="150" />
                        <img src="{{ asset('assets/app/images/hero/hero_screen_image3.png') }}" alt="food image"
                            class="hero_screen3" data-aos="fade-left" data-aos-delay="200" />
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Help Section  -->
    <section class="help_wrapper default_section_gap">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="header_area text-center">
                        <h2 class="page_title">How Vore helps you</h2>
                    </div>
                    <div class="help_grid">
                        <div class="calories_area">
                            <div class="chart_area">
                                <img src="{{ asset('assets/app/images/home/help_chart.png') }}" alt="help chart"
                                    data-aos="fade-up" />
                            </div>
                            <div class="content_area">
                                <h4>Track Your Calories</h4>
                                <p>
                                    Use the Vore app to log your meals and workouts. Utilize
                                    the convenient barcode scanner for quick entries. Pre-log
                                    your activities for superior planning and time management.
                                </p>
                            </div>
                        </div>
                        <div>
                            <div class="goal_area">
                                <h4>What is your goal?</h4>
                                <ul class="goal_list">
                                    <li data-aos="fade-right">
                                        <img src="{{ asset('assets/app/images/home/loose_weight.png') }}"
                                            alt="loose weight" />
                                    </li>
                                    <li data-aos="fade-left" data-aos-delay="100">
                                        <img src="{{ asset('assets/app/images/home/maintain_weight.png') }}"
                                            alt="maintain weight" />
                                    </li>
                                    <li data-aos="fade-right" data-aos-delay="150">
                                        <img src="{{ asset('assets/app/images/home/build_muscle.png') }}"
                                            alt="build muscle" />
                                    </li>
                                </ul>
                            </div>
                            <div class="content_area">
                                <h4>Set Your Goal</h4>
                                <p>
                                    When determining your daily caloric intake targets, Vore
                                    factors in your sex, age, weight, and most importantly,
                                    your ultimate goal.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Goal  Section  -->
    <section class="goal_wrapper default_section_gap"
        style="background-image: url('{{ asset('assets/app/images/home/goal_background.png') }}')">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="goal_content_area">
                        <h2>Monitor your health goals</h2>
                        <p>Track your progress and celebrate the small wins!</p>
                        <a href="#" class="default_btn goal_btn">
                            <span>Get started</span>
                        </a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="goal_img_area mm-30">
                        <img src="{{ asset('assets/app/images/home/goal_screen1.png') }}" alt="goal screen"
                            class="goal_screen1" data-aos="fade-left" />
                        <img src="{{ asset('assets/app/images/home/goal_screen2.png') }}" alt="goal screen"
                            class="goal_screen2" data-aos="fade-right" data-aos-delay="150" />
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Tracking Section  -->
    <section class="tracking_wrapper default_section_gap">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="header_area text-center">
                        <h2 class="page_title2">The Best Calorie Tracking App Ever</h2>
                        <p>
                            Unlike our competition, Vore has no subscription fees and
                            provides both macro and micro-nutrient intake details.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="tracking_slider_area">
            <div class="swiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <a href="{{ asset('assets/app/images/home/tracking_app_screen1.png') }}"
                            class="tracking_app_item">
                            <img src="{{ asset('assets/app/images/home/tracking_app_screen1.png') }}"
                                alt="tracking app screen" />
                        </a>
                    </div>
                    <div class="swiper-slide">
                        <a href="{{ asset('assets/app/images/home/tracking_app_screen2.png') }}"
                            class="tracking_app_item">
                            <img src="{{ asset('assets/app/images/home/tracking_app_screen2.png') }}"
                                alt="tracking app screen" />
                        </a>
                    </div>
                    <div class="swiper-slide">
                        <a href="{{ asset('assets/app/images/home/tracking_app_screen3.png') }}"
                            class="tracking_app_item">
                            <img src="{{ asset('assets/app/images/home/tracking_app_screen3.png') }}"
                                alt="tracking app screen" />
                        </a>
                    </div>
                    <div class="swiper-slide">
                        <a href="{{ asset('assets/app/images/home/tracking_app_screen1.png') }}"
                            class="tracking_app_item">
                            <img src="{{ asset('assets/app/images/home/tracking_app_screen1.png') }}"
                                alt="tracking app screen" />
                        </a>
                    </div>
                    <div class="swiper-slide">
                        <a href="{{ asset('assets/app/images/home/tracking_app_screen2.png') }}"
                            class="tracking_app_item">
                            <img src="{{ asset('assets/app/images/home/tracking_app_screen2.png') }}"
                                alt="tracking app screen" />
                        </a>
                    </div>
                    <div class="swiper-slide">
                        <a href="{{ asset('assets/app/images/home/tracking_app_screen3.png') }}"
                            class="tracking_app_item">
                            <img src="{{ asset('assets/app/images/home/tracking_app_screen3.png') }}"
                                alt="tracking app screen" />
                        </a>
                    </div>
                    <div class="swiper-slide">
                        <a href="{{ asset('assets/app/images/home/tracking_app_screen1.png') }}"
                            class="tracking_app_item">
                            <img src="{{ asset('assets/app/images/home/tracking_app_screen1.png') }}"
                                alt="tracking app screen" />
                        </a>
                    </div>
                    <div class="swiper-slide">
                        <a href="{{ asset('assets/app/images/home/tracking_app_screen2.png') }}"
                            class="tracking_app_item">
                            <img src="{{ asset('assets/app/images/home/tracking_app_screen2.png') }}"
                                alt="tracking app screen" />
                        </a>
                    </div>
                    <div class="swiper-slide">
                        <a href="{{ asset('assets/app/images/home/tracking_app_screen3.png') }}"
                            class="tracking_app_item">
                            <img src="{{ asset('assets/app/images/home/tracking_app_screen3.png') }}"
                                alt="tracking app screen" />
                        </a>
                    </div>
                </div>
                <!-- Add Pagination -->
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>
    <!-- Work Goal Section  -->
    <section class="work_goal_wrapper default_section_gap"
        style="
            background-image: url(assets/app/images/home/work_goal_background.png);
          ">
        <div class="container">
            <div class="row align-items-end">
                <div class="col-md-6 align-self-center">
                    <div class="work_goal_content">
                        <h2 class="page_title2">
                            Get the Vore app today and
                            <span class="work_color">work towards your goal.</span>
                        </h2>
                        <div class="app_area d-flex align-items-center flex-wrap">
                            <a href="#" target="_blank">
                                <img src="{{ asset('assets/app/icons/app_store.png') }}" alt="app store icon" />
                            </a>
                            <a href="#" target="_blank">
                                <img src="{{ asset('assets/app/icons/google_play.png') }}" alt="google play icon" />
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="work_image_area mm-30">
                        <img src="{{ asset('assets/app/images/home/hand_screen.png') }}" alt="hand screen"
                            data-aos="fade-up" />
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
