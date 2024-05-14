<!DOCTYPE html>
<?php
    use App\Models\Utility;

    $setting = Utility::settings();
    $company_logo = $setting['company_logo_dark'] ?? '';
    $company_logos = $setting['company_logo_light'] ?? '';
    $company_favicon = $setting['company_favicon'] ?? '';

    $logo = \App\Models\Utility::get_file('uploads/logo/');

    $color = !empty($setting['color']) ? $setting['color'] : 'theme-3';

    if(isset($setting['color_flag']) && $setting['color_flag'] == 'true')
    {
        $themeColor = 'custom-color';
    }
    else {
        $themeColor = $color;
    }

    $company_logo = \App\Models\Utility::GetLogo();
    $SITE_RTL = isset($setting['SITE_RTL']) ? $setting['SITE_RTL'] : 'off';
    $lang = \App::getLocale('lang');
    if ($lang == 'ar' || $lang == 'he') {
        $SITE_RTL = 'on';
    }
    elseif($SITE_RTL == 'on') 
    {
        $SITE_RTL = 'on';        
    }
    else {
        $SITE_RTL = 'off';
    }
        
    $metatitle = isset($setting['meta_title']) ? $setting['meta_title'] : '';
    $metsdesc = isset($setting['meta_desc']) ? $setting['meta_desc'] : '';
    $meta_image = \App\Models\Utility::get_file('uploads/meta/');
    $meta_logo = isset($setting['meta_image']) ? $setting['meta_image'] : '';
    $get_cookie = isset($setting['enable_cookie']) ? $setting['enable_cookie'] : '';

?>


<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>"
    dir="<?php echo e($SITE_RTL == 'on' ? 'rtl' : ''); ?>">

<head>
    <title>
        <?php echo e(Utility::getValByName('title_text') ? Utility::getValByName('title_text') : config('app.name', 'Resource Managment')); ?> - <?php echo $__env->yieldContent('page-title'); ?></title>

    <meta name="title" content="<?php echo e($metatitle); ?>">
    <meta name="description" content="<?php echo e($metsdesc); ?>">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo e(env('APP_URL')); ?>">
    <meta property="og:title" content="<?php echo e($metatitle); ?>">
    <meta property="og:description" content="<?php echo e($metsdesc); ?>">
    <meta property="og:image" content="<?php echo e($meta_image . $meta_logo); ?>">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?php echo e(env('APP_URL')); ?>">
    <meta property="twitter:title" content="<?php echo e($metatitle); ?>">
    <meta property="twitter:description" content="<?php echo e($metsdesc); ?>">
    <meta property="twitter:image" content="<?php echo e($meta_image . $meta_logo); ?>">


    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="Dashboard Template Description" />
    <meta name="keywords" content="Dashboard Template" />
    <meta name="author" content="Rajodiya Infotech" />

    <!-- Favicon icon -->
    <link rel="icon" href="<?php echo e($logo . '/' . (isset($company_favicon) && !empty($company_favicon) ? $company_favicon : 'favicon.png')); ?>" type="image/x-icon" />

    <link rel="stylesheet" id="css-main" href="<?php echo e(asset('assets/css/dashmix.min.css')); ?>">

</head>

