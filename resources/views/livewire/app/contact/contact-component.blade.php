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
                                Contact Us
                            </li>
                        </ol>
                    </nav>
                    <div class="col-lg-6">
                        <div class="hero_content_area">
                            <h1>Contact Us</h1>
                            <h4>
                                Have questions or need assistance? We're here to help! Reach
                                out to our dedicated support team for personalized assistance
                                and prompt resolution of any issues.
                            </h4>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="contact_hero_img_area text-center">
                            <img src="{{ asset('assets/app/images/contact/contact_hero_screen1.png') }}"
                                alt="food image" class="contact_hero_screen1" data-aos="fade-up" />
                            <img src="{{ asset('assets/app/images/contact/contact_hero_screen2.png') }}"
                                alt="food image" class="contact_hero_screen2" data-aos="fade-left"
                                data-aos-delay="150" />
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Question Section  -->
        <section class="question_wrapper default_section_gap">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h2 class="page_title text-center">Frequently asked question</h2>
                        <div class="accordion accordion-flush mt-40" id="accordionFlushExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#flush-collapseOne" aria-expanded="false"
                                        aria-controls="flush-collapseOne">
                                        How do I track my calories with the app?
                                    </button>
                                </h2>
                                <div id="flush-collapseOne" class="accordion-collapse collapse"
                                    data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        <p>
                                            Once you set your goal during onboarding, the <strong>Diary</strong> page will show you the
                                            amount of calories you need to consume on a daily basis to achieve your
                                            goal. Under the <strong>Meals</strong> section of the <strong>Diary</strong> page, you will be able to log
                                            your meals and Vore will automatically subtract from your daily intake.
                                            Ideally, you would be at, or as close as possible to, zero calories
                                            remaining.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#flush-collapseTwo" aria-expanded="false"
                                        aria-controls="flush-collapseTwo">
                                        Is the calorie database extensive?
                                    </button>
                                </h2>
                                <div id="flush-collapseTwo" class="accordion-collapse collapse"
                                    data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        <p>
                                            Yes. We have a partnership with <strong>FatSecret</strong> for our food and nutrition
                                            database. <strong>FatSecret</strong> containts over 1.5 million verified food items,
                                            including branded foods. <strong>FatSecret’s</strong> Platform API is the largest data set of
                                            global food nutrition information for more than 55 countries. This makes it
                                            easier for our users globally to search for food items or simply scan
                                            branded foods to log them within the app. In order to deliver the best, we
                                            had to partner with the best.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#flush-collapseThree" aria-expanded="false"
                                        aria-controls="flush-collapseThree">
                                        Can I set personalized goals in the app?
                                    </button>
                                </h2>
                                <div id="flush-collapseThree" class="accordion-collapse collapse"
                                    data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        <p>
                                            Absolutely. Once you download the Vore app and sign up, you will go through
                                            a quick onboarding process that will help you determine your ultimate goal
                                            of gaining, maintaining, or losing weight. You will also be able to decide
                                            how aggresively (within reason) you would like to gain or lose weight. Vore
                                            will then factor your goal, sex, age, current & goal weight to determine the
                                            number of calories you will need to consume on a daily basis to achieve your
                                            goal.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#flush-collapseFour" aria-expanded="false"
                                        aria-controls="flush-collapseFour">
                                        Does the app offer meal planning features?
                                    </button>
                                </h2>
                                <div id="flush-collapseFour" class="accordion-collapse collapse"
                                    data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        <p>
                                            Unfortunately, not at the moment. However, we are working on meal planning
                                            features that will be announced very soon. Stay tuned!
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#flush-collapseFive" aria-expanded="false"
                                        aria-controls="flush-collapseFive">
                                        Can I sync the app with other fitness devices?
                                    </button>
                                </h2>
                                <div id="flush-collapseFive" class="accordion-collapse collapse"
                                    data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        <p>
                                            Unfortunately, not at the moment. However, we are working on updates to the
                                            app and connecting other fitness devices is on the top of the list. We
                                            understand how important this feature is for users to be able to accurately
                                            track exercise activities and daily steps with the Vore app.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Contact Form Section  -->
        <section class="contact_form_wrapper default_section_gap">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="contact_grid">
                            <div class="contact_img_area">
                                <img src="{{ asset('assets/app/images/contact/contact_form_screen.png') }}"
                                    alt="contact form screen" />
                            </div>
                            <div class="contact_form_area">
                                <form wire:submit.prevent='storeData' class="form_area">
                                    <h2 class="page_title">We’re Happy to Help!</h2>
                                    <div class="input_row">
                                        <div class="icon">
                                            <img src="{{ asset('assets/app/icons/user-circle.svg') }}"
                                                alt="user icon" />
                                        </div>
                                        <input type="text" wire:model='name' placeholder="Full Name"
                                            class="input_filed" />
                                        @error('name')
                                            <p class="text-danger" style="font-size: 16px;">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="input_row">
                                        <div class="icon">
                                            <img src="{{ asset('assets/app/icons/call.svg') }}" alt="call icon" />
                                        </div>
                                        <input type="number" wire:model='phone' placeholder="Phone Number"
                                            class="input_filed" />
                                        @error('phone')
                                            <p class="text-danger" style="font-size: 16px;">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="input_row">
                                        <div class="icon">
                                            <img src="{{ asset('assets/app/icons/mail-02.svg') }}" alt="user icon" />
                                        </div>
                                        <input type="email" wire:model='email' placeholder="Email Address"
                                            class="input_filed" />
                                        @error('email')
                                            <p class="text-danger" style="font-size: 16px;">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="input_row">
                                        <textarea wire:model='description' cols="30" rows="4" placeholder="Message"></textarea>
                                        @error('description')
                                            <p class="text-danger" style="font-size: 16px;">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div style="text-align: center;">
                                        @if (session()->has('message'))
                                            <div class="alert alert-success">
                                                {{ session('message') }}
                                            </div>
                                        @endif
                                    </div>
                                    <button type="submit" class="submit_btn">
                                        <span>{!! loadingStateWithText('storeData', 'Send Message') !!}</span>
                                    </button>
                                </form>
                            </div>
                            <img src="{{ asset('assets/app/images/contact/contact_form_shape.png') }}"
                                alt="line draw shape" class="contact_form_shape" />
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</div>
