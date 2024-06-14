@php
    use App\Models\Utility;
    $settings = \Modules\LandingPage\Entities\LandingPageSetting::settings();
    $logo = Utility::get_file('uploads/landing_page_image');
    $sup_logo = Utility::get_file('uploads/logo');

    $metatitle = isset($adminSettings['meta_title']) ? $adminSettings['meta_title'] : '';
    $metadesc = isset($adminSettings['meta_desc']) ? $adminSettings['meta_desc'] : '';
    $meta_image = \App\Models\Utility::get_file('uploads/meta/');
    $meta_logo = isset($adminSettings['meta_image']) ? $adminSettings['meta_image'] : '';
    $get_cookie = \App\Models\Utility::getCookieSetting();

    $setting = \App\Models\Utility::colorset();

    $SITE_RTL = $adminSettings['SITE_RTL'] ? $adminSettings['SITE_RTL'] : '';

    $color = !empty($setting['color']) ? $setting['color'] : 'theme-3';

    if (isset($setting['color_flag']) && $setting['color_flag'] == 'true') {
        $themeColor = 'custom-color';
    } else {
        $themeColor = $color;
    }

@endphp

<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <!-- Meta Tags -->
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="title" content="{{ $metatitle }}">
    <meta name="description" content="{{ $metadesc }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ env('APP_URL') }}">
    <meta property="og:title" content="{{ $metatitle }}">
    <meta property="og:description" content="{{ $metadesc }}">
    <meta property="og:image"
        content="{{ isset($meta_logo) && !empty(asset('storage/uploads/meta/' . $meta_logo)) ? asset('storage/uploads/meta/' . $meta_logo) : 'hrmgo.png' }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ env('APP_URL') }}">
    <meta property="twitter:title" content="{{ $metatitle }}">
    <meta property="twitter:description" content="{{ $metadesc }}">
    <meta property="twitter:image"
        content="{{ isset($meta_logo) && !empty(asset('storage/uploads/meta/' . $meta_logo)) ? asset('storage/uploads/meta/' . $meta_logo) : 'hrmgo.png' }}">
    <!-- Page Title -->
    <title>{{ env('APP_NAME') }}</title>
    <!-- Favicon Icon -->
    <link rel="icon"
        href="{{ $sup_logo . '/' . (isset($company_favicon) && !empty($company_favicon) ? $company_favicon : 'favicon.png') }}"
        type="image/x-icon" />
    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ Module::asset('LandingPage:Resources/assets/new') }}/rtl/css/bootstrap.min.css" />
    <link rel="stylesheet"
        href="{{ Module::asset('LandingPage:Resources/assets/new') }}/rtl/css/owlCarousel.min.css" />
    <link rel="stylesheet"
        href="{{ Module::asset('LandingPage:Resources/assets/new') }}/rtl/css/fontawesome.min.css" />
    <link rel="stylesheet" href="{{ Module::asset('LandingPage:Resources/assets/new') }}/rtl/css/flaticon.css" />
    <link rel="stylesheet" href="{{ Module::asset('LandingPage:Resources/assets/new') }}/rtl/css/animate.css" />
    <link rel="stylesheet" href="{{ Module::asset('LandingPage:Resources/assets/new') }}/rtl/css/style.css" />
</head>

