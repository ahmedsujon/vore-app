<div>
    <main>
        <!-- Hero  Section  -->
        <section class="hero_wrapper">
            <div class="container">
                <div class="row">
                    <nav class="breadcrumb_area" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('app.home') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                About Us
                            </li>
                        </ol>
                    </nav>
                    <div class="col-lg-6">
                        <div class="hero_content_area">
                            <h1>About Us</h1>
                            <h4>
                                Vore is a comprehensive calorie tracking solution designed to
                                simplify your journey to better nutrition and physical
                                wellness.
                            </h4>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="about_hero_img_area text-center">
                            <img src="{{ asset('assets/app/images/about/about_hero_screen1.png') }}" alt="food image"
                                class="about_hero_screen1" data-aos="fade-right" />
                            <img src="{{ asset('assets/app/images/about/about_hero_screen2.png') }}" alt="food image"
                                class="about_hero_screen2" data-aos="fade-left" data-aos-delay="100" />
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Mission Section  -->
        <section class="mission_wrapper default_section_gap">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="mission_img_area">
                            <img src="{{ asset('assets/app/images/about/mission_background.png') }}"
                                alt="mission background" class="mission_background" />
                            <img src="{{ asset('assets/app/images/about/mission_screen1.png') }}" alt="mission screen"
                                class="mission_screen1" data-aos="fade-right" />
                            <img src="{{ asset('assets/app/images/about/mission_screen2.png') }}" alt="mission screen"
                                class="mission_screen2" data-aos="fade-right" data-aos-delay="150" />
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mission_content mlg-30">
                            <h2 class="page_title">Our Mission</h2>
                            <p>
                                At vore, our mission is to empower individuals to take control
                                of their health by making informed decisions about their food
                                consumption. We believe that understanding your calorie intake
                                is key to achieving your wellness goal, whether you're looking
                                to lose weight, gain muscle, or simply maintain a balanced
                                lifestyle. Our goal is to provide you with the tools and
                                support you need to succeed in your journey to a healthier
                                you.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Features Section  -->
        <section class="features_wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h2 class="features_title">Key Features</h2>
                        <h5 class="features_pera mt-40">
                            Discover the powerful features that make Vore the ultimate
                            calorie tracking app.
                        </h5>
                        <div class="features_grid">
                            <div class="features_item" data-aos="fade-up">
                                <div class="icon">
                                    <img src="{{ asset('assets/app/icons/easy_interface.svg') }}"
                                        alt="easy interface" />
                                </div>
                                <div class="content">
                                    <h3>Easy-to-Use Interface</h3>
                                    <p>
                                        Log your meals and track your calorie intake with ease
                                        using our intuitive interface.
                                    </p>
                                </div>
                            </div>
                            <div class="features_item" data-aos="fade-up" data-aos-delay="150">
                                <div class="icon">
                                    <img src="{{ asset('assets/app/icons/goal.svg') }}" alt="goal" />
                                </div>
                                <div class="content">
                                    <h3>Personalized Goals</h3>
                                    <p>
                                        Set personalized goals based on your age, weight, activity
                                        level, and dietary preferences.
                                    </p>
                                </div>
                            </div>
                            <div class="features_item" data-aos="fade-up" data-aos-delay="200">
                                <div class="icon">
                                    <img src="{{ asset('assets/app/icons/planing.svg') }}" alt="planing" />
                                </div>
                                <div class="content">
                                    <h3>Meal Planning</h3>
                                    <p>
                                        Plan your meals in advance and stay on track with your
                                        nutritional goal.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Choose Section  -->
        <section class="choose_wrapper default_section_gap">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="header_area">
                            <h2 class="page_title">Why Choose Us</h2>
                            <h5>
                                What sets Vore apart is our commitment to accuracy, usability,
                                and innovation. Our app is built on a foundation of scientific
                                research and nutritional expertise, ensuring that you have
                                access to reliable information you can trust. With intuitive
                                features and personalized recommendations, Vore makes it easy
                                to track your calories, stay motivated, and achieve lasting
                                results.What sets Vore apart is our commitment to accuracy,
                                usability, and innovation. Our app is built on a foundation of
                                scientific research and nutritional expertise, ensuring that
                                you have access to reliable information you can trust. With
                                intuitive features and personalized recommendations, Vore
                                makes it easy to track your calories, stay motivated, and
                                achieve lasting results.
                            </h5>
                        </div>
                        <div class="choose_grid">
                            <div class="choose_item" data-aos="fade-up">
                                <div class="choose_img">
                                    <img src="{{ asset('assets/app/images/about/chose_screen1.png') }}"
                                        alt="choose screen" />
                                </div>
                                <h4>Easy to Track</h4>
                            </div>
                            <div class="choose_item" data-aos="fade-up" data-aos-delay="150">
                                <div class="choose_img">
                                    <img src="{{ asset('assets/app/images/about/chose_screen2.png') }}"
                                        alt="choose screen" />
                                </div>
                                <h4>Achieve Lasting Results</h4>
                            </div>
                            <div class="choose_item" data-aos="fade-up" data-aos-delay="200">
                                <div class="choose_img">
                                    <img src="{{ asset('assets/app/images/about/chose_screen1.png') }}"
                                        alt="choose screen" />
                                </div>
                                <h4>Track Your Activity</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Work Goal Section  -->
        <section class="work_goal_wrapper default_section_gap"
            style="
            background-image: url('assets/app/images/home/work_goal_background.png');
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
                                    <img src="{{ asset('assets/app/icons/google_play.png') }}"
                                        alt="google play icon" />
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
    </main>
</div>
