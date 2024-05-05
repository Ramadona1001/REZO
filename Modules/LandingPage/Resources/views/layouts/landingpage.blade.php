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

    if(isset($setting['color_flag']) && $setting['color_flag'] == 'true')
    {
        $themeColor = 'custom-color';
    }
    else {
        $themeColor = $color;
    }

@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ env('APP_NAME') }}</title>
    <!-- Meta -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

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

    <!-- Favicon icon -->
    {{-- <link rel="icon" href="{{ $sup_logo.'/'. $adminSettings['company_favicon'] }}" type="image/x-icon" /> --}}
    <link rel="icon"
        href="{{ $sup_logo . '/' . (isset($company_favicon) && !empty($company_favicon) ? $company_favicon : 'favicon.png') }}"
        type="image/x-icon" />

    <link rel="stylesheet" type="text/css" href="{{ Module::asset('LandingPage:Resources/assets/new/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ Module::asset('LandingPage:Resources/assets/new/css/responsive.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.css" integrity="sha512-UTNP5BXLIptsaj5WdKFrkFov94lDx+eBvbKyoe1YAfjeRPC+gT5kyZ10kOHCfNZqEui1sxmqvodNUx3KbuYI/A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        #customers-testimonials .item {
	text-align: center;
	padding: 20px;
	margin-bottom: 50px;
	-webkit-transform: scale3d(0.8, 0.8, 1);
	transform: scale3d(0.8, 0.8, 1);
	-webkit-transition: all 0.3s ease-in-out;
	-moz-transition: all 0.3s ease-in-out;
	transition: all 0.3s ease-in-out;
}
#customers-testimonials .owl-item.active.center .item {
	opacity: 1;
	-webkit-transform: scale3d(1.0, 1.0, 1);
	transform: scale3d(1.0, 1.0, 1);
}
.owl-carousel .owl-item img {
	transform-style: preserve-3d;
	max-width: 100%;
	margin: 0 auto 17px;
}
#customers-testimonials.owl-carousel .owl-dots .owl-dot.active span, #customers-testimonials.owl-carousel .owl-dots .owl-dot:hover span {
	background: #4280bd;
	transform: translate3d(0px, -50%, 0px) scale(0.6);
}
#customers-testimonials.owl-carousel .owl-dots {
	display: inline-block;
	width: 100%;
	text-align: center;
}
#customers-testimonials.owl-carousel .owl-dots .owl-dot {
	display: inline-block;
	outline: none;
}
#customers-testimonials.owl-carousel .owl-dots .owl-dot span {
	background: #fff;
	display: inline-block;
	height: 20px;
	margin: 0 2px 5px;
	transform: translate3d(0px, -50%, 0px) scale(0.3);
	transform-origin: 50% 50% 0;
	transition: all 250ms ease-out 0s;
	width: 20px;
	border-radius: 100%;
}

        
        </style>
</head>

