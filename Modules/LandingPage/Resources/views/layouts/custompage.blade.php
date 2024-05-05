@php
    use App\Models\Utility;
    $settings = \Modules\LandingPage\Entities\LandingPageSetting::settings();
    $logo  =  Utility::get_file('uploads/landing_page_image');
    $sup_logo  =  Utility::get_file('uploads/logo');
    $adminSettings = Utility::settingsById(1);

    $getseo= App\Models\Utility::getSeoSetting();
    $metatitle =  isset($getseo['meta_title']) ? $getseo['meta_title'] :'';
    $metadesc= isset($getseo['meta_desc'])?$getseo['meta_desc']:'';
    $meta_image = \App\Models\Utility::get_file('uploads/meta/');
    $meta_logo = isset($getseo['meta_image'])?$getseo['meta_image']:'';

    $setting = \App\Models\Utility::colorset();
    $SITE_RTL = Utility::getValByName('SITE_RTL');
    $color = (!empty($setting['color'])) ? $setting['color'] : 'theme-3';
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
                                    <a href="{{ __('Register') }}">{{ __('Register') }}</a>
                                @else
                                    <a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>
                                @endif
                            </li>
                    </ul>
                </div>
                </div> <!-- /.container -->
            </nav> <!-- /#mega-menu-holder -->
        </div>

        <div class="solid-inner-banner">
            <h2 class="page-title">{!! $page['menubar_page_name'] !!}</h2>
            <ul class="page-breadcrumbs mb-5">
                <li><a href="{{ url('/') }}">{{ $settings['home_title'] }}</a></li>
                <li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
                <li>{!! $page['menubar_page_name'] !!}</li>
            </ul>
        </div>

        <div class="about-us-standard agency-style" style="padding-top: 0;padding-bottom: 100px ">
            <div class="container">
                <div class="demo-container-1100">
                    <div class="row gutter-80">
                        {!! $page['menubar_page_contant'] !!}
                    </div>
                </div>
            </div>
        </div>

        @if ($settings['testimonials_status'] == 'on')
        <div class="sass-testimonial-section" id="testimonials">
            <div class="container">
                <div class="theme-title-one text-center hide-pr">
                    <div class="icon-box hide-pr">
                        <img src="{{ Module::asset('LandingPage:Resources/assets/new/images/shape/bg-shape5.svg') }}" alt="" class="bg-shape">
                        <img src="{{ Module::asset('LandingPage:Resources/assets/new/images/icon/icon27.svg') }}" alt="" class="icon">
                    </div>
                    <h2 class="main-title">{!! $settings['testimonials_heading'] !!}</h2>
                    <p>{!! $settings['testimonials_description'] !!}</p>
                </div> <!-- /.theme-title-one -->

                <div class="inner-container">
                    <div class="main-content">
                        <div class="agn-testimonial-slider">
                            @if (is_array(json_decode($settings['testimonials'])) || is_object(json_decode($settings['testimonials'])))
                                @foreach (json_decode($settings['testimonials']) as $key => $value)
                                    <div class="item">
                                        <p>{{ $value->testimonials_description }}</p>
                                        <h6 class="name">{{ $value->testimonials_title }}</h6>
                                        <span class="designation" style=" display: flex; justify-content: center; gap: 20px; margin-top: 20px; ">
                                            @if (isset($value->testimonials_user_avtar))
                                                <img src="{{ $logo . '/' . $value->testimonials_user_avtar }}" class="wid-40 rounded-circle me-3" style="width:50px;">
                                            @endif
                                            <span>
                                                <b class="fw-bold d-block">{{ $value->testimonials_user }}</b>
                                                {{ $value->testimonials_designation }}
                                            </span>
                                        </span>
                                    </div> <!-- /.item -->
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div> <!-- /.inner-container -->
            </div> <!-- /.container -->
        </div>
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
            <img src="{{ Module::asset('LandingPage:Resources/assets/new/images/images/shape/shape-67.svg') }}" alt="" class="shape-two">
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
    <script src="{{ Module::asset('LandingPage:Resources/assets/new/vendor/owl-carousel/owl.carousel.min.js') }}"></script>
    <script src="{{ Module::asset('LandingPage:Resources/assets/new/vendor/jquery.appear.js') }}"></script>
    <script src="{{ Module::asset('LandingPage:Resources/assets/new/vendor/jquery.countTo.js') }}"></script>
    <script src="{{ Module::asset('LandingPage:Resources/assets/new/vendor/fancybox/dist/jquery.fancybox.min.js') }}"></script>
    <script src="{{ Module::asset('LandingPage:Resources/assets/new/js/lang.js') }}"></script>
    <script src="{{ Module::asset('LandingPage:Resources/assets/new/js/theme.js') }}"></script>

    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();

                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

    </script>


@stack('custom-scripts')

</body>

</html>