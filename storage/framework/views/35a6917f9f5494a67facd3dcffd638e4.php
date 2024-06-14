<?php
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

?>

<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
  <!-- Meta Tags -->
  <meta charset="utf-8" />
  <meta http-equiv="x-ua-compatible" content="ie=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="title" content="<?php echo e($metatitle); ?>">
    <meta name="description" content="<?php echo e($metadesc); ?>">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo e(env('APP_URL')); ?>">
    <meta property="og:title" content="<?php echo e($metatitle); ?>">
    <meta property="og:description" content="<?php echo e($metadesc); ?>">
    <meta property="og:image"
        content="<?php echo e(isset($meta_logo) && !empty(asset('storage/uploads/meta/' . $meta_logo)) ? asset('storage/uploads/meta/' . $meta_logo) : 'hrmgo.png'); ?>">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?php echo e(env('APP_URL')); ?>">
    <meta property="twitter:title" content="<?php echo e($metatitle); ?>">
    <meta property="twitter:description" content="<?php echo e($metadesc); ?>">
    <meta property="twitter:image"
        content="<?php echo e(isset($meta_logo) && !empty(asset('storage/uploads/meta/' . $meta_logo)) ? asset('storage/uploads/meta/' . $meta_logo) : 'hrmgo.png'); ?>">
  <!-- Page Title -->
  <title><?php echo e(env('APP_NAME')); ?></title>
  <!-- Favicon Icon -->
  <link rel="icon"
        href="<?php echo e($sup_logo . '/' . (isset($company_favicon) && !empty($company_favicon) ? $company_favicon : 'favicon.png')); ?>"
        type="image/x-icon" />
  <!-- Stylesheets -->
  <link rel="stylesheet" href="<?php echo e(Module::asset('LandingPage:Resources/assets/new')); ?>/rtl/css/bootstrap.min.css" />
  <link rel="stylesheet" href="<?php echo e(Module::asset('LandingPage:Resources/assets/new')); ?>/rtl/css/owlCarousel.min.css" />
  <link rel="stylesheet" href="<?php echo e(Module::asset('LandingPage:Resources/assets/new')); ?>/rtl/css/fontawesome.min.css" />
  <link rel="stylesheet" href="<?php echo e(Module::asset('LandingPage:Resources/assets/new')); ?>/rtl/css/flaticon.css" />
  <link rel="stylesheet" href="<?php echo e(Module::asset('LandingPage:Resources/assets/new')); ?>/rtl/css/animate.css" />
  <link rel="stylesheet" href="<?php echo e(Module::asset('LandingPage:Resources/assets/new')); ?>/rtl/css/style.css" />
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
            <a href="<?php echo e(url('/')); ?>" class="st-logo-link"><img style="width: 50px;" src="<?php echo e($logo . '/' . $settings['site_logo'] . '?' . time()); ?>" alt="demo"></a>
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
                <li class="smooth-scroll"><a href="<?php echo e(url('/')); ?>" class="nav-link" ><?php echo e($settings['home_title']); ?></a></li>
                <li><a class="smooth-scroll" href="<?php echo e(url('/#features')); ?>" class="nav-link" ><?php echo e($settings['feature_title']); ?></a></li>
                <li><a class="smooth-scroll" href="<?php echo e(url('/#plans')); ?>" class="nav-link" ><?php echo e($settings['plan_title']); ?></a></li>
                <li><a class="smooth-scroll" href="<?php echo e(url('/#testimonials')); ?>" class="nav-link" ><?php echo e($settings['testimonial_title']); ?></a></li>
                <li><a class="smooth-scroll" href="<?php echo e(url('/#faqs')); ?>" class="nav-link" ><?php echo e($settings['faq_title']); ?></a></li>
                <li><a class="smooth-scroll" href="#price" class="smooth-scroll">Price</a></li>
                
                <?php if(is_array(json_decode($settings['menubar_page'])) || is_object(json_decode($settings['menubar_page']))): ?>
                <li class="st-has-children"><a href="#blog" class="smooth-scroll"><?php echo e(__("Pages")); ?></a>
                  <ul>
                        <?php $__currentLoopData = json_decode($settings['menubar_page']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(isset($value->header) && $value->header == 'on' && isset($value->template_name)): ?>
                                <li><a href='<?php echo e($value->template_name == 'page_content' ? route('custom.page', $value->page_slug) : $value->page_url); ?>'><?php echo e($value->menubar_page_name); ?></a></li>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </ul>
                </li>
                <?php endif; ?>
                <?php if(!Auth::check()): ?>
                <li><a href="<?php echo e(route('login')); ?>"><?php echo e(__('Login')); ?></a></li>
                <li><a href="<?php echo e(route('register')); ?>"><?php echo e(__('Register')); ?></a></li>
                <?php else: ?>
                <li><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
                <?php endif; ?>
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
          <h1 class="st-hero-title"><?php echo e($settings['home_offer_text']); ?></h1>
          <div class="st-hero-subtitle" style="margin-bottom:10px;">
            <?php echo e($settings['home_heading']); ?>

          </div>
          <div class="st-hero-subtitle" style="width: 50%;">
            <?php echo e($settings['home_description']); ?>

          </div>
            
          <div class="d-flex" style="gap:10px;">
            <?php if($settings['home_live_demo_link']): ?>
            <div class="st-btn-group st-style1">
                <a href="<?php echo e($settings['home_live_demo_link']); ?>" class="st-btn st-style1 st-color1"><?php echo e(__('Live Demo')); ?></a>
              </div>
            <?php endif; ?>

            <?php if($settings['home_buy_now_link']): ?>
            <div class="st-btn-group st-style1">
                <a href="<?php echo e($settings['home_buy_now_link']); ?>" class="st-btn st-style1 st-color1"><?php echo e(__('Buy Now')); ?></a>
              </div>
            <?php endif; ?>
          </div>
          
          
        </div>
      </div>
      <div class="st-hero-img">
        <img src="<?php echo e($logo . '/' . $settings['home_banner']); ?>" alt="demo">
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
              <h3><?php echo $page['menubar_page_name']; ?></h3>
            </div>
            <div class="st-about-text">
                <?php echo $page['menubar_page_contant']; ?>

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
                <?php echo $__env->make('landingpage::layouts.buttons', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
              </ul>
            </div>
          </div>
        </div>
        <div class="st-copyright text-center">
            <div class="st-copyright-text"><?php echo e(App\Models\Utility::getValByName('footer_text') ? App\Models\Utility::getValByName('footer_text') : config('app.name', 'Resource Managment')); ?></div>
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
  <script src="<?php echo e(Module::asset('LandingPage:Resources/assets/new')); ?>/rtl/js/vendor/modernizr-3.5.0.min.js"></script>
  <script src="<?php echo e(Module::asset('LandingPage:Resources/assets/new')); ?>/rtl/js/vendor/jquery-1.12.4.min.js"></script>
  <script src="<?php echo e(Module::asset('LandingPage:Resources/assets/new')); ?>/rtl/js/mailchimp.min.js"></script>
  <script src="<?php echo e(Module::asset('LandingPage:Resources/assets/new')); ?>/rtl/js/owlCarousel.min.js"></script>
  <script src="<?php echo e(Module::asset('LandingPage:Resources/assets/new')); ?>/rtl/js/tamjid-counter.min.js"></script>
  <script src="<?php echo e(Module::asset('LandingPage:Resources/assets/new')); ?>/rtl/js/wow.min.js"></script>
  <script src="<?php echo e(Module::asset('LandingPage:Resources/assets/new')); ?>/rtl/js/main.js"></script>
</body>

</html><?php /**PATH C:\xampp\htdocs\rezo2\Modules/LandingPage\Resources/views/layouts/custompage.blade.php ENDPATH**/ ?>