<body class="no-scroll-y">

    <div class="main-page-wrapper">

        <section>
            <div id="preloader">
                <div id="ctn-preloader" class="ctn-preloader">
                    <div class="animation-preloader">
                        <div class="spinner"></div>
                    </div>	
                </div>
            </div>
        </section>

        <div class="theme-main-menu theme-menu-one d-align-item">
            <div class="logo"><a href="{{ url('/') }}"><img src="{{ $logo . '/' . $settings['site_logo'] . '?' . time() }}" alt=""></a></div>
            <nav id="mega-menu-holder" class="navbar navbar-expand-lg">
                <div  class="ml-auto nav-container">
                    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="flaticon-setup"></i>
                    </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav">
                            <li class="nav-item active">
                                <a href="{{ url('/') }}" class="nav-link" >{{ $settings['home_title'] }}</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/#features') }}" class="nav-link" >{{ $settings['feature_title'] }}</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/#plans') }}" class="nav-link" >{{ $settings['plan_title'] }}</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/#testimonials') }}" class="nav-link" >{{ $settings['testimonial_title'] }}</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/#faqs') }}" class="nav-link" >{{ $settings['faq_title'] }}</a>
                            </li>

                            @if (is_array(json_decode($settings['menubar_page'])) || is_object(json_decode($settings['menubar_page'])))
                            <li class="nav-item dropdown position-relative">
                                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">{{ __("Pages") }}</a>
                                <ul class="dropdown-menu">
                                    @foreach (json_decode($settings['menubar_page']) as $key => $value)
                                        @if (isset($value->header) && $value->header == 'on' && isset($value->template_name))
                                        <li class="nav-item">
                                            <a href="{{ $value->template_name == 'page_content' ? route('custom.page', $value->page_slug) : $value->page_url }}" class="nav-link dropdown-toggle" data-toggle="dropdown">{{ $value->menubar_page_name }}</a>
                                        </li>
                                        @endif
                                    @endforeach
                                </ul> <!-- /.dropdown-menu -->
                            </li>
                            @endif
                            <li class="login-button" style=" gap: 10px; display: flex; ">
                                @if(!Auth::check())
                                    <a href="{{ route('login') }}">{{ __('Login') }}</a>
                                    <a href="{{ route('register') }}">{{ __('Register') }}</a>
                                @else
                                    <a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>
                                @endif
                            </li>
                    </ul>
                </div>
                </div> <!-- /.container -->
            </nav> <!-- /#mega-menu-holder -->
            
            


        </div>

        @if ($settings['home_status'] == 'on')
        <div id="theme-banner-four">
            <img src="{{ $logo . '/' . $settings['home_banner'] }}" alt="" class="screen-one wow fadeInRight animated" data-wow-duration="2s">
            {{-- <img src="{{ Module::asset('LandingPage:Resources/assets/new/images/home/2.png') }}" alt="" class="screen-two wow fadeInUp animated" data-wow-duration="2s"> --}}
            <img src="{{ Module::asset('LandingPage:Resources/assets/new/images/shape/shape-8.svg') }}" alt="" class="shape-one">
            <img src="{{ Module::asset('LandingPage:Resources/assets/new/images/shape/shape-9.svg') }}" alt="" class="shape-two">
            <img src="{{ Module::asset('LandingPage:Resources/assets/new/images/shape/shape-10.svg') }}" alt="" class="shape-three">
            <img src="{{ Module::asset('LandingPage:Resources/assets/new/images/shape/shape-11.svg') }}" alt="" class="shape-four">
            <div class="round-shape-one"></div>
            <div class="round-shape-two"></div>
            <div class="round-shape-three"></div>
            <div class="round-shape-four"></div>
            <div class="container">
                <div class="main-wrapper">
                    <div class="slogan wow fadeInDown animated" data-wow-delay="0.2s"><span>{{ $settings['home_offer_text'] }}</span></div>
                    <h1 class="main-title wow fadeInUp animated" data-wow-delay="0.4s">{{ $settings['home_heading'] }}</h1>
                    <p class="sub-title wow fadeInUp animated" data-wow-delay="0.9s">{{ $settings['home_description'] }}</p>
                    <ul class="button-group lightgallery">
                        @if ($settings['home_live_demo_link'])
                        <li><a href="{{ $settings['home_live_demo_link'] }}" class="more-button wow fadeInLeft animated" data-wow-delay="1.5s">{{ __('Live Demo') }} <i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
                        @endif

                        @if ($settings['home_buy_now_link'])
                        <li><a href="{{ $settings['home_buy_now_link'] }}" class="fancybox video-button video-button-one wow fadeInRight animated" data-wow-delay="1.5s">{{ __('Buy Now') }}</a></li>
                        @endif
                    </ul>
                </div> <!-- /.main-wrapper -->
            </div> <!-- /.container -->
        </div>
        

        <div class="trusted-partner">
            <div class="container">
                <h6 class="title">{{ __('Trusted by') }} <span>{{ $settings['home_trusted_by'] }}</span></h6>

                <div class="owl-carousel owl-theme customers-partners">
                    <div class="item"><a href="#"><img src="{{ Module::asset('LandingPage:Resources/assets/new/images/logo/envato.svg') }}" alt=""></a></div>
                    <div class="item"><a href="#"><img src="{{ Module::asset('LandingPage:Resources/assets/new/images/logo/envato.svg') }}" alt=""></a></div>
                    <div class="item"><a href="#"><img src="{{ Module::asset('LandingPage:Resources/assets/new/images/logo/envato.svg') }}" alt=""></a></div>
                    <div class="item"><a href="#"><img src="{{ Module::asset('LandingPage:Resources/assets/new/images/logo/envato.svg') }}" alt=""></a></div>
                    <div class="item"><a href="#"><img src="{{ Module::asset('LandingPage:Resources/assets/new/images/logo/envato.svg') }}" alt=""></a></div>
                </div>
            </div>
        </div>

        @endif


        @if ($settings['feature_status'] == 'on')
        <div class="our-service-sass hide-pr" id="features">
            <div class="container">
                <div class="theme-title-one text-center">
                    <div class="icon-box hide-pr">
                        <img src="{{ Module::asset('LandingPage:Resources/assets/new/images/shape/bg-shape1.svg') }}" alt="" class="bg-shape">
                        <img src="{{ Module::asset('LandingPage:Resources/assets/new/images/icon/icon23.svg') }}" alt="" class="icon">
                    </div>
                    <h4 class="main-title" style="font-size:30px;">
                        {{ $settings['feature_title'] }}
                        @if ($settings['feature_buy_now_link'])
                            <a href="{{ $settings['feature_buy_now_link'] }}" class="btn btn-warning btn-sm">{{ __('Buy Now') }}<i data-feather="lock" class="ms-2"></i></a>
                        @endif
                    </h4>
                    <h2 class="main-title">{!! $settings['feature_heading'] !!}</h2>
                    <p class="mt-3">{!! $settings['feature_description'] !!}</p>
                </div> <!-- /.theme-title-one -->
                
                <div class="inner-wrapper">
                    <div class="row">
                        @if (is_array(json_decode($settings['feature_of_features'], true)) || is_object(json_decode($settings['feature_of_features'], true)))
                            @foreach (json_decode($settings['feature_of_features'], true) as $key => $value)
                                <div class="col-lg-4 single-block" data-aos="fade-up">
                                    <div class="service-block">
                                        <span class="snow-dot"></span>
                                        <span class="snow-dot"></span>
                                        <span class="snow-dot"></span>
                                        <span class="snow-dot"></span>
                                        <span class="snow-dot"></span>
                                        <span class="snow-dot"></span>
                                        <span class="snow-dot"></span>
                                        <div class="hover-content"></div>
                                        <img src="{{ $logo . '/' . $value['feature_logo'] . '?' . time() }}" alt="">
                                        <h5 class="title"><a href="#">{!! $value['feature_heading'] !!}</a></h5>
                                        <p>{!! $value['feature_description'] !!}</p>
                                    </div> <!-- /.service-block -->
                                </div>
                            @endforeach
                        @endif
                    </div> <!-- /.row -->
                </div> <!-- /.inner-wrapper -->
            </div> <!-- /.container -->
        </div>
        @endif
        
        @if ($settings['feature_status'] == 'on')
            <div class="our-feature-sass">
                <div class="section-shape-one"></div>
                <div class="section-shape-two"><img src="{{ Module::asset('LandingPage:Resources/assets/new/images/shape/shape-18.svg') }}" alt=""></div>
                <img src="{{ Module::asset('LandingPage:Resources/assets/new/images/shape/shape-18.svg') }}" alt="" class="section-shape-three">
                <div class="section-shape-four"></div>
                <img src="{{ Module::asset('LandingPage:Resources/assets/new/images/shape/shape-20.svg') }}" alt="" class="section-shape-five">
                <img src="{{ Module::asset('LandingPage:Resources/assets/new/images/shape/shape-21.svg') }}" alt="" class="section-shape-six">
                <img src="{{ Module::asset('LandingPage:Resources/assets/new/images/shape/shape-22.svg') }}" alt="" class="section-shape-seven">
                <img src="{{ Module::asset('LandingPage:Resources/assets/new/images/shape/shape-19.svg') }}" alt="" class="section-shape-eight">
                <a href="#feature-sass" class="down-arrow scroll-target"><span><i class="flaticon-back"></i></span></a>
                <div class="feature-wrapper" id="feature-sass">
                    @if (is_array(json_decode($settings['other_features'], true)) || is_object(json_decode($settings['other_features'], true)))
                        @foreach (json_decode($settings['other_features'], true) as $key => $value)
                            <div class="single-feature-block">
                                <div class="container clearfix">
                                    <div class="row">
                                        <div class="col-6">
                                            <img src="{{ $logo . '/' . $value['other_features_image'] }}" alt="" class="main-shape" data-aos="fade-right" data-aos-delay="200">
                                        </div>
                                        <div class="col-6">
                                            <div class="text-box">
                                                <h2 class="main-title">{!! $value['other_features_heading'] !!}<b class="line"></b></h2>
                                                {!! $value['other_featured_description'] !!}
                                                <a href="{{ $value['other_feature_buy_now_link'] }}" class="read-more">{{ __('Buy Now') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        @endif

        @if ($settings['plan_status'])
        <div class="sass-our-pricing" id="plans">
            <div class="section-shape-one"><img src="{{ Module::asset('LandingPage:Resources/assets/new/images/shape/shape-18.svg') }}" alt=""></div>
            <img src="{{ Module::asset('LandingPage:Resources/assets/new/images/shape/shape-24.svg') }}" alt="" class="section-shape-two" data-aos="fade-right" data-aos-duration="3000">
            <img src="{{ Module::asset('LandingPage:Resources/assets/new/images/shape/shape-25.svg') }}" alt="" class="section-shape-three">
            <div class="section-shape-four"></div>
            <img src="{{ Module::asset('LandingPage:Resources/assets/new/images/shape/shape-26.svg') }}" alt="" class="section-shape-five">
            <img src="{{ Module::asset('LandingPage:Resources/assets/new/images/shape/shape-27.svg') }}" alt="" class="section-shape-six" data-aos="fade-left" data-aos-duration="3000">


            <div class="container">
                <div class="theme-title-one text-center hide-pr">
                    <div class="icon-box hide-pr">
                        <img src="{{ Module::asset('LandingPage:Resources/assets/new/images/shape/bg-shape4.svg') }}" alt="" class="bg-shape">
                        <img src="{{ Module::asset('LandingPage:Resources/assets/new/images/icon/icon26.svg') }}" alt="" class="icon">
                    </div>
                    <h2 class="main-title">{!! $settings['plan_heading'] !!}</h2>
                    <p>{!! $settings['plan_description'] !!}</p>
                </div> <!-- /.theme-title-one -->
                <div class="row no-gutters">
                    @php
                        $collection = \App\Models\Plan::orderBy('price', 'ASC')->get();
                    @endphp
                    @foreach ($collection as $key => $value)
                    <div class="col-lg-4">
                        <div class="single-pr-table free">
                            <div class="pr-header">
                                <div class="price">{{ !empty($admin_payment_setting['currency_symbol']) ? $admin_payment_setting['currency_symbol'] : $adminSettings['site_currency_symbol'] . $value->price }}</div>
                                <div class="package">{{ $value->duration }}</div>
                                <h4 class="title">{{ $value->name }}</h4>
                                <p>
                                    {!! $value->description !!}
                                </p>
                            </div> <!-- /.pr-header -->
                            <div class="pr-body">
                                <h3 class="feature">{{ __('Top Features') }}</h3>
                                <ul>
                                    <li>
                                        <div class="form-check text-start">
                                            <label class="form-check-label" for="customCheckc1">
                                                <i class="text-primary ti ti-circle-plus"></i>
                                                {{ $value->max_users == -1 ? 'Unlimited' : $value->max_users }}
                                                {{ __('User') }}</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="form-check text-start">
                                            <i class="text-primary ti ti-circle-plus"></i>
                                            <label class="form-check-label"
                                                for="customCheckc1">{{ $value->max_employees == -1 ? 'Unlimited' : $value->max_employees }}
                                                {{ __('Employees') }}</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="form-check text-start">
                                            <i class="text-primary ti ti-circle-plus"></i>
                                            <label class="form-check-label"
                                                for="customCheckc1">{{ $value->storage_limit == -1 ? __('Lifetime') : $value->storage_limit }}
                                                {{ __('MB Storage') }}</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="form-check text-start">
                                            <i class="text-primary ti ti-circle-plus"></i>
                                            <label class="form-check-label"
                                                for="customCheckc1">{{ $value->enable_chatgpt == 'on' ? __('Enable Chat GPT') : __('Disable Chat GPT') }}</label>
                                        </div>
                                    </li>
                                </ul>
                            </div> <!-- /.pr-body -->
                            <div class="pr-footer">
                                <a href="{{ route('register') }}" class="upgrade-button">{{ __('Start with Starter') }}</a>
                            </div> <!-- /.pr-footer -->
                        </div> <!-- /.single-pr-table -->
                    </div>
                    @endforeach
                </div>
            </div> <!-- /.container -->
        </div>
        @endif

        @if ($settings['testimonials_status'] == 'on')
        
        <section class="testimonials">
            <div class="container">
        
              <div class="row">
                <div class="col-sm-12">
                  <div class="container-fluid px-3 px-sm-5 my-5 text-center">
                    <h2 class="main-title">{!! $settings['testimonials_heading'] !!}</h2>
                    <p>{!! $settings['testimonials_description'] !!}</p>
                  </div>
                  <div id="customers-testimonials" class="owl-carousel">
        
                    <!--TESTIMONIAL 1 -->
                    @if (is_array(json_decode($settings['testimonials'])) || is_object(json_decode($settings['testimonials'])))
                        @foreach (json_decode($settings['testimonials']) as $key => $value)
                            <div class="item" style="width:100%;background: whitesmoke;padding: 25px;border-radius: 10px;">
                            <div class="">
                                @if (isset($value->testimonials_user_avtar))
                                    <img src="{{ $logo . '/' . $value->testimonials_user_avtar }}" class="wid-40 rounded-circle me-3" style="width:200px;">
                                @endif
                                <span style="font-weight:bold;">
                                    <b class="fw-bold d-block">{{ $value->testimonials_user }}</b>
                                    {{ $value->testimonials_designation }}
                                </span>
                                <hr>
                                <p>{{ $value->testimonials_description }}</p>
                                <h6 class="name">{{ $value->testimonials_title }}</h6>
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

        @if ($settings['faq_status'] == 'on')
        <div class="theme-title-one text-center hide-pr" style="margin-top:50px;" id="faqs">
            <h2 class="main-title">{{ $settings['faq_title'] }}</h2>
            <p>{!! $settings['faq_heading'] !!}</p>
            <p>{!! $settings['faq_description'] !!}</p>
        </div>
        <div class="sass-faq-section">

            <div class="section-shape-one"><img src="{{ Module::asset('LandingPage:Resources/assets/new/images/shape/shape-18.svg') }}" alt=""></div>
            <img src="{{ Module::asset('LandingPage:Resources/assets/new/images/shape/shape-26.svg') }}" alt="" class="section-shape-two">
            <img src="{{ Module::asset('LandingPage:Resources/assets/new/images/shape/shape-29.svg') }}" alt="" class="section-shape-three">
            <img src="{{ Module::asset('LandingPage:Resources/assets/new/images/shape/shape-30.svg') }}" alt="" class="section-shape-four">
            <div class="container">
               
                <div class="faq-tab-wrapper">
                    <div class="tab-content">
                        <div id="payment" class="tab-pane fade show active">
                            <div class="row">
                                @if (is_array(json_decode($settings['faqs'], true)) || is_object(json_decode($settings['faqs'], true)))
                                    @foreach (json_decode($settings['faqs'], true) as $key => $value)
                                        <div class="col-12">
                                            <div class="panel-group theme-accordion" id="accordion{{$key}}">
                                                <div class="faq-panel">
                                                    <div class="panel">
                                                        <div class="panel-heading active-panel">
                                                            <h6 class="panel-title">
                                                            <a data-toggle="collapse" data-parent="#accordion{{$key}}" href="#collapse{{$key}}">{!! $value['faq_questions'] !!}</a>
                                                            </h6>
                                                        </div>
                                                        <div id="collapse{{$key}}" class="panel-collapse collapse">
                                                            <div class="panel-body">
                                                                <p>{!! $value['faq_answer'] !!}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div> <!-- /.row -->
                        </div>
                    </div> <!-- /.tab-content -->
                </div> <!-- /.faq-tab-wrapper -->


                <a href="#footer" class="down-button scroll-target"><i class="fa fa-angle-down" aria-hidden="true"></i></a>
            </div> <!-- /.container -->
        </div>
        @endif

        <footer class="theme-footer-one" id="footer">
            <div class="shape-one" data-aos="zoom-in-right"></div>
            <img src="{{ Module::asset('LandingPage:Resources/assets/new/images/shape/shape-67.svg') }}" alt="" class="shape-two">
            <div class="top-footer">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-4 col-sm-6 col-12 about-widget" data-aos="fade-up">
                            <a href="{{ url('/') }}" class="logo"><img style="width:70px;" src="{{ $logo . '/' . $settings['site_logo'] . '?' . time() }}" alt=""></a>
                            <p>{!! $settings['site_description'] !!}</p>
                        </div> <!-- /.about-widget -->
                        <div class="col-lg-4 col-lg-3 col-sm-6 col-12 footer-list" data-aos="fade-up">
                            <h5 class="title">{{ __('Our Pages') }}</h5>
                            <ul>
                                @if (is_array(json_decode($settings['menubar_page'])) || is_object(json_decode($settings['menubar_page'])))
                                    @foreach (json_decode($settings['menubar_page']) as $key => $value)
                                        @if (isset($value->footer) && $value->footer == 'on' && $value->header == 'off' && isset($value->template_name))
                                            <li><a
                                                    href="{{ $value->template_name == 'page_content' ? route('custom.page', $value->page_slug) : $value->page_url }}">{{ $value->menubar_page_name }}</a>
                                            </li>
                                        @endif
                                        @if (isset($value->footer) && $value->footer == 'on' && $value->header == 'on' && isset($value->template_name))
                                            <li><a
                                                    href="{{ $value->template_name == 'page_content' ? route('custom.page', $value->page_slug) : $value->page_url }}">{{ $value->menubar_page_name }}</a>
                                            </li>
                                        @endif
                                    @endforeach
                                @endif
                            </ul>
                        </div> <!-- /.footer-recent-post -->
                        
                        <div class="col-lg-4 col-lg-2 col-sm-6 col-12 footer-information" data-aos="fade-up">
                            <h5 class="title">{!! $settings['joinus_heading'] !!}</h5>
                            <p>{!! $settings['joinus_description'] !!}</p>
                            @if ($settings['joinus_status'] == 'on')
                                <div class="ftr-col ftr-subscribe">
                                    <form method="post" action="{{ route('join_us_store') }}">
                                        @csrf
                                        <input type="text" name="email" placeholder="{{__('Type your email address')}}..." required class="form-control">
                                        <button type="submit" class="btn btn-dark rounded-pill mt-3">{{ __('Join Us!') }}</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div> <!-- /.row -->
                </div> <!-- /.container -->
            </div> <!-- /.top-footer -->
            
            <div class="container">
                <div class="bottom-footer">
                    <div class="clearfix">
                        <p>&copy;{{ date(' Y') }}
                            {{ App\Models\Utility::getValByName('footer_text') ? App\Models\Utility::getValByName('footer_text') : config('app.name', 'Resource Managment') }}</p>
                        <ul>
                            @include('landingpage::layouts.buttons')
                        </ul>
                    </div>
                </div> <!-- /.bottom-footer -->
            </div>
        </footer>
        
        <button class="scroll-top tran3s">
            <i class="fa fa-angle-up" aria-hidden="true"></i>
        </button>

    </div>



    <script src="{{ Module::asset('LandingPage:Resources/assets/new/vendor/jquery.2.2.3.min.js') }}"></script>
    <script src="{{ Module::asset('LandingPage:Resources/assets/new/vendor/popper.js/popper.min.js') }}"></script>
    <script src="{{ Module::asset('LandingPage:Resources/assets/new/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ Module::asset('LandingPage:Resources/assets/new/vendor/mega-menu/assets/js/custom.js') }}"></script>
    <script src="{{ Module::asset('LandingPage:Resources/assets/new/vendor/aos-next/dist/aos.js') }}"></script>
    <script src="{{ Module::asset('LandingPage:Resources/assets/new/vendor/WOW-master/dist/wow.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ Module::asset('LandingPage:Resources/assets/new/vendor/jquery.appear.js') }}"></script>
    <script src="{{ Module::asset('LandingPage:Resources/assets/new/vendor/jquery.countTo.js') }}"></script>
    <script src="{{ Module::asset('LandingPage:Resources/assets/new/vendor/fancybox/dist/jquery.fancybox.min.js') }}"></script>
    <script src="{{ Module::asset('LandingPage:Resources/assets/new/js/theme.js') }}"></script>

    


@stack('custom-scripts')
@if ($get_cookie['enable_cookie'] == 'on')
    @include('layouts.cookie_consent')
@endif
</body>

</html>
