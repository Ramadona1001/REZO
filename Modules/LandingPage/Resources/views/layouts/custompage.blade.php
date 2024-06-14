@php
    use App\Models\Utility;
    $settings = \Modules\LandingPage\Entities\LandingPageSetting::settings();
    $logo = Utility::get_file('uploads/landing_page_image');
    $sup_logo = Utility::get_file('uploads/logo');
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
  <link rel="stylesheet" href="{{ Module::asset('LandingPage:Resources/assets/new') }}/rtl/css/owlCarousel.min.css" />
  <link rel="stylesheet" href="{{ Module::asset('LandingPage:Resources/assets/new') }}/rtl/css/fontawesome.min.css" />
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
            <a href="{{ url('/') }}" class="st-logo-link"><img style="width: 50px;" src="{{ $logo . '/' . $settings['site_logo'] . '?' . time() }}" alt="demo"></a>
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
                <li class="smooth-scroll"><a href="{{ url('/') }}" class="nav-link" >{{ $settings['home_title'] }}</a></li>
                <li><a class="smooth-scroll" href="{{ url('/#features') }}" class="nav-link" >{{ $settings['feature_title'] }}</a></li>
                <li><a class="smooth-scroll" href="{{ url('/#plans') }}" class="nav-link" >{{ $settings['plan_title'] }}</a></li>
                <li><a class="smooth-scroll" href="{{ url('/#testimonials') }}" class="nav-link" >{{ $settings['testimonial_title'] }}</a></li>
                <li><a class="smooth-scroll" href="{{ url('/#faqs') }}" class="nav-link" >{{ $settings['faq_title'] }}</a></li>
                <li><a class="smooth-scroll" href="#price" class="smooth-scroll">Price</a></li>
                
                @if (is_array(json_decode($settings['menubar_page'])) || is_object(json_decode($settings['menubar_page'])))
                <li class="st-has-children"><a href="#blog" class="smooth-scroll">{{ __("Pages") }}</a>
                  <ul>
                        @foreach (json_decode($settings['menubar_page']) as $key => $value)
                            @if (isset($value->header) && $value->header == 'on' && isset($value->template_name))
                                <li><a href='{{ $value->template_name == 'page_content' ? route('custom.page', $value->page_slug) : $value->page_url }}'>{{ $value->menubar_page_name }}</a></li>
                            @endif
                        @endforeach
                  </ul>
                </li>
                @endif
                @if(!Auth::check())
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
                <a href="{{ $settings['home_live_demo_link'] }}" class="st-btn st-style1 st-color1">{{ __('Live Demo') }}</a>
              </div>
            @endif

            @if ($settings['home_buy_now_link'])
            <div class="st-btn-group st-style1">
                <a href="{{ $settings['home_buy_now_link'] }}" class="st-btn st-style1 st-color1">{{ __('Buy Now') }}</a>
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


    <!-- Start About Section -->
    <div class="st-about-wrap st-section-top" id="about">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="st-section-heading st-style1">
              <h3>{!! $page['menubar_page_name'] !!}</h3>
            </div>
            <div class="st-about-text">
                {!! $page['menubar_page_contant'] !!}
            </div>
          </div>
        </div>
      </div>
    </div>

    
    
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
            <div class="st-copyright-text">{{ App\Models\Utility::getValByName('footer_text') ? App\Models\Utility::getValByName('footer_text') : config('app.name', 'Resource Managment') }}</div>
        </div>
      </footer>

  </div>

  <!-- Start Footer Seciton -->
  
  <!-- End Footer Seciton -->
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