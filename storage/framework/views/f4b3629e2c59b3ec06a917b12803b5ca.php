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

    if(isset($setting['color_flag']) && $setting['color_flag'] == 'true')
    {
        $themeColor = 'custom-color';
    }
    else {
        $themeColor = $color;
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php echo e(env('APP_NAME')); ?></title>
    <!-- Meta -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

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

    <!-- Favicon icon -->
    
    <link rel="icon"
        href="<?php echo e($sup_logo . '/' . (isset($company_favicon) && !empty($company_favicon) ? $company_favicon : 'favicon.png')); ?>"
        type="image/x-icon" />

    <link rel="stylesheet" type="text/css" href="<?php echo e(Module::asset('LandingPage:Resources/assets/new/css/style.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(Module::asset('LandingPage:Resources/assets/new/css/responsive.css')); ?>">
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
            <div class="logo"><a href="<?php echo e(url('/')); ?>"><img src="<?php echo e($logo . '/' . $settings['site_logo'] . '?' . time()); ?>" alt=""></a></div>
            <nav id="mega-menu-holder" class="navbar navbar-expand-lg">
                <div  class="ml-auto nav-container">
                    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="flaticon-setup"></i>
                    </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav">
                            <li class="nav-item active">
                                <a href="<?php echo e(url('/')); ?>" class="nav-link" ><?php echo e($settings['home_title']); ?></a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(url('/#features')); ?>" class="nav-link" ><?php echo e($settings['feature_title']); ?></a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(url('/#plans')); ?>" class="nav-link" ><?php echo e($settings['plan_title']); ?></a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(url('/#testimonials')); ?>" class="nav-link" ><?php echo e($settings['testimonial_title']); ?></a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(url('/#faqs')); ?>" class="nav-link" ><?php echo e($settings['faq_title']); ?></a>
                            </li>

                            <?php if(is_array(json_decode($settings['menubar_page'])) || is_object(json_decode($settings['menubar_page']))): ?>
                            <li class="nav-item dropdown position-relative">
                                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"><?php echo e(__("Pages")); ?></a>
                                <ul class="dropdown-menu">
                                    <?php $__currentLoopData = json_decode($settings['menubar_page']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(isset($value->header) && $value->header == 'on' && isset($value->template_name)): ?>
                                        <li class="nav-item">
                                            <a href="<?php echo e($value->template_name == 'page_content' ? route('custom.page', $value->page_slug) : $value->page_url); ?>" class="nav-link dropdown-toggle" data-toggle="dropdown"><?php echo e($value->menubar_page_name); ?></a>
                                        </li>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul> <!-- /.dropdown-menu -->
                            </li>
                            <?php endif; ?>
                            <li class="login-button" style=" gap: 10px; display: flex; ">
                                <?php if(!Auth::check()): ?>
                                    <a href="<?php echo e(route('login')); ?>"><?php echo e(__('Login')); ?></a>
                                    <a href="<?php echo e(route('register')); ?>"><?php echo e(__('Register')); ?></a>
                                <?php else: ?>
                                    <a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a>
                                <?php endif; ?>
                            </li>
                    </ul>
                </div>
                </div> <!-- /.container -->
            </nav> <!-- /#mega-menu-holder -->
            
            


        </div>

        <?php if($settings['home_status'] == 'on'): ?>
        <div id="theme-banner-four">
            <img src="<?php echo e($logo . '/' . $settings['home_banner']); ?>" alt="" class="screen-one wow fadeInRight animated" data-wow-duration="2s">
            
            <img src="<?php echo e(Module::asset('LandingPage:Resources/assets/new/images/shape/shape-8.svg')); ?>" alt="" class="shape-one">
            <img src="<?php echo e(Module::asset('LandingPage:Resources/assets/new/images/shape/shape-9.svg')); ?>" alt="" class="shape-two">
            <img src="<?php echo e(Module::asset('LandingPage:Resources/assets/new/images/shape/shape-10.svg')); ?>" alt="" class="shape-three">
            <img src="<?php echo e(Module::asset('LandingPage:Resources/assets/new/images/shape/shape-11.svg')); ?>" alt="" class="shape-four">
            <div class="round-shape-one"></div>
            <div class="round-shape-two"></div>
            <div class="round-shape-three"></div>
            <div class="round-shape-four"></div>
            <div class="container">
                <div class="main-wrapper">
                    <div class="slogan wow fadeInDown animated" data-wow-delay="0.2s"><span><?php echo e($settings['home_offer_text']); ?></span></div>
                    <h1 class="main-title wow fadeInUp animated" data-wow-delay="0.4s"><?php echo e($settings['home_heading']); ?></h1>
                    <p class="sub-title wow fadeInUp animated" data-wow-delay="0.9s"><?php echo e($settings['home_description']); ?></p>
                    <ul class="button-group lightgallery">
                        <?php if($settings['home_live_demo_link']): ?>
                        <li><a href="<?php echo e($settings['home_live_demo_link']); ?>" class="more-button wow fadeInLeft animated" data-wow-delay="1.5s"><?php echo e(__('Live Demo')); ?> <i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
                        <?php endif; ?>

                        <?php if($settings['home_buy_now_link']): ?>
                        <li><a href="<?php echo e($settings['home_buy_now_link']); ?>" class="fancybox video-button video-button-one wow fadeInRight animated" data-wow-delay="1.5s"><?php echo e(__('Buy Now')); ?></a></li>
                        <?php endif; ?>
                    </ul>
                </div> <!-- /.main-wrapper -->
            </div> <!-- /.container -->
        </div>
        

        <div class="trusted-partner">
            <div class="container">
                <h6 class="title"><?php echo e(__('Trusted by')); ?> <span><?php echo e($settings['home_trusted_by']); ?></span></h6>

                <div class="owl-carousel owl-theme customers-partners">
                    <div class="item"><a href="#"><img src="<?php echo e(Module::asset('LandingPage:Resources/assets/new/images/logo/envato.svg')); ?>" alt=""></a></div>
                    <div class="item"><a href="#"><img src="<?php echo e(Module::asset('LandingPage:Resources/assets/new/images/logo/envato.svg')); ?>" alt=""></a></div>
                    <div class="item"><a href="#"><img src="<?php echo e(Module::asset('LandingPage:Resources/assets/new/images/logo/envato.svg')); ?>" alt=""></a></div>
                    <div class="item"><a href="#"><img src="<?php echo e(Module::asset('LandingPage:Resources/assets/new/images/logo/envato.svg')); ?>" alt=""></a></div>
                    <div class="item"><a href="#"><img src="<?php echo e(Module::asset('LandingPage:Resources/assets/new/images/logo/envato.svg')); ?>" alt=""></a></div>
                </div>
            </div>
        </div>

        <?php endif; ?>


        <?php if($settings['feature_status'] == 'on'): ?>
        <div class="our-service-sass hide-pr" id="features">
            <div class="container">
                <div class="theme-title-one text-center">
                    <div class="icon-box hide-pr">
                        <img src="<?php echo e(Module::asset('LandingPage:Resources/assets/new/images/shape/bg-shape1.svg')); ?>" alt="" class="bg-shape">
                        <img src="<?php echo e(Module::asset('LandingPage:Resources/assets/new/images/icon/icon23.svg')); ?>" alt="" class="icon">
                    </div>
                    <h4 class="main-title" style="font-size:30px;">
                        <?php echo e($settings['feature_title']); ?>

                        <?php if($settings['feature_buy_now_link']): ?>
                            <a href="<?php echo e($settings['feature_buy_now_link']); ?>" class="btn btn-warning btn-sm"><?php echo e(__('Buy Now')); ?><i data-feather="lock" class="ms-2"></i></a>
                        <?php endif; ?>
                    </h4>
                    <h2 class="main-title"><?php echo $settings['feature_heading']; ?></h2>
                    <p class="mt-3"><?php echo $settings['feature_description']; ?></p>
                </div> <!-- /.theme-title-one -->
                
                <div class="inner-wrapper">
                    <div class="row">
                        <?php if(is_array(json_decode($settings['feature_of_features'], true)) || is_object(json_decode($settings['feature_of_features'], true))): ?>
                            <?php $__currentLoopData = json_decode($settings['feature_of_features'], true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                                        <img src="<?php echo e($logo . '/' . $value['feature_logo'] . '?' . time()); ?>" alt="">
                                        <h5 class="title"><a href="#"><?php echo $value['feature_heading']; ?></a></h5>
                                        <p><?php echo $value['feature_description']; ?></p>
                                    </div> <!-- /.service-block -->
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </div> <!-- /.row -->
                </div> <!-- /.inner-wrapper -->
            </div> <!-- /.container -->
        </div>
        <?php endif; ?>
        
        <?php if($settings['feature_status'] == 'on'): ?>
            <div class="our-feature-sass">
                <div class="section-shape-one"></div>
                <div class="section-shape-two"><img src="<?php echo e(Module::asset('LandingPage:Resources/assets/new/images/shape/shape-18.svg')); ?>" alt=""></div>
                <img src="<?php echo e(Module::asset('LandingPage:Resources/assets/new/images/shape/shape-18.svg')); ?>" alt="" class="section-shape-three">
                <div class="section-shape-four"></div>
                <img src="<?php echo e(Module::asset('LandingPage:Resources/assets/new/images/shape/shape-20.svg')); ?>" alt="" class="section-shape-five">
                <img src="<?php echo e(Module::asset('LandingPage:Resources/assets/new/images/shape/shape-21.svg')); ?>" alt="" class="section-shape-six">
                <img src="<?php echo e(Module::asset('LandingPage:Resources/assets/new/images/shape/shape-22.svg')); ?>" alt="" class="section-shape-seven">
                <img src="<?php echo e(Module::asset('LandingPage:Resources/assets/new/images/shape/shape-19.svg')); ?>" alt="" class="section-shape-eight">
                <a href="#feature-sass" class="down-arrow scroll-target"><span><i class="flaticon-back"></i></span></a>
                <div class="feature-wrapper" id="feature-sass">
                    <?php if(is_array(json_decode($settings['other_features'], true)) || is_object(json_decode($settings['other_features'], true))): ?>
                        <?php $__currentLoopData = json_decode($settings['other_features'], true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="single-feature-block">
                                <div class="container clearfix">
                                    <div class="row">
                                        <div class="col-6">
                                            <img src="<?php echo e($logo . '/' . $value['other_features_image']); ?>" alt="" class="main-shape" data-aos="fade-right" data-aos-delay="200">
                                        </div>
                                        <div class="col-6">
                                            <div class="text-box">
                                                <h2 class="main-title"><?php echo $value['other_features_heading']; ?><b class="line"></b></h2>
                                                <?php echo $value['other_featured_description']; ?>

                                                <a href="<?php echo e($value['other_feature_buy_now_link']); ?>" class="read-more"><?php echo e(__('Buy Now')); ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if($settings['plan_status']): ?>
        <div class="sass-our-pricing" id="plans">
            <div class="section-shape-one"><img src="<?php echo e(Module::asset('LandingPage:Resources/assets/new/images/shape/shape-18.svg')); ?>" alt=""></div>
            <img src="<?php echo e(Module::asset('LandingPage:Resources/assets/new/images/shape/shape-24.svg')); ?>" alt="" class="section-shape-two" data-aos="fade-right" data-aos-duration="3000">
            <img src="<?php echo e(Module::asset('LandingPage:Resources/assets/new/images/shape/shape-25.svg')); ?>" alt="" class="section-shape-three">
            <div class="section-shape-four"></div>
            <img src="<?php echo e(Module::asset('LandingPage:Resources/assets/new/images/shape/shape-26.svg')); ?>" alt="" class="section-shape-five">
            <img src="<?php echo e(Module::asset('LandingPage:Resources/assets/new/images/shape/shape-27.svg')); ?>" alt="" class="section-shape-six" data-aos="fade-left" data-aos-duration="3000">


            <div class="container">
                <div class="theme-title-one text-center hide-pr">
                    <div class="icon-box hide-pr">
                        <img src="<?php echo e(Module::asset('LandingPage:Resources/assets/new/images/shape/bg-shape4.svg')); ?>" alt="" class="bg-shape">
                        <img src="<?php echo e(Module::asset('LandingPage:Resources/assets/new/images/icon/icon26.svg')); ?>" alt="" class="icon">
                    </div>
                    <h2 class="main-title"><?php echo $settings['plan_heading']; ?></h2>
                    <p><?php echo $settings['plan_description']; ?></p>
                </div> <!-- /.theme-title-one -->
                <div class="row no-gutters">
                    <?php
                        $collection = \App\Models\Plan::orderBy('price', 'ASC')->get();
                    ?>
                    <?php $__currentLoopData = $collection; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-lg-4">
                        <div class="single-pr-table free">
                            <div class="pr-header">
                                <div class="price"><?php echo e(!empty($admin_payment_setting['currency_symbol']) ? $admin_payment_setting['currency_symbol'] : $adminSettings['site_currency_symbol'] . $value->price); ?></div>
                                <div class="package"><?php echo e($value->duration); ?></div>
                                <h4 class="title"><?php echo e($value->name); ?></h4>
                                <p>
                                    <?php echo $value->description; ?>

                                </p>
                            </div> <!-- /.pr-header -->
                            <div class="pr-body">
                                <h3 class="feature"><?php echo e(__('Top Features')); ?></h3>
                                <ul>
                                    <li>
                                        <div class="form-check text-start">
                                            <label class="form-check-label" for="customCheckc1">
                                                <i class="text-primary ti ti-circle-plus"></i>
                                                <?php echo e($value->max_users == -1 ? 'Unlimited' : $value->max_users); ?>

                                                <?php echo e(__('User')); ?></label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="form-check text-start">
                                            <i class="text-primary ti ti-circle-plus"></i>
                                            <label class="form-check-label"
                                                for="customCheckc1"><?php echo e($value->max_employees == -1 ? 'Unlimited' : $value->max_employees); ?>

                                                <?php echo e(__('Employees')); ?></label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="form-check text-start">
                                            <i class="text-primary ti ti-circle-plus"></i>
                                            <label class="form-check-label"
                                                for="customCheckc1"><?php echo e($value->storage_limit == -1 ? __('Lifetime') : $value->storage_limit); ?>

                                                <?php echo e(__('MB Storage')); ?></label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="form-check text-start">
                                            <i class="text-primary ti ti-circle-plus"></i>
                                            <label class="form-check-label"
                                                for="customCheckc1"><?php echo e($value->enable_chatgpt == 'on' ? __('Enable Chat GPT') : __('Disable Chat GPT')); ?></label>
                                        </div>
                                    </li>
                                </ul>
                            </div> <!-- /.pr-body -->
                            <div class="pr-footer">
                                <a href="<?php echo e(route('register')); ?>" class="upgrade-button"><?php echo e(__('Start with Starter')); ?></a>
                            </div> <!-- /.pr-footer -->
                        </div> <!-- /.single-pr-table -->
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div> <!-- /.container -->
        </div>
        <?php endif; ?>

        <?php if($settings['testimonials_status'] == 'on'): ?>
        
        <section class="testimonials">
            <div class="container">
        
              <div class="row">
                <div class="col-sm-12">
                  <div class="container-fluid px-3 px-sm-5 my-5 text-center">
                    <h2 class="main-title"><?php echo $settings['testimonials_heading']; ?></h2>
                    <p><?php echo $settings['testimonials_description']; ?></p>
                  </div>
                  <div id="customers-testimonials" class="owl-carousel">
        
                    <!--TESTIMONIAL 1 -->
                    <?php if(is_array(json_decode($settings['testimonials'])) || is_object(json_decode($settings['testimonials']))): ?>
                        <?php $__currentLoopData = json_decode($settings['testimonials']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="item" style="width:100%;background: whitesmoke;padding: 25px;border-radius: 10px;">
                            <div class="">
                                <?php if(isset($value->testimonials_user_avtar)): ?>
                                    <img src="<?php echo e($logo . '/' . $value->testimonials_user_avtar); ?>" class="wid-40 rounded-circle me-3" style="width:200px;">
                                <?php endif; ?>
                                <span style="font-weight:bold;">
                                    <b class="fw-bold d-block"><?php echo e($value->testimonials_user); ?></b>
                                    <?php echo e($value->testimonials_designation); ?>

                                </span>
                                <hr>
                                <p><?php echo e($value->testimonials_description); ?></p>
                                <h6 class="name"><?php echo e($value->testimonials_title); ?></h6>
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

        <?php if($settings['faq_status'] == 'on'): ?>
        <div class="theme-title-one text-center hide-pr" style="margin-top:50px;" id="faqs">
            <h2 class="main-title"><?php echo e($settings['faq_title']); ?></h2>
            <p><?php echo $settings['faq_heading']; ?></p>
            <p><?php echo $settings['faq_description']; ?></p>
        </div>
        <div class="sass-faq-section">

            <div class="section-shape-one"><img src="<?php echo e(Module::asset('LandingPage:Resources/assets/new/images/shape/shape-18.svg')); ?>" alt=""></div>
            <img src="<?php echo e(Module::asset('LandingPage:Resources/assets/new/images/shape/shape-26.svg')); ?>" alt="" class="section-shape-two">
            <img src="<?php echo e(Module::asset('LandingPage:Resources/assets/new/images/shape/shape-29.svg')); ?>" alt="" class="section-shape-three">
            <img src="<?php echo e(Module::asset('LandingPage:Resources/assets/new/images/shape/shape-30.svg')); ?>" alt="" class="section-shape-four">
            <div class="container">
               
                <div class="faq-tab-wrapper">
                    <div class="tab-content">
                        <div id="payment" class="tab-pane fade show active">
                            <div class="row">
                                <?php if(is_array(json_decode($settings['faqs'], true)) || is_object(json_decode($settings['faqs'], true))): ?>
                                    <?php $__currentLoopData = json_decode($settings['faqs'], true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="col-12">
                                            <div class="panel-group theme-accordion" id="accordion<?php echo e($key); ?>">
                                                <div class="faq-panel">
                                                    <div class="panel">
                                                        <div class="panel-heading active-panel">
                                                            <h6 class="panel-title">
                                                            <a data-toggle="collapse" data-parent="#accordion<?php echo e($key); ?>" href="#collapse<?php echo e($key); ?>"><?php echo $value['faq_questions']; ?></a>
                                                            </h6>
                                                        </div>
                                                        <div id="collapse<?php echo e($key); ?>" class="panel-collapse collapse">
                                                            <div class="panel-body">
                                                                <p><?php echo $value['faq_answer']; ?></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </div> <!-- /.row -->
                        </div>
                    </div> <!-- /.tab-content -->
                </div> <!-- /.faq-tab-wrapper -->


                <a href="#footer" class="down-button scroll-target"><i class="fa fa-angle-down" aria-hidden="true"></i></a>
            </div> <!-- /.container -->
        </div>
        <?php endif; ?>

        <footer class="theme-footer-one" id="footer">
            <div class="shape-one" data-aos="zoom-in-right"></div>
            <img src="<?php echo e(Module::asset('LandingPage:Resources/assets/new/images/shape/shape-67.svg')); ?>" alt="" class="shape-two">
            <div class="top-footer">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-4 col-sm-6 col-12 about-widget" data-aos="fade-up">
                            <a href="<?php echo e(url('/')); ?>" class="logo"><img style="width:70px;" src="<?php echo e($logo . '/' . $settings['site_logo'] . '?' . time()); ?>" alt=""></a>
                            <p><?php echo $settings['site_description']; ?></p>
                        </div> <!-- /.about-widget -->
                        <div class="col-lg-4 col-lg-3 col-sm-6 col-12 footer-list" data-aos="fade-up">
                            <h5 class="title"><?php echo e(__('Our Pages')); ?></h5>
                            <ul>
                                <?php if(is_array(json_decode($settings['menubar_page'])) || is_object(json_decode($settings['menubar_page']))): ?>
                                    <?php $__currentLoopData = json_decode($settings['menubar_page']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(isset($value->footer) && $value->footer == 'on' && $value->header == 'off' && isset($value->template_name)): ?>
                                            <li><a
                                                    href="<?php echo e($value->template_name == 'page_content' ? route('custom.page', $value->page_slug) : $value->page_url); ?>"><?php echo e($value->menubar_page_name); ?></a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if(isset($value->footer) && $value->footer == 'on' && $value->header == 'on' && isset($value->template_name)): ?>
                                            <li><a
                                                    href="<?php echo e($value->template_name == 'page_content' ? route('custom.page', $value->page_slug) : $value->page_url); ?>"><?php echo e($value->menubar_page_name); ?></a>
                                            </li>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </ul>
                        </div> <!-- /.footer-recent-post -->
                        
                        <div class="col-lg-4 col-lg-2 col-sm-6 col-12 footer-information" data-aos="fade-up">
                            <h5 class="title"><?php echo $settings['joinus_heading']; ?></h5>
                            <p><?php echo $settings['joinus_description']; ?></p>
                            <?php if($settings['joinus_status'] == 'on'): ?>
                                <div class="ftr-col ftr-subscribe">
                                    <form method="post" action="<?php echo e(route('join_us_store')); ?>">
                                        <?php echo csrf_field(); ?>
                                        <input type="text" name="email" placeholder="<?php echo e(__('Type your email address')); ?>..." required class="form-control">
                                        <button type="submit" class="btn btn-dark rounded-pill mt-3"><?php echo e(__('Join Us!')); ?></button>
                                    </form>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div> <!-- /.row -->
                </div> <!-- /.container -->
            </div> <!-- /.top-footer -->
            
            <div class="container">
                <div class="bottom-footer">
                    <div class="clearfix">
                        <p>&copy;<?php echo e(date(' Y')); ?>

                            <?php echo e(App\Models\Utility::getValByName('footer_text') ? App\Models\Utility::getValByName('footer_text') : config('app.name', 'Resource Managment')); ?></p>
                        <ul>
                            <?php echo $__env->make('landingpage::layouts.buttons', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </ul>
                    </div>
                </div> <!-- /.bottom-footer -->
            </div>
        </footer>
        
        <button class="scroll-top tran3s">
            <i class="fa fa-angle-up" aria-hidden="true"></i>
        </button>

    </div>



    <script src="<?php echo e(Module::asset('LandingPage:Resources/assets/new/vendor/jquery.2.2.3.min.js')); ?>"></script>
    <script src="<?php echo e(Module::asset('LandingPage:Resources/assets/new/vendor/popper.js/popper.min.js')); ?>"></script>
    <script src="<?php echo e(Module::asset('LandingPage:Resources/assets/new/vendor/bootstrap/js/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(Module::asset('LandingPage:Resources/assets/new/vendor/mega-menu/assets/js/custom.js')); ?>"></script>
    <script src="<?php echo e(Module::asset('LandingPage:Resources/assets/new/vendor/aos-next/dist/aos.js')); ?>"></script>
    <script src="<?php echo e(Module::asset('LandingPage:Resources/assets/new/vendor/WOW-master/dist/wow.min.js')); ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="<?php echo e(Module::asset('LandingPage:Resources/assets/new/vendor/jquery.appear.js')); ?>"></script>
    <script src="<?php echo e(Module::asset('LandingPage:Resources/assets/new/vendor/jquery.countTo.js')); ?>"></script>
    <script src="<?php echo e(Module::asset('LandingPage:Resources/assets/new/vendor/fancybox/dist/jquery.fancybox.min.js')); ?>"></script>
    <script src="<?php echo e(Module::asset('LandingPage:Resources/assets/new/js/theme.js')); ?>"></script>

    


<?php echo $__env->yieldPushContent('custom-scripts'); ?>
<?php if($get_cookie['enable_cookie'] == 'on'): ?>
    <?php echo $__env->make('layouts.cookie_consent', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>
</body>

</html>
<?php /**PATH C:\xampp\htdocs\rezo2\Modules/LandingPage\Resources/views/layouts/landingpage.blade.php ENDPATH**/ ?>