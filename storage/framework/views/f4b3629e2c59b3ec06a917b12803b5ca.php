<?php
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
    <link rel="stylesheet"
        href="<?php echo e(Module::asset('LandingPage:Resources/assets/new')); ?>/rtl/css/owlCarousel.min.css" />
    <link rel="stylesheet"
        href="<?php echo e(Module::asset('LandingPage:Resources/assets/new')); ?>/rtl/css/fontawesome.min.css" />
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
                        <a href="<?php echo e(url('/')); ?>" class="st-logo-link"><img style="width: 50px;"
                                src="<?php echo e($logo . '/' . $settings['site_logo'] . '?' . time()); ?>" alt="demo"></a>
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
                                <li class="smooth-scroll"><a href="<?php echo e(url('/')); ?>"
                                        class="nav-link"><?php echo e($settings['home_title']); ?></a></li>
                                <li><a class="smooth-scroll" href="<?php echo e(url('/#features')); ?>"
                                        class="nav-link"><?php echo e($settings['feature_title']); ?></a></li>
                                <li><a class="smooth-scroll" href="<?php echo e(url('/#plans')); ?>"
                                        class="nav-link"><?php echo e($settings['plan_title']); ?></a></li>
                                <li><a class="smooth-scroll" href="<?php echo e(url('/#testimonials')); ?>"
                                        class="nav-link"><?php echo e($settings['testimonial_title']); ?></a></li>
                                <li><a class="smooth-scroll" href="<?php echo e(url('/#faqs')); ?>"
                                        class="nav-link"><?php echo e($settings['faq_title']); ?></a></li>
                                <li><a class="smooth-scroll" href="#price" class="smooth-scroll">Price</a></li>

                                <?php if(is_array(json_decode($settings['menubar_page'])) || is_object(json_decode($settings['menubar_page']))): ?>
                                    <li class="st-has-children"><a href="#blog"
                                            class="smooth-scroll"><?php echo e(__('Pages')); ?></a>
                                        <ul>
                                            <?php $__currentLoopData = json_decode($settings['menubar_page']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if(isset($value->header) && $value->header == 'on' && isset($value->template_name)): ?>
                                                    <li><a
                                                            href='<?php echo e($value->template_name == 'page_content' ? route('custom.page', $value->page_slug) : $value->page_url); ?>'><?php echo e($value->menubar_page_name); ?></a>
                                                    </li>
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
                                <a href="<?php echo e($settings['home_live_demo_link']); ?>"
                                    class="st-btn st-style1 st-color1"><?php echo e(__('Live Demo')); ?></a>
                            </div>
                        <?php endif; ?>

                        <?php if($settings['home_buy_now_link']): ?>
                            <div class="st-btn-group st-style1">
                                <a href="<?php echo e($settings['home_buy_now_link']); ?>"
                                    class="st-btn st-style1 st-color1"><?php echo e(__('Buy Now')); ?></a>
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

        <?php if($settings['feature_status'] == 'on'): ?>
            <section class="st-service-section st-section-top" id="service">
                <div class="container">
                    <div class="st-section-heading st-style2 text-center">
                        <h2><?php echo e($settings['feature_title']); ?></h2>
                        <div class="st-seperator">
                            <div class="st-seperator-left-bar wow fadeInLeft" data-wow-duration="1s"
                                data-wow-delay="0.2s"></div>
                            <img src="<?php echo e(Module::asset('LandingPage:Resources/assets/new')); ?>/rtl/img/light-img/seperator-icon1.png"
                                alt="demo" class="st-seperator-icon">
                            <div class="st-seperator-right-bar wow fadeInRight" data-wow-duration="1s"
                                data-wow-delay="0.2s"></div>
                        </div>
                        <p><?php echo $settings['feature_heading']; ?></p>
                    </div>
                </div>
                <div class="st-owl-controler3-hover">
                    <div class="container">
                        <div class="st-service-carousel owl-carousel st-style2 st-owl-controler3">
                            <?php if(is_array(json_decode($settings['feature_of_features'], true)) ||
                                    is_object(json_decode($settings['feature_of_features'], true))): ?>
                                <?php $__currentLoopData = json_decode($settings['feature_of_features'], true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="st-image-box st-style1 text-center wow fadeIn"
                                        data-wow-duration="0.8s" data-wow-delay="0.2s">
                                        <a href="#" class="st-image"><img
                                                src="<?php echo e($logo . '/' . $value['feature_logo'] . '?' . time()); ?>"
                                                alt="demo"></a>
                                        <div class="st-image-box-info">
                                            <h3 class="st-image-box-title"><a
                                                    href="#"><?php echo $value['feature_heading']; ?></a></h3>
                                            <div class="st-image-box-text"><?php echo $value['feature_description']; ?></div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
                
            </section>

        <?php endif; ?>

        <?php if($settings['feature_status'] == 'on'): ?>
            <section class="st-service-section st-section-top" id="service">
                <div class="container">
                    <div class="st-section-heading st-style2 text-center">
                        <h2><?php echo e(__('Other Features')); ?></h2>
                        <div class="st-seperator">
                            <div class="st-seperator-left-bar wow fadeInLeft" data-wow-duration="1s"
                                data-wow-delay="0.2s"></div>
                            <img src="<?php echo e(Module::asset('LandingPage:Resources/assets/new')); ?>/rtl/img/light-img/seperator-icon1.png"
                                alt="demo" class="st-seperator-icon">
                            <div class="st-seperator-right-bar wow fadeInRight" data-wow-duration="1s"
                                data-wow-delay="0.2s"></div>
                        </div>
                        <p><?php echo $settings['feature_heading']; ?></p>
                    </div>
                </div>
                <div class="st-owl-controler3-hover">
                    <div class="container">
                        <div class="st-service-carousel owl-carousel st-style2 st-owl-controler3">
                            <?php if(is_array(json_decode($settings['other_features'], true)) ||
                                    is_object(json_decode($settings['other_features'], true))): ?>
                                <?php $__currentLoopData = json_decode($settings['other_features'], true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="st-image-box st-style1 text-center wow fadeIn"
                                        data-wow-duration="0.8s" data-wow-delay="0.2s">
                                        <a href="#" class="st-image"><img style="    height: 250px;"
                                                src="<?php echo e($logo . '/' . $value['other_features_image']); ?>"
                                                alt="demo"></a>
                                        <div class="st-image-box-info">
                                            <h3 class="st-image-box-title"><a href="#">
                                                    <?php echo $value['other_features_heading']; ?></a></h3>
                                            <div class="st-image-box-text"><?php echo $value['other_featured_description']; ?></div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <?php if($settings['discover_status'] == 'on'): ?>
            <section class="st-service-section st-section-top" id="service">
                <div class="container">
                    <div class="st-section-heading st-style2 text-center">
                        <h2><?php echo $settings['discover_heading']; ?></h2>
                        <div class="st-seperator">
                            <div class="st-seperator-left-bar wow fadeInLeft" data-wow-duration="1s"
                                data-wow-delay="0.2s"></div>
                            <img src="<?php echo e(Module::asset('LandingPage:Resources/assets/new')); ?>/rtl/img/light-img/seperator-icon1.png"
                                alt="demo" class="st-seperator-icon">
                            <div class="st-seperator-right-bar wow fadeInRight" data-wow-duration="1s"
                                data-wow-delay="0.2s"></div>
                        </div>
                        <p><?php echo $settings['discover_description']; ?></p>
                    </div>
                </div>
                <div class="st-owl-controler3-hover">
                    <div class="container">
                        <div class="st-service-carousel owl-carousel st-style2 st-owl-controler3">
                            <?php if(is_array(json_decode($settings['discover_of_features'], true)) ||
                                    is_object(json_decode($settings['discover_of_features'], true))): ?>
                                <?php $__currentLoopData = json_decode($settings['discover_of_features'], true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="st-image-box st-style1 text-center wow fadeIn"
                                        data-wow-duration="0.8s" data-wow-delay="0.2s">
                                        <a href="<?php if($settings['discover_live_demo_link']): ?> <?php echo e($settings['discover_live_demo_link']); ?> <?php else: ?> <?php echo e('#'); ?> <?php endif; ?>"
                                            class="st-image"><img style="    height: 250px;"
                                                src="<?php echo e($logo . '/' . $value['discover_logo']); ?>" alt="demo"></a>
                                        <div class="st-image-box-info">
                                            <h3 class="st-image-box-title"><a href="#">
                                                    <?php echo $value['discover_heading']; ?></a></h3>
                                            <div class="st-image-box-text"><?php echo $value['discover_description']; ?></div>
                                        </div>
                                        <?php if($settings['discover_buy_now_link']): ?>
                                            <a href="<?php echo e($settings['discover_buy_now_link']); ?>"
                                                class="st-btn st-style1 st-size1 st-color2 mb-3"><?php echo e(__('Buy Now ')); ?></a>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <?php if($settings['screenshots_status'] == 'on'): ?>
            <div class="st-project-wrap st-section-top" id="portfolio">
                <div class="container">
                    <div class="st-section-heading st-style2 text-center">
                        <h2><?php echo $settings['screenshots_heading']; ?></h2>

                        <div class="st-seperator">
                            <div class="st-seperator-left-bar wow fadeInLeft" data-wow-duration="1s"
                                data-wow-delay="0.2s"></div>
                            <img src="<?php echo e(Module::asset('LandingPage:Resources/assets/new')); ?>/rtl/img/light-img/seperator-icon1.png"
                                alt="demo" class="st-seperator-icon">
                            <div class="st-seperator-right-bar wow fadeInRight" data-wow-duration="1s"
                                data-wow-delay="0.2s"></div>
                        </div>
                        <p><?php echo $settings['screenshots_description']; ?></p>
                    </div>
                </div>
                <div class="st-project st-project-carousel owl-carousel st-style1 st-owl-controler1">
                    <?php if(is_array(json_decode($settings['screenshots'], true)) || is_object(json_decode($settings['screenshots'], true))): ?>
                        <?php $__currentLoopData = json_decode($settings['screenshots'], true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="#" class="st-single-project st-bg wow fadeIn" data-wow-duration="0.8s"
                                data-wow-delay="0.2s" data-src="<?php echo e($logo . '/' . $value['screenshots']); ?>">
                                <div class="st-project-meta">
                                    <h3><?php echo $value['screenshots_heading']; ?></h3>
                                </div>
                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if($settings['faq_status'] == 'on'): ?>
            <section class="st-skill-wrap st-section-top">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="st-vertical-middle">
                                <div class="st-vertical-middle-in wow fadeInLeft" data-wow-duration="0.8s"
                                    data-wow-delay="0.2s">
                                    <div class="st-skill-img text-center">
                                        <img src="<?php echo e(Module::asset('LandingPage:Resources/assets/new')); ?>/rtl/img/light-img/skill-img.png"
                                            alt="demo">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="st-section-heading st-style2 st-type2">
                                <h2><?php echo $settings['faq_heading']; ?></h2>
                                <p><?php echo $settings['faq_description']; ?></p>
                            </div>

                            <div class="accordion" id="faqAccordion">
                                <?php if(is_array(json_decode($settings['faqs'], true)) || is_object(json_decode($settings['faqs'], true))): ?>
                                    <?php $__currentLoopData = json_decode($settings['faqs'], true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="card">
                                            <div class="card-header" id="heading<?php echo e($key); ?>">
                                                <h5 class="mb-0">
                                                    <button class="btn btn-link" type="button"
                                                        data-toggle="collapse" data-target="#faq<?php echo e($key); ?>"
                                                        aria-expanded="true" aria-controls="faq<?php echo e($key); ?>">
                                                        <?php echo $value['faq_questions']; ?>

                                                    </button>
                                                </h5>
                                            </div>
                                            <div id="faq<?php echo e($key); ?>" class="collapse show"
                                                aria-labelledby="heading<?php echo e($key); ?>"
                                                data-parent="#faqAccordion">
                                                <div class="card-body">
                                                    <?php echo $value['faq_answer']; ?>

                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </div>
                        </div>

                    </div>
                </div>
            </section>
        <?php endif; ?>

        <?php if($settings['plan_status']): ?>
            <section class="st-pricing-wrap st-section" id="price">
                <div class="container">
                    <div class="st-section-heading st-style2 text-center">
                        <h2><?php echo $settings['plan_heading']; ?></h2>
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
                        <p><?php echo $settings['plan_description']; ?></p>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <?php
                            $collection = \App\Models\Plan::orderBy('price', 'ASC')->get();
                            $admin_payment_setting = Utility::getAdminPaymentSetting();
                        ?>
                        <?php $__currentLoopData = $collection; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-lg-4">
                                <div class="st-price-card text-center wow fadeInUp" data-wow-duration="0.8s"
                                    data-wow-delay="0.2s">
                                    <div class="st-price-card-img"><img
                                            src="<?php echo e(Module::asset('LandingPage:Resources/assets/new')); ?>/rtl/img/blue-img/price-img1.png"
                                            alt="demo">
                                    </div>
                                    <h3 class="st-price-card-title"><?php echo e($value->name); ?></h3>
                                    <div class="st-price">
                                        <h3><?php echo e(isset($admin_payment_setting['currency_symbol']) ? $admin_payment_setting['currency_symbol'] : '$'); ?><?php echo e(intval($value->price)); ?>

                                        </h3>
                                    </div>
                                    <ul class="st-price-card-feature st-mp0">
                                      <?php echo $value->description; ?>

                                    </ul>
                                    <div class="st-price-card-btn">
                                        <a href="<?php echo e(route('register',['lang'=>'en','plan'=>$value->id])); ?>"
                                            class="st-btn st-style1 st-size1 st-color3"><?php echo e(__('Start The Plan')); ?></a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>
        <!-- End Pricing Plan -->

        <!-- Start Client Section -->
        <div class="st-client-wrap st-section">
            <div class="container">
                <div class="st-client-carousel owl-carousel">
                    <?php $__currentLoopData = explode(',', $settings['home_logo']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $home_logo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="st-client-logo st-flex wow fadeIn" data-wow-duration="0.8s"
                            data-wow-delay="0.2s">
                            <img src="<?php echo e($logo . '/' . $home_logo); ?>" alt="demo">
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
        <!-- End Client Section -->

        <!-- Start Testimonial Section -->
        <?php if($settings['testimonials_status'] == 'on'): ?>
            <section class="st-testimonial-wrap st-section st-gray-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="st-testimonial-right-img st-flex wow fadeInLeft" data-wow-duration="0.8s"
                                data-wow-delay="0.2s">
                                <img src="<?php echo e(Module::asset('LandingPage:Resources/assets/new')); ?>/rtl/img/blue-img/testimonial-img.png"
                                    alt="demo">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="st-vertical-middle">
                                <div class="st-vertical-middle-in">
                                    <div class="st-section-heading st-style1">
                                        <h3><?php echo $settings['testimonials_heading']; ?></h3>
                                        <h2><?php echo $settings['testimonials_description']; ?></h2>
                                    </div>
                                    <div class="st-testimonial-slider owl-carousel st-owl-controler4">
                                        <?php if(is_array(json_decode($settings['testimonials'])) || is_object(json_decode($settings['testimonials']))): ?>
                                            <?php $__currentLoopData = json_decode($settings['testimonials']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="st-single-testimonial">
                                                    <div class="st-testimonial-quote st-flex"><i
                                                            class="fas fa-quote-right"></i></div>
                                                    <div class="st-testimonial-text">
                                                        <?php echo e($value->testimonials_description); ?></div>
                                                    <div class="st-testimonial-meta">
                                                        <h3><?php echo e($value->testimonials_title); ?></h3>
                                                        <p><?php echo e($value->testimonials_user); ?></p>
                                                        <p><?php echo e($value->testimonials_designation); ?></p>
                                                    </div>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>
        <!-- End Testimonial Section -->

        <!-- Start News Letter Section -->
        <?php if($settings['joinus_status'] == 'on'): ?>
        <section class="st-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="st-newsletter-wrap">
                            <div class="st-left-newsletter">
                                <div class="st-section-heading st-style1 st-type1">
                                    <h3><?php echo $settings['joinus_heading']; ?></h3>
                                    <h2><?php echo $settings['joinus_description']; ?></h2>
                                </div>
                                <div class="st-newsletter">
                                    <form class="mailchimp st-subscribe-form"
                                        action="<?php echo e(route('join_us_store')); ?>">
                                        <?php echo csrf_field(); ?>
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
                                    <img src="<?php echo e(Module::asset('LandingPage:Resources/assets/new')); ?>/rtl/img/blue-img/news-letter-img.png"
                                        alt="demo">
                                    <div class="st-bard-animation">
                                        <div class="st-bard-animation1"><img
                                                src="<?php echo e(Module::asset('LandingPage:Resources/assets/new')); ?>/rtl/img/blue-img/bard1.png"
                                                alt="demo"></div>
                                        <div class="st-bard-animation2"><img
                                                src="<?php echo e(Module::asset('LandingPage:Resources/assets/new')); ?>/rtl/img/blue-img/bard2.png"
                                                alt="demo"></div>
                                        <div class="st-bard-animation3"><img
                                                src="<?php echo e(Module::asset('LandingPage:Resources/assets/new')); ?>/rtl/img/blue-img/bard3.png"
                                                alt="demo"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php endif; ?>




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
                <div class="st-copyright-text">
                    <?php echo e(App\Models\Utility::getValByName('footer_text') ? App\Models\Utility::getValByName('footer_text') : config('app.name', 'Resource Managment')); ?>

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
        <script src="<?php echo e(Module::asset('LandingPage:Resources/assets/new')); ?>/rtl/js/vendor/modernizr-3.5.0.min.js"></script>
        <script src="<?php echo e(Module::asset('LandingPage:Resources/assets/new')); ?>/rtl/js/vendor/jquery-1.12.4.min.js"></script>
        <script src="<?php echo e(Module::asset('LandingPage:Resources/assets/new')); ?>/rtl/js/mailchimp.min.js"></script>
        <script src="<?php echo e(Module::asset('LandingPage:Resources/assets/new')); ?>/rtl/js/owlCarousel.min.js"></script>
        <script src="<?php echo e(Module::asset('LandingPage:Resources/assets/new')); ?>/rtl/js/tamjid-counter.min.js"></script>
        <script src="<?php echo e(Module::asset('LandingPage:Resources/assets/new')); ?>/rtl/js/wow.min.js"></script>
        <script src="<?php echo e(Module::asset('LandingPage:Resources/assets/new')); ?>/rtl/js/main.js"></script>
</body>

</html>
<?php /**PATH C:\xampp\htdocs\rezo2\Modules/LandingPage\Resources/views/layouts/landingpage.blade.php ENDPATH**/ ?>