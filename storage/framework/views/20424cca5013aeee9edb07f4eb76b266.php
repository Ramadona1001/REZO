<?php
    use App\Models\Utility;
    $setting = \App\Models\Utility::settings();

    $logo = \App\Models\Utility::get_file('uploads/logo');
    $company_favicon = $setting['company_favicon'] ?? '';

    $color = !empty($setting['color']) ? $setting['color'] : 'theme-3';

    if(isset($setting['color_flag']) && $setting['color_flag'] == 'true')
    {
        $themeColor = 'custom-color';
    }
    else {
        $themeColor = $color;
    }

    $SITE_RTL = $setting['SITE_RTL'] ?? '';

    $lang = \App::getLocale('lang');
    if ($lang == 'ar' || $lang == 'he') {
        $SITE_RTL = 'on';
    }
    
    $metatitle = isset($setting['meta_title']) ? $setting['meta_title'] : '';
    $metsdesc = isset($setting['meta_desc']) ? $setting['meta_desc'] : '';
    $meta_image = \App\Models\Utility::get_file('uploads/meta/');
    $meta_logo = isset($setting['meta_image']) ? $setting['meta_image'] : '';

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">

    <title><?php echo e($setting['title_text'] ? $setting['title_text'] : config('app.name', 'ERPGO')); ?> - <?php echo $__env->yieldContent('page-title'); ?></title>

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

    <!-- Icons -->
    <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
    <link rel="icon"
        href="<?php echo e($logo . '/' . (isset($company_favicon) && !empty($company_favicon) ? $company_favicon : 'favicon.png')); ?>"
        type="image" sizes="16x16">

    <!-- Stylesheets -->
    <!-- Dashmix framework -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/js/plugins/datatables-responsive-bs5/css/responsive.bootstrap5.min.css')); ?>">
    <link rel="stylesheet" id="css-main" href="<?php echo e(asset('assets/css/dashmix.min.css')); ?>">
    
    <style>
        .breadcrumb-item,.breadcrumb-item a{
            color:white !important;
        }
        .list-group-item.active{
            background:#1263be !important;
        }
    </style>
    <?php echo $__env->yieldPushContent('css-page'); ?>
  </head>

  <body>
    
    <div id="page-container" class="sidebar-o sidebar-dark enable-page-overlay side-scroll page-header-fixed main-content-narrow">
     
        <aside id="side-overlay">
            <!-- Side Header -->
            <div class="bg-image" style="background-image: url('assets/media/various/bg_side_overlay_header.jpg');">
                <div class="bg-primary-op">
                <div class="content-header">
                    <!-- User Avatar -->
                    <a class="img-link me-1" href="be_pages_generic_profile.html">
                    <img class="img-avatar img-avatar48" src="assets/media/avatars/avatar10.jpg" alt="">
                    </a>
                    <!-- END User Avatar -->

                    <!-- User Info -->
                    <div class="ms-2">
                    <a class="text-white fw-semibold" href="be_pages_generic_profile.html">George Taylor</a>
                    <div class="text-white-75 fs-sm">Full Stack Developer</div>
                    </div>
                    <!-- END User Info -->

                    <!-- Close Side Overlay -->
                    <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                    <a class="ms-auto text-white" href="javascript:void(0)" data-toggle="layout" data-action="side_overlay_close">
                    <i class="fa fa-times-circle"></i>
                    </a>
                    <!-- END Close Side Overlay -->
                </div>
                </div>
            </div>
            <!-- END Side Header -->

            <!-- Side Content -->
            <div class="content-side">
                <!-- Side Overlay Tabs -->
                <div class="block block-transparent pull-x pull-t mb-0">
                <ul class="nav nav-tabs nav-tabs-block nav-justified" role="tablist">
                    <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="so-settings-tab" data-bs-toggle="tab" data-bs-target="#so-settings" role="tab" aria-controls="so-settings" aria-selected="true">
                        <i class="fa fa-fw fa-cog"></i>
                    </button>
                    </li>
                    <li class="nav-item" role="presentation">
                    <button class="nav-link" id="so-people-tab" data-bs-toggle="tab" data-bs-target="#so-people" role="tab" aria-controls="so-people" aria-selected="false">
                        <i class="far fa-fw fa-user-circle"></i>
                    </button>
                    </li>
                    <li class="nav-item" role="presentation">
                    <button class="nav-link" id="so-profile-tab" data-bs-toggle="tab" data-bs-target="#so-profile" role="tab" aria-controls="so-profile" aria-selected="false">
                        <i class="far fa-fw fa-edit"></i>
                    </button>
                    </li>
                </ul>
                <div class="block-content tab-content overflow-hidden">
                    <!-- Settings Tab -->
                    <div class="tab-pane pull-x fade fade-up show active" id="so-settings" role="tabpanel" aria-labelledby="so-settings-tab" tabindex="0">
                    <div class="block mb-0">
                        <!-- Color Themes -->
                        <!-- Toggle Themes functionality initialized in Template._uiHandleTheme() -->
                        <div class="block-content block-content-sm block-content-full bg-body">
                        <span class="text-uppercase fs-sm fw-bold">Color Themes</span>
                        </div>
                        <div class="block-content block-content-full">
                        <div class="row g-sm text-center">
                            <div class="col-4 mb-1">
                            <a class="d-block py-3 text-white fs-sm fw-semibold bg-default" data-toggle="theme" data-theme="default" href="#">
                                Default
                            </a>
                            </div>
                            <div class="col-4 mb-1">
                            <a class="d-block py-3 text-white fs-sm fw-semibold bg-xwork" data-toggle="theme" data-theme="assets/css/themes/xwork.min.css" href="#">
                                xWork
                            </a>
                            </div>
                            <div class="col-4 mb-1">
                            <a class="d-block py-3 text-white fs-sm fw-semibold bg-xmodern" data-toggle="theme" data-theme="assets/css/themes/xmodern.min.css" href="#">
                                xModern
                            </a>
                            </div>
                            <div class="col-4 mb-1">
                            <a class="d-block py-3 text-white fs-sm fw-semibold bg-xeco" data-toggle="theme" data-theme="assets/css/themes/xeco.min.css" href="#">
                                xEco
                            </a>
                            </div>
                            <div class="col-4 mb-1">
                            <a class="d-block py-3 text-white fs-sm fw-semibold bg-xsmooth" data-toggle="theme" data-theme="assets/css/themes/xsmooth.min.css" href="#">
                                xSmooth
                            </a>
                            </div>
                            <div class="col-4 mb-1">
                            <a class="d-block py-3 text-white fs-sm fw-semibold bg-xinspire" data-toggle="theme" data-theme="assets/css/themes/xinspire.min.css" href="#">
                                xInspire
                            </a>
                            </div>
                            <div class="col-4 mb-1">
                            <a class="d-block py-3 text-white fs-sm fw-semibold bg-xdream" data-toggle="theme" data-theme="assets/css/themes/xdream.min.css" href="#">
                                xDream
                            </a>
                            </div>
                            <div class="col-4 mb-1">
                            <a class="d-block py-3 text-white fs-sm fw-semibold bg-xpro" data-toggle="theme" data-theme="assets/css/themes/xpro.min.css" href="#">
                                xPro
                            </a>
                            </div>
                            <div class="col-4 mb-1">
                            <a class="d-block py-3 text-white fs-sm fw-semibold bg-xplay" data-toggle="theme" data-theme="assets/css/themes/xplay.min.css" href="#">
                                xPlay
                            </a>
                            </div>
                            <div class="col-12">
                            <a class="d-block py-3 bg-body-dark fw-semibold text-dark" href="be_ui_color_themes.html">All Color Themes</a>
                            </div>
                        </div>
                        </div>
                        <!-- END Color Themes -->

                        <!-- Sidebar -->
                        <div class="block-content block-content-sm block-content-full bg-body">
                        <span class="text-uppercase fs-sm fw-bold">Sidebar</span>
                        </div>
                        <div class="block-content block-content-full">
                        <div class="row g-sm text-center">
                            <div class="col-6 mb-1">
                            <a class="d-block py-3 bg-body-dark fw-semibold text-dark" data-toggle="layout" data-action="sidebar_style_dark" href="javascript:void(0)">Dark</a>
                            </div>
                            <div class="col-6 mb-1">
                            <a class="d-block py-3 bg-body-dark fw-semibold text-dark" data-toggle="layout" data-action="sidebar_style_light" href="javascript:void(0)">Light</a>
                            </div>
                        </div>
                        </div>
                        <!-- END Sidebar -->

                        <!-- Header -->
                        <div class="block-content block-content-sm block-content-full bg-body">
                        <span class="text-uppercase fs-sm fw-bold">Header</span>
                        </div>
                        <div class="block-content block-content-full">
                        <div class="row g-sm text-center mb-2">
                            <div class="col-6 mb-1">
                            <a class="d-block py-3 bg-body-dark fw-semibold text-dark" data-toggle="layout" data-action="header_style_dark" href="javascript:void(0)">Dark</a>
                            </div>
                            <div class="col-6 mb-1">
                            <a class="d-block py-3 bg-body-dark fw-semibold text-dark" data-toggle="layout" data-action="header_style_light" href="javascript:void(0)">Light</a>
                            </div>
                            <div class="col-6 mb-1">
                            <a class="d-block py-3 bg-body-dark fw-semibold text-dark" data-toggle="layout" data-action="header_mode_fixed" href="javascript:void(0)">Fixed</a>
                            </div>
                            <div class="col-6 mb-1">
                            <a class="d-block py-3 bg-body-dark fw-semibold text-dark" data-toggle="layout" data-action="header_mode_static" href="javascript:void(0)">Static</a>
                            </div>
                        </div>
                        </div>
                        <!-- END Header -->

                        <!-- Content -->
                        <div class="block-content block-content-sm block-content-full bg-body">
                        <span class="text-uppercase fs-sm fw-bold">Content</span>
                        </div>
                        <div class="block-content block-content-full">
                        <div class="row g-sm text-center">
                            <div class="col-6 mb-1">
                            <a class="d-block py-3 bg-body-dark fw-semibold text-dark" data-toggle="layout" data-action="content_layout_boxed" href="javascript:void(0)">Boxed</a>
                            </div>
                            <div class="col-6 mb-1">
                            <a class="d-block py-3 bg-body-dark fw-semibold text-dark" data-toggle="layout" data-action="content_layout_narrow" href="javascript:void(0)">Narrow</a>
                            </div>
                            <div class="col-12 mb-1">
                            <a class="d-block py-3 bg-body-dark fw-semibold text-dark" data-toggle="layout" data-action="content_layout_full_width" href="javascript:void(0)">Full Width</a>
                            </div>
                        </div>
                        </div>
                        <!-- END Content -->

                        <!-- Layout API -->
                        <div class="block-content block-content-full border-top">
                        <a class="btn w-100 btn-alt-primary" href="be_layout_api.html">
                            <i class="fa fa-fw fa-flask me-1"></i> Layout API
                        </a>
                        </div>
                        <!-- END Layout API -->
                    </div>
                    </div>
                    <!-- END Settings Tab -->

                    <!-- People -->
                    <div class="tab-pane pull-x fade fade-up" id="so-people" role="tabpanel" aria-labelledby="so-people-tab" tabindex="0">
                    <div class="block mb-0">
                        <!-- Online -->
                        <div class="block-content block-content-sm block-content-full bg-body">
                        <span class="text-uppercase fs-sm fw-bold">Online</span>
                        </div>
                        <div class="block-content">
                        <ul class="nav-items">
                            <li>
                            <a class="d-flex py-2" href="be_pages_generic_profile.html">
                                <div class="flex-shrink-0 mx-3 overlay-container">
                                <img class="img-avatar img-avatar48" src="assets/media/avatars/avatar7.jpg" alt="">
                                <span class="overlay-item item item-tiny item-circle border border-2 border-white bg-success"></span>
                                </div>
                                <div class="flex-grow-1">
                                <div class="fw-semibold">Danielle Jones</div>
                                <div class="fs-sm text-muted">Photographer</div>
                                </div>
                            </a>
                            </li>
                            <li>
                            <a class="d-flex py-2" href="be_pages_generic_profile.html">
                                <div class="flex-shrink-0 mx-3 overlay-container">
                                <img class="img-avatar img-avatar48" src="assets/media/avatars/avatar14.jpg" alt="">
                                <span class="overlay-item item item-tiny item-circle border border-2 border-white bg-success"></span>
                                </div>
                                <div class="flex-grow-1">
                                <div class="fw-semibold">Brian Stevens</div>
                                <div class="fw-normal fs-sm text-muted">Web Designer</div>
                                </div>
                            </a>
                            </li>
                            <li>
                            <a class="d-flex py-2" href="be_pages_generic_profile.html">
                                <div class="flex-shrink-0 mx-3 overlay-container">
                                <img class="img-avatar img-avatar48" src="assets/media/avatars/avatar2.jpg" alt="">
                                <span class="overlay-item item item-tiny item-circle border border-2 border-white bg-success"></span>
                                </div>
                                <div class="flex-grow-1">
                                <div class="fw-semibold">Helen Jacobs</div>
                                <div class="fw-normal fs-sm text-muted">Web Developer</div>
                                </div>
                            </a>
                            </li>
                        </ul>
                        </div>
                        <!-- Online -->

                        <!-- Busy -->
                        <div class="block-content block-content-sm block-content-full bg-body">
                        <span class="text-uppercase fs-sm fw-bold">Busy</span>
                        </div>
                        <div class="block-content">
                        <ul class="nav-items">
                            <li>
                            <a class="d-flex py-2" href="be_pages_generic_profile.html">
                                <div class="flex-shrink-0 mx-3 overlay-container">
                                <img class="img-avatar img-avatar48" src="assets/media/avatars/avatar6.jpg" alt="">
                                <span class="overlay-item item item-tiny item-circle border border-2 border-white bg-danger"></span>
                                </div>
                                <div class="flex-grow-1">
                                <div class="fw-semibold">Lori Grant</div>
                                <div class="fw-normal fs-sm text-muted">UI Designer</div>
                                </div>
                            </a>
                            </li>
                        </ul>
                        </div>
                        <!-- END Busy -->

                        <!-- Away -->
                        <div class="block-content block-content-sm block-content-full bg-body">
                        <span class="text-uppercase fs-sm fw-bold">Away</span>
                        </div>
                        <div class="block-content">
                        <ul class="nav-items">
                            <li>
                            <a class="d-flex py-2" href="be_pages_generic_profile.html">
                                <div class="flex-shrink-0 mx-3 overlay-container">
                                <img class="img-avatar img-avatar48" src="assets/media/avatars/avatar15.jpg" alt="">
                                <span class="overlay-item item item-tiny item-circle border border-2 border-white bg-warning"></span>
                                </div>
                                <div class="flex-grow-1">
                                <div class="fw-semibold">Henry Harrison</div>
                                <div class="fw-normal fs-sm text-muted">Copywriter</div>
                                </div>
                            </a>
                            </li>
                            <li>
                            <a class="d-flex py-2" href="be_pages_generic_profile.html">
                                <div class="flex-shrink-0 mx-3 overlay-container">
                                <img class="img-avatar img-avatar48" src="assets/media/avatars/avatar2.jpg" alt="">
                                <span class="overlay-item item item-tiny item-circle border border-2 border-white bg-warning"></span>
                                </div>
                                <div class="flex-grow-1">
                                <div class="fw-semibold">Barbara Scott</div>
                                <div class="fw-normal fs-sm text-muted">Writer</div>
                                </div>
                            </a>
                            </li>
                        </ul>
                        </div>
                        <!-- END Away -->

                        <!-- Offline -->
                        <div class="block-content block-content-sm block-content-full bg-body">
                        <span class="text-uppercase fs-sm fw-bold">Offline</span>
                        </div>
                        <div class="block-content">
                        <ul class="nav-items">
                            <li>
                            <a class="d-flex py-2" href="be_pages_generic_profile.html">
                                <div class="flex-shrink-0 mx-3 overlay-container">
                                <img class="img-avatar img-avatar48" src="assets/media/avatars/avatar15.jpg" alt="">
                                <span class="overlay-item item item-tiny item-circle border border-2 border-white bg-muted"></span>
                                </div>
                                <div class="flex-grow-1">
                                <div class="fw-semibold">David Fuller</div>
                                <div class="fw-normal fs-sm text-muted">Teacher</div>
                                </div>
                            </a>
                            </li>
                            <li>
                            <a class="d-flex py-2" href="be_pages_generic_profile.html">
                                <div class="flex-shrink-0 mx-3 overlay-container">
                                <img class="img-avatar img-avatar48" src="assets/media/avatars/avatar1.jpg" alt="">
                                <span class="overlay-item item item-tiny item-circle border border-2 border-white bg-muted"></span>
                                </div>
                                <div class="flex-grow-1">
                                <div class="fw-semibold">Marie Duncan</div>
                                <div class="fw-normal fs-sm text-muted">Photographer</div>
                                </div>
                            </a>
                            </li>
                            <li>
                            <a class="d-flex py-2" href="be_pages_generic_profile.html">
                                <div class="flex-shrink-0 mx-3 overlay-container">
                                <img class="img-avatar img-avatar48" src="assets/media/avatars/avatar4.jpg" alt="">
                                <span class="overlay-item item item-tiny item-circle border border-2 border-white bg-muted"></span>
                                </div>
                                <div class="flex-grow-1">
                                <div class="fw-semibold">Lisa Jenkins</div>
                                <div class="fw-normal fs-sm text-muted">Front-end Developer</div>
                                </div>
                            </a>
                            </li>
                            <li>
                            <a class="d-flex py-2" href="be_pages_generic_profile.html">
                                <div class="flex-shrink-0 mx-3 overlay-container">
                                <img class="img-avatar img-avatar48" src="assets/media/avatars/avatar11.jpg" alt="">
                                <span class="overlay-item item item-tiny item-circle border border-2 border-white bg-muted"></span>
                                </div>
                                <div class="flex-grow-1">
                                <div class="fw-semibold">Jack Greene</div>
                                <div class="fw-normal fs-sm text-muted">UX Specialist</div>
                                </div>
                            </a>
                            </li>
                        </ul>
                        </div>
                        <!-- END Offline -->

                        <!-- Add People -->
                        <div class="block-content block-content-full border-top">
                        <a class="btn w-100 btn-alt-primary" href="javascript:void(0)">
                            <i class="fa fa-fw fa-plus me-1 opacity-50"></i> Add People
                        </a>
                        </div>
                        <!-- END Add People -->
                    </div>
                    </div>
                    <!-- END People -->

                    <!-- Profile -->
                    <div class="tab-pane pull-x fade fade-up" id="so-profile" role="tabpanel" aria-labelledby="so-profile-tab" tabindex="0">
                    <form action="be_pages_dashboard.html" method="POST" onsubmit="return false;">
                        <div class="block mb-0">
                        <!-- Personal -->
                        <div class="block-content block-content-sm block-content-full bg-body">
                            <span class="text-uppercase fs-sm fw-bold">Personal</span>
                        </div>
                        <div class="block-content block-content-full">
                            <div class="mb-4">
                            <label class="form-label">Username</label>
                            <input type="text" readonly class="form-control" id="so-profile-username-static" value="Admin">
                            </div>
                            <div class="mb-4">
                            <label class="form-label" for="so-profile-name">Name</label>
                            <input type="text" class="form-control" id="so-profile-name" name="so-profile-name" value="George Taylor">
                            </div>
                            <div class="mb-4">
                            <label class="form-label" for="so-profile-email">Email</label>
                            <input type="email" class="form-control" id="so-profile-email" name="so-profile-email" value="g.taylor@example.com">
                            </div>
                        </div>
                        <!-- END Personal -->

                        <!-- Password Update -->
                        <div class="block-content block-content-sm block-content-full bg-body">
                            <span class="text-uppercase fs-sm fw-bold">Password Update</span>
                        </div>
                        <div class="block-content block-content-full">
                            <div class="mb-4">
                            <label class="form-label" for="so-profile-password">Current Password</label>
                            <input type="password" class="form-control" id="so-profile-password" name="so-profile-password">
                            </div>
                            <div class="mb-4">
                            <label class="form-label" for="so-profile-new-password">New Password</label>
                            <input type="password" class="form-control" id="so-profile-new-password" name="so-profile-new-password">
                            </div>
                            <div class="mb-4">
                            <label class="form-label" for="so-profile-new-password-confirm">Confirm New Password</label>
                            <input type="password" class="form-control" id="so-profile-new-password-confirm" name="so-profile-new-password-confirm">
                            </div>
                        </div>
                        <!-- END Password Update -->

                        <!-- Options -->
                        <div class="block-content block-content-sm block-content-full bg-body">
                            <span class="text-uppercase fs-sm fw-bold">Options</span>
                        </div>
                        <div class="block-content">
                            <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="so-settings-status" name="so-settings-status">
                            <label class="form-check-label fw-semibold" for="so-settings-status">Online Status</label>
                            </div>
                            <p class="text-muted fs-sm">
                            Make your online status visible to other users of your app
                            </p>
                            <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="so-settings-notifications" name="so-settings-notifications">
                            <label class="form-check-label fw-semibold" for="so-settings-notifications">Notifications</label>
                            </div>
                            <p class="text-muted fs-sm">
                            Receive desktop notifications regarding your projects and sales
                            </p>
                            <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="so-settings-updates" name="so-settings-updates">
                            <label class="form-check-label fw-semibold" for="so-settings-updates">Auto Updates</label>
                            </div>
                            <p class="text-muted fs-sm">
                            If enabled, we will keep all your applications and servers up to date with the most recent features automatically
                            </p>
                        </div>
                        <!-- END Options -->

                        <!-- Submit -->
                        <div class="block-content block-content-full border-top">
                            <button type="submit" class="btn w-100 btn-alt-primary">
                            <i class="fa fa-fw fa-save me-1 opacity-50"></i> Save
                            </button>
                        </div>
                        <!-- END Submit -->
                        </div>
                    </form>
                    </div>
                    <!-- END Profile -->
                </div>
                </div>
                <!-- END Side Overlay Tabs -->
            </div>
            <!-- END Side Content -->
        </aside>

        
        <?php echo $__env->make('partials.admin.menu2', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('partials.admin.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

      
        
        <div class="modal notification-modal fade" id="notification-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="btn-close float-end" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                        <h6 class="mt-2">
                            <i data-feather="monitor" class="me-2"></i>Desktop settings
                        </h6>
                        <hr />
                        <div class="form-check form-switch">
                            <input type="checkbox" class="form-check-input" id="pcsetting1" checked />
                            <label class="form-check-label f-w-600 pl-1" for="pcsetting1">Allow desktop notification</label>
                        </div>
                        <p class="text-muted ms-5">
                            you get lettest content at a time when data will updated
                        </p>
                        <div class="form-check form-switch">
                            <input type="checkbox" class="form-check-input" id="pcsetting2" />
                            <label class="form-check-label f-w-600 pl-1" for="pcsetting2">Store Cookie</label>
                        </div>
                        <h6 class="mb-0 mt-5">
                            <i data-feather="save" class="me-2"></i>Application settings
                        </h6>
                        <hr />
                        <div class="form-check form-switch">
                            <input type="checkbox" class="form-check-input" id="pcsetting3" />
                            <label class="form-check-label f-w-600 pl-1" for="pcsetting3">Backup Storage</label>
                        </div>
                        <p class="text-muted mb-4 ms-5">
                            Automaticaly take backup as par schedule
                        </p>
                        <div class="form-check form-switch">
                            <input type="checkbox" class="form-check-input" id="pcsetting4" />
                            <label class="form-check-label f-w-600 pl-1" for="pcsetting4">Allow guest to print
                                file</label>
                        </div>
                        <h6 class="mb-0 mt-5">
                            <i data-feather="cpu" class="me-2"></i>System settings
                        </h6>
                        <hr />
                        <div class="form-check form-switch">
                            <input type="checkbox" class="form-check-input" id="pcsetting5" checked />
                            <label class="form-check-label f-w-600 pl-1" for="pcsetting5">View other user chat</label>
                        </div>
                        <p class="text-muted ms-5">Allow to show public user message</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-danger btn-sm" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="button" class="btn btn-light-primary btn-sm">
                            Save changes
                        </button>
                    </div>
                </div>
            </div>
        </div>
      <main id="main-container">

        <!-- Hero -->
        <div class="bg-image" style="background-image: url('<?php echo e(asset("assets/media/various/bg_dashboard.jpg")); ?>');">
          <div class="bg-primary-dark-op">
            <div class="content content-full">
              <div class="row my-3">
                <div class="col-md-6 d-md-flex align-items-md-center">
                  <div class="py-4 py-md-0 text-center text-md-start">
                    <h1 class="fs-2 text-white mb-2"><?php echo $__env->yieldContent('page-title'); ?></h1>
                    <ul class="breadcrumb">
                        <?php echo $__env->yieldContent('breadcrumb'); ?>
                    </ul>
                  </div>
                </div>
                <div class="col-md-6 d-md-flex align-items-md-center">
                  <div class="row w-100 text-center">
                    <div class="col-12">
                        <?php echo $__env->yieldContent('action-btn'); ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- END Hero -->

        <!-- Page Content -->
        <div class="container" style="margin-bottom: 30px;margin-top: 30px;">
            <?php echo $__env->yieldContent('content'); ?>
        </div>

        <div class="modal fade" id="commonModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="body">
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="commonModalOver" tabindex="-1" role="dialog" aria-labelledby="commonModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="commonModalLabel"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    </div>
                </div>
            </div>
        </div>

        <div class="position-fixed top-0 end-0 p-3" style="z-index: 99999">
            <div id="liveToast" class="toast text-white fade" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body"></div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
        </div>
        <!-- END Page Content -->
      </main>
      <!-- END Main Container -->

      <!-- Footer -->
      <?php echo $__env->make('partials.admin.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php echo $__env->make('Chatify::layouts.footerLinks', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <!-- END Footer -->
    

  </body>
</html>
<?php /**PATH C:\xampp\htdocs\rezo2\resources\views/layouts/admin.blade.php ENDPATH**/ ?>