<body class="st-blue-color">
    <div id="st-preloader">
        <div class="st-preloader-wave"></div>
        <div class="st-preloader-wave"></div>
        <div class="st-preloader-wave"></div>
        <div class="st-preloader-wave"></div>
        <div class="st-preloader-wave"></div>
    </div>
    <header class="st-header st-style1 st-sticky-menu st-color1">
        <div class="st-main-header">
            <div class="container">
                <div class="st-main-header-in">
                    <div class="st-site-branding">
                        <a href="{{ url('/') }}" class="st-logo-link"><img style="width: 50px;"
                                src="{{ $logo . '/' . $settings['site_logo'] . '?' . time() }}" alt="demo"></a>
                    </div>
                    <!-- For Site Title -->
                    <!-- <span class="st-site-title">
            <a href="index.html">Logo</a>
          </span> -->
                    <div class="st-nav-wrap st-fade-down">
                        <div class="st-nav-toggle st-style1">
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        <nav class="st-nav st-desktop-nav">
                            <ul class="st-nav-list onepage-nav">
                                <li class="smooth-scroll"><a href="{{ url('/') }}"
                                        class="nav-link">{{ $settings['home_title'] }}</a></li>
                                <li><a class="smooth-scroll" href="{{ url('/#features') }}"
                                        class="nav-link">{{ $settings['feature_title'] }}</a></li>
                                <li><a class="smooth-scroll" href="{{ url('/#plans') }}"
                                        class="nav-link">{{ $settings['plan_title'] }}</a></li>
                                <li><a class="smooth-scroll" href="{{ url('/#testimonials') }}"
                                        class="nav-link">{{ $settings['testimonial_title'] }}</a></li>
                                <li><a class="smooth-scroll" href="{{ url('/#faqs') }}"
                                        class="nav-link">{{ $settings['faq_title'] }}</a></li>
                                <li><a class="smooth-scroll" href="#price" class="smooth-scroll">Price</a></li>

                                @if (is_array(json_decode($settings['menubar_page'])) || is_object(json_decode($settings['menubar_page'])))
                                    <li class="st-has-children"><a href="#blog"
                                            class="smooth-scroll">{{ __('Pages') }}</a>
                                        <ul>
                                            @foreach (json_decode($settings['menubar_page']) as $key => $value)
                                                @if (isset($value->header) && $value->header == 'on' && isset($value->template_name))
                                                    <li><a
                                                            href='{{ $value->template_name == 'page_content' ? route('custom.page', $value->page_slug) : $value->page_url }}'>{{ $value->menubar_page_name }}</a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </li>
                                @endif
                                @if (!Auth::check())
                                    <li><a href="{{ route('login') }}">{{ __('Login') }}</a></li>
                                    <li><a href="{{ route('register') }}">{{ __('Register') }}</a></li>
                                @else
                                    <li><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
                                @endif
                            </ul>
                        </nav><!-- .st-nav -->
                    </div><!-- .st-nav-wrap -->
                </div>
            </div>
        </div>
    </header>

    <div class="st-content">
        <!-- Start Hero Slider -->
        <div class="st-hero-slide st-style2 st-type1 st-flex" id="home">
            <div class="container">
                <div class="st-hero-text st-style1 st-color1">
                    <h1 class="st-hero-title">{{ $settings['home_offer_text'] }}</h1>
                    <div class="st-hero-subtitle" style="margin-bottom:10px;">
                        {{ $settings['home_heading'] }}
                    </div>
                    <div class="st-hero-subtitle" style="width: 50%;">
                        {{ $settings['home_description'] }}
                    </div>

                    <div class="d-flex" style="gap:10px;">
                        @if ($settings['home_live_demo_link'])
                            <div class="st-btn-group st-style1">
                                <a href="{{ $settings['home_live_demo_link'] }}"
                                    class="st-btn st-style1 st-color1">{{ __('Live Demo') }}</a>
                            </div>
                        @endif

                        @if ($settings['home_buy_now_link'])
                            <div class="st-btn-group st-style1">
                                <a href="{{ $settings['home_buy_now_link'] }}"
                                    class="st-btn st-style1 st-color1">{{ __('Buy Now') }}</a>
                            </div>
                        @endif
                    </div>


                </div>
            </div>
            <div class="st-hero-img">
                <img src="{{ $logo . '/' . $settings['home_banner'] }}" alt="demo">
            </div>
            <div class="st-circla-animation">
                <div class="st-circle st-circle-first"></div>
                <div class="st-circle st-circle-second"></div>
            </div>
        </div>
        <!-- End Hero Slider -->

        @if ($settings['feature_status'] == 'on')
            <section class="st-service-section st-section-top" id="service">
                <div class="container">
                    <div class="st-section-heading st-style2 text-center">
                        <h2>{{ $settings['feature_title'] }}</h2>
                        <div class="st-seperator">
                            <div class="st-seperator-left-bar wow fadeInLeft" data-wow-duration="1s"
                                data-wow-delay="0.2s"></div>
                            <img src="{{ Module::asset('LandingPage:Resources/assets/new') }}/rtl/img/light-img/seperator-icon1.png"
                                alt="demo" class="st-seperator-icon">
                            <div class="st-seperator-right-bar wow fadeInRight" data-wow-duration="1s"
                                data-wow-delay="0.2s"></div>
                        </div>
                        <p>{!! $settings['feature_heading'] !!}</p>
                    </div>
                </div>
                <div class="st-owl-controler3-hover">
                    <div class="container">
                        <div class="st-service-carousel owl-carousel st-style2 st-owl-controler3">
                            @if (is_array(json_decode($settings['feature_of_features'], true)) ||
                                    is_object(json_decode($settings['feature_of_features'], true)))
                                @foreach (json_decode($settings['feature_of_features'], true) as $key => $value)
                                    <div class="st-image-box st-style1 text-center wow fadeIn"
                                        data-wow-duration="0.8s" data-wow-delay="0.2s">
                                        <a href="#" class="st-image"><img
                                                src="{{ $logo . '/' . $value['feature_logo'] . '?' . time() }}"
                                                alt="demo"></a>
                                        <div class="st-image-box-info">
                                            <h3 class="st-image-box-title"><a
                                                    href="#">{!! $value['feature_heading'] !!}</a></h3>
                                            <div class="st-image-box-text">{!! $value['feature_description'] !!}</div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif

                        </div>
                    </div>
                </div>
                
            </section>

        @endif

        @if ($settings['feature_status'] == 'on')
            <section class="st-service-section st-section-top" id="service">
                <div class="container">
                    <div class="st-section-heading st-style2 text-center">
                        <h2>{{ __('Other Features') }}</h2>
                        <div class="st-seperator">
                            <div class="st-seperator-left-bar wow fadeInLeft" data-wow-duration="1s"
                                data-wow-delay="0.2s"></div>
                            <img src="{{ Module::asset('LandingPage:Resources/assets/new') }}/rtl/img/light-img/seperator-icon1.png"
                                alt="demo" class="st-seperator-icon">
                            <div class="st-seperator-right-bar wow fadeInRight" data-wow-duration="1s"
                                data-wow-delay="0.2s"></div>
                        </div>
                        <p>{!! $settings['feature_heading'] !!}</p>
                    </div>
                </div>
                <div class="st-owl-controler3-hover">
                    <div class="container">
                        <div class="st-service-carousel owl-carousel st-style2 st-owl-controler3">
                            @if (is_array(json_decode($settings['other_features'], true)) ||
                                    is_object(json_decode($settings['other_features'], true)))
                                @foreach (json_decode($settings['other_features'], true) as $key => $value)
                                    <div class="st-image-box st-style1 text-center wow fadeIn"
                                        data-wow-duration="0.8s" data-wow-delay="0.2s">
                                        <a href="#" class="st-image"><img style="    height: 250px;"
                                                src="{{ $logo . '/' . $value['other_features_image'] }}"
                                                alt="demo"></a>
                                        <div class="st-image-box-info">
                                            <h3 class="st-image-box-title"><a href="#">
                                                    {!! $value['other_features_heading'] !!}</a></h3>
                                            <div class="st-image-box-text">{!! $value['other_featured_description'] !!}</div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif

                        </div>
                    </div>
                </div>
            </section>
        @endif

        @if ($settings['discover_status'] == 'on')
            <section class="st-service-section st-section-top" id="service">
                <div class="container">
                    <div class="st-section-heading st-style2 text-center">
                        <h2>{!! $settings['discover_heading'] !!}</h2>
                        <div class="st-seperator">
                            <div class="st-seperator-left-bar wow fadeInLeft" data-wow-duration="1s"
                                data-wow-delay="0.2s"></div>
                            <img src="{{ Module::asset('LandingPage:Resources/assets/new') }}/rtl/img/light-img/seperator-icon1.png"
                                alt="demo" class="st-seperator-icon">
                            <div class="st-seperator-right-bar wow fadeInRight" data-wow-duration="1s"
                                data-wow-delay="0.2s"></div>
                        </div>
                        <p>{!! $settings['discover_description'] !!}</p>
                    </div>
                </div>
                <div class="st-owl-controler3-hover">
                    <div class="container">
                        <div class="st-service-carousel owl-carousel st-style2 st-owl-controler3">
                            @if (is_array(json_decode($settings['discover_of_features'], true)) ||
                                    is_object(json_decode($settings['discover_of_features'], true)))
                                @foreach (json_decode($settings['discover_of_features'], true) as $key => $value)
                                    <div class="st-image-box st-style1 text-center wow fadeIn"
                                        data-wow-duration="0.8s" data-wow-delay="0.2s">
                                        <a href="@if ($settings['discover_live_demo_link']) {{ $settings['discover_live_demo_link'] }} @else {{ '#' }} @endif"
                                            class="st-image"><img style="    height: 250px;"
                                                src="{{ $logo . '/' . $value['discover_logo'] }}" alt="demo"></a>
                                        <div class="st-image-box-info">
                                            <h3 class="st-image-box-title"><a href="#">
                                                    {!! $value['discover_heading'] !!}</a></h3>
                                            <div class="st-image-box-text">{!! $value['discover_description'] !!}</div>
                                        </div>
                                        @if ($settings['discover_buy_now_link'])
                                            <a href="{{ $settings['discover_buy_now_link'] }}"
                                                class="st-btn st-style1 st-size1 st-color2 mb-3">{{ __('Buy Now ') }}</a>
                                        @endif
                                    </div>
                                @endforeach
                            @endif

                        </div>
                    </div>
                </div>
            </section>
        @endif

        @if ($settings['screenshots_status'] == 'on')
            <div class="st-project-wrap st-section-top" id="portfolio">
                <div class="container">
                    <div class="st-section-heading st-style2 text-center">
                        <h2>{!! $settings['screenshots_heading'] !!}</h2>

                        <div class="st-seperator">
                            <div class="st-seperator-left-bar wow fadeInLeft" data-wow-duration="1s"
                                data-wow-delay="0.2s"></div>
                            <img src="{{ Module::asset('LandingPage:Resources/assets/new') }}/rtl/img/light-img/seperator-icon1.png"
                                alt="demo" class="st-seperator-icon">
                            <div class="st-seperator-right-bar wow fadeInRight" data-wow-duration="1s"
                                data-wow-delay="0.2s"></div>
                        </div>
                        <p>{!! $settings['screenshots_description'] !!}</p>
                    </div>
                </div>
                <div class="st-project st-project-carousel owl-carousel st-style1 st-owl-controler1">
                    @if (is_array(json_decode($settings['screenshots'], true)) || is_object(json_decode($settings['screenshots'], true)))
                        @foreach (json_decode($settings['screenshots'], true) as $value)
                            <a href="#" class="st-single-project st-bg wow fadeIn" data-wow-duration="0.8s"
                                data-wow-delay="0.2s" data-src="{{ $logo . '/' . $value['screenshots'] }}">
                                <div class="st-project-meta">
                                    <h3>{!! $value['screenshots_heading'] !!}</h3>
                                </div>
                            </a>
                        @endforeach
                    @endif
                </div>
            </div>
        @endif

        @if ($settings['faq_status'] == 'on')
            <section class="st-skill-wrap st-section-top">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="st-vertical-middle">
                                <div class="st-vertical-middle-in wow fadeInLeft" data-wow-duration="0.8s"
                                    data-wow-delay="0.2s">
                                    <div class="st-skill-img text-center">
                                        <img src="{{ Module::asset('LandingPage:Resources/assets/new') }}/rtl/img/light-img/skill-img.png"
                                            alt="demo">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="st-section-heading st-style2 st-type2">
                                <h2>{!! $settings['faq_heading'] !!}</h2>
                                <p>{!! $settings['faq_description'] !!}</p>
                            </div>

                            <div class="accordion" id="faqAccordion">
                                @if (is_array(json_decode($settings['faqs'], true)) || is_object(json_decode($settings['faqs'], true)))
                                    @foreach (json_decode($settings['faqs'], true) as $key => $value)
                                        <div class="card">
                                            <div class="card-header" id="heading{{ $key }}">
                                                <h5 class="mb-0">
                                                    <button class="btn btn-link" type="button"
                                                        data-toggle="collapse" data-target="#faq{{ $key }}"
                                                        aria-expanded="true" aria-controls="faq{{ $key }}">
                                                        {!! $value['faq_questions'] !!}
                                                    </button>
                                                </h5>
                                            </div>
                                            <div id="faq{{ $key }}" class="collapse show"
                                                aria-labelledby="heading{{ $key }}"
                                                data-parent="#faqAccordion">
                                                <div class="card-body">
                                                    {!! $value['faq_answer'] !!}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </section>
        @endif

        @if ($settings['plan_status'])
            <section class="st-pricing-wrap st-section" id="price">
                <div class="container">
                    <div class="st-section-heading st-style2 text-center">
                        <h2>{!! $settings['plan_heading'] !!}</h2>
                        <div class="st-seperator">
                            <div class="st-seperator-left-bar wow fadeInLeft" data-wow-duration="1s"
                                data-wow-delay="0.2s">
                            </div>
                            <img src="assets/img/light-img/seperator-icon1.png" alt="demo"
                                class="st-seperator-icon">
                            <div class="st-seperator-right-bar wow fadeInRight" data-wow-duration="1s"
                                data-wow-delay="0.2s">
                            </div>
                        </div>
                        <p>{!! $settings['plan_description'] !!}</p>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        @php
                            $collection = \App\Models\Plan::orderBy('price', 'ASC')->get();
                            $admin_payment_setting = Utility::getAdminPaymentSetting();
                        @endphp
                        @foreach ($collection as $key => $value)
                            <div class="col-lg-4">
                                <div class="st-price-card text-center wow fadeInUp" data-wow-duration="0.8s"
                                    data-wow-delay="0.2s">
                                    <div class="st-price-card-img"><img
                                            src="{{ Module::asset('LandingPage:Resources/assets/new') }}/rtl/img/blue-img/price-img1.png"
                                            alt="demo">
                                    </div>
                                    <h3 class="st-price-card-title">{{ $value->name }}</h3>
                                    <div class="st-price">
                                        <h3>{{ isset($admin_payment_setting['currency_symbol']) ? $admin_payment_setting['currency_symbol'] : '$' }}{{ intval($value->price) }}
                                        </h3>
                                    </div>
                                    <ul class="st-price-card-feature st-mp0">
                                      {!! $value->description !!}
                                    </ul>
                                    <div class="st-price-card-btn">
                                        <a href="{{ route('register',['lang'=>'en','plan'=>$value->id]) }}"
                                            class="st-btn st-style1 st-size1 st-color3">{{ __('Start The Plan') }}</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
        <!-- End Pricing Plan -->

        <!-- Start Client Section -->
        <div class="st-client-wrap st-section">
            <div class="container">
                <div class="st-client-carousel owl-carousel">
                    @foreach (explode(',', $settings['home_logo']) as $k => $home_logo)
                        <div class="st-client-logo st-flex wow fadeIn" data-wow-duration="0.8s"
                            data-wow-delay="0.2s">
                            <img src="{{ $logo . '/' . $home_logo }}" alt="demo">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- End Client Section -->

        <!-- Start Testimonial Section -->
        @if ($settings['testimonials_status'] == 'on')
            <section class="st-testimonial-wrap st-section st-gray-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="st-testimonial-right-img st-flex wow fadeInLeft" data-wow-duration="0.8s"
                                data-wow-delay="0.2s">
                                <img src="{{ Module::asset('LandingPage:Resources/assets/new') }}/rtl/img/blue-img/testimonial-img.png"
                                    alt="demo">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="st-vertical-middle">
                                <div class="st-vertical-middle-in">
                                    <div class="st-section-heading st-style1">
                                        <h3>{!! $settings['testimonials_heading'] !!}</h3>
                                        <h2>{!! $settings['testimonials_description'] !!}</h2>
                                    </div>
                                    <div class="st-testimonial-slider owl-carousel st-owl-controler4">
                                        @if (is_array(json_decode($settings['testimonials'])) || is_object(json_decode($settings['testimonials'])))
                                            @foreach (json_decode($settings['testimonials']) as $key => $value)
                                                <div class="st-single-testimonial">
                                                    <div class="st-testimonial-quote st-flex"><i
                                                            class="fas fa-quote-right"></i></div>
                                                    <div class="st-testimonial-text">
                                                        {{ $value->testimonials_description }}</div>
                                                    <div class="st-testimonial-meta">
                                                        <h3>{{ $value->testimonials_title }}</h3>
                                                        <p>{{ $value->testimonials_user }}</p>
                                                        <p>{{ $value->testimonials_designation }}</p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif
        <!-- End Testimonial Section -->

        <!-- Start News Letter Section -->
        @if ($settings['joinus_status'] == 'on')
        <section class="st-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="st-newsletter-wrap">
                            <div class="st-left-newsletter">
                                <div class="st-section-heading st-style1 st-type1">
                                    <h3>{!! $settings['joinus_heading'] !!}</h3>
                                    <h2>{!! $settings['joinus_description'] !!}</h2>
                                </div>
                                <div class="st-newsletter">
                                    <form class="mailchimp st-subscribe-form"
                                        action="{{ route('join_us_store') }}">
                                        @csrf
                                        <input type="email" name="subscribe" id="subscriber-email"
                                            placeholder="Enter your Email">
                                        <button type="submit" id="subscribe-button" class="st-newsletter-btn"><i
                                                class="flaticon-plane"></i></button>
                                        <!-- SUBSCRIPTION SUCCESSFUL OR ERROR MESSAGES -->
                                        <h5 class="subscription-success"> .</h5>
                                        <h5 class="subscription-error"> .</h5>
                                        <label class="subscription-label" for="subscriber-email"></label>
                                    </form>
                                </div>
                            </div>
                            <div class="st-right-newsletter">
                                <div class="st-newsletter-img wow fadeInRight" data-wow-duration="0.8s"
                                    data-wow-delay="0.2s">
                                    <img src="{{ Module::asset('LandingPage:Resources/assets/new') }}/rtl/img/blue-img/news-letter-img.png"
                                        alt="demo">
                                    <div class="st-bard-animation">
                                        <div class="st-bard-animation1"><img
                                                src="{{ Module::asset('LandingPage:Resources/assets/new') }}/rtl/img/blue-img/bard1.png"
                                                alt="demo"></div>
                                        <div class="st-bard-animation2"><img
                                                src="{{ Module::asset('LandingPage:Resources/assets/new') }}/rtl/img/blue-img/bard2.png"
                                                alt="demo"></div>
                                        <div class="st-bard-animation3"><img
                                                src="{{ Module::asset('LandingPage:Resources/assets/new') }}/rtl/img/blue-img/bard3.png"
                                                alt="demo"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @endif




        <footer class="st-site-footer ">
            <div class="st-main-footer text-center">
                <div class="container">
                    <div class="st-footer-social">
                        <ul class="st-footer-social-btn st-flex st-mp0">
                            @include('landingpage::layouts.buttons')
                        </ul>
                    </div>
                </div>
            </div>
            <div class="st-copyright text-center">
                <div class="st-copyright-text">
                    {{ App\Models\Utility::getValByName('footer_text') ? App\Models\Utility::getValByName('footer_text') : config('app.name', 'Resource Managment') }}
                </div>
            </div>
        </footer>


        <!-- Start Video Popup -->
        <div class="st-video-popup">
            <div class="st-video-popup-overlay"></div>
            <div class="st-video-popup-content">
                <div class="st-video-popup-layer"></div>
                <div class="st-video-popup-container">
                    <div class="st-video-popup-align">
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" src="about:blank"></iframe>
                        </div>
                    </div>
                    <div class="st-video-popup-close"></div>
                </div>
            </div>
        </div>
        <!-- End Video Popup -->
        <!-- Scripts -->
        <script src="{{ Module::asset('LandingPage:Resources/assets/new') }}/rtl/js/vendor/modernizr-3.5.0.min.js"></script>
        <script src="{{ Module::asset('LandingPage:Resources/assets/new') }}/rtl/js/vendor/jquery-1.12.4.min.js"></script>
        <script src="{{ Module::asset('LandingPage:Resources/assets/new') }}/rtl/js/mailchimp.min.js"></script>
        <script src="{{ Module::asset('LandingPage:Resources/assets/new') }}/rtl/js/owlCarousel.min.js"></script>
        <script src="{{ Module::asset('LandingPage:Resources/assets/new') }}/rtl/js/tamjid-counter.min.js"></script>
        <script src="{{ Module::asset('LandingPage:Resources/assets/new') }}/rtl/js/wow.min.js"></script>
        <script src="{{ Module::asset('LandingPage:Resources/assets/new') }}/rtl/js/main.js"></script>
</body>

</html>