<body>

    <div id="page-container">

        <!-- Main Container -->
        <main id="main-container">
  
          <!-- Page Content -->
          <div class="bg-image" style="background-image: url('<?php echo e(asset("assets/media/photos/photo22@2x.jpg")); ?>');">
            <div class="row g-0 bg-primary-op">
              <!-- Main Section -->
              <div class="hero-static col-md-6 d-flex align-items-center bg-body-extra-light">
                <div class="p-3 w-100">
                  <!-- Header -->
                  <div class="mb-3 text-center">
                    <?php if($setting['cust_darklayout'] == 'on'): ?>
                        <img class="logo" style=" width: 100px; margin-bottom: 10px; display: block; margin-left: auto; margin-right: auto; "
                            src="<?php echo e($logo . (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo-light.png') . '?' . time()); ?>"
                            alt="" loading="lazy"/>
                    <?php else: ?>
                        <img class="logo" style=" width: 100px; margin-bottom: 10px; display: block; margin-left: auto; margin-right: auto; "
                            src="<?php echo e($logo . (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo-dark.png') . '?' . time()); ?>"
                            alt="" loading="lazy"/>
                    <?php endif; ?>
                  </div>
                  <!-- END Header -->
                  
                  <div class="row g-0 justify-content-center">
                    <div class="col-sm-8 col-xl-6">
                      <?php echo $__env->yieldContent('content'); ?>
                    </div>
                  </div>
                  <!-- END Sign In Form -->
                </div>
              </div>
              <!-- END Main Section -->
  
              <!-- Meta Info Section -->
              <div class="hero-static col-md-6 d-none d-md-flex align-items-md-center justify-content-md-center text-md-center">
                <div class="p-3">
                  <p class="display-4 fw-bold text-white mb-3">
                    <?php echo e(__('Welcome to')); ?> <?php echo e(Utility::getValByName('title_text') ? Utility::getValByName('title_text') : config('app.name', 'Resource Managment')); ?>

                  </p>
                  <p class="fs-lg fw-semibold text-white-75 mb-0">
                    &copy; <?php echo e(date('Y')); ?>

                                    <?php echo e(App\Models\Utility::getValByName('footer_text') ? App\Models\Utility::getValByName('footer_text') : config('app.name', 'Resource Managment')); ?>

                  </p>
                </div>
              </div>
              <!-- END Meta Info Section -->
            </div>
          </div>
          <!-- END Page Content -->
        </main>
        <!-- END Main Container -->
      </div>
    

    <?php if($get_cookie == 'on'): ?>
        <?php echo $__env->make('layouts.cookie_consent', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>

    <!-- [ auth-signup ] end -->

    <!-- Required Js -->
    <script src="<?php echo e(asset('assets/js/dashmix.app.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/dashmix.app.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/dashmix.app.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/dashmix.app.min.js')); ?>"></script>

    <script>
        feather.replace();
    </script>

    <?php if(\App\Models\Utility::getValByName('cust_darklayout') == 'on'): ?>
        <style>
            .g-recaptcha {
                filter: invert(1) hue-rotate(180deg) !important;
            }
        </style>
    <?php endif; ?>


    <script>
        feather.replace();
        var pctoggle = document.querySelector("#pct-toggler");
        if (pctoggle) {
            pctoggle.addEventListener("click", function() {
                if (
                    !document.querySelector(".pct-customizer").classList.contains("active")
                ) {
                    document.querySelector(".pct-customizer").classList.add("active");
                } else {
                    document.querySelector(".pct-customizer").classList.remove("active");
                }
            });
        }

        var themescolors = document.querySelectorAll(".themes-color > a");
        for (var h = 0; h < themescolors.length; h++) {
            var c = themescolors[h];

            c.addEventListener("click", function(event) {
                var targetElement = event.target;
                if (targetElement.tagName == "SPAN") {
                    targetElement = targetElement.parentNode;
                }
                var temp = targetElement.getAttribute("data-value");
                removeClassByPrefix(document.querySelector("body"), "theme-");
                document.querySelector("body").classList.add(temp);
            });
        }
        function removeClassByPrefix(node, prefix) {
            for (let i = 0; i < node.classList.length; i++) {
                let value = node.classList[i];
                if (value.startsWith(prefix)) {
                    node.classList.remove(value);
                }
            }
        }
    </script>
    <?php echo $__env->yieldPushContent('custom-scripts'); ?>

</body>

</html>
<?php /**PATH C:\xampp\htdocs\rezo2\resources\views/layouts/auth.blade.php ENDPATH**/ ?>