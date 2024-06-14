<?php
    $users=\Auth::user();
    $profile=\App\Models\Utility::get_file('uploads/avatar/');
    $languages=\App\Models\Utility::languages();

    $lang = isset($users->lang)?$users->lang:'en';
    if ($lang == null) {
        $lang = 'en';
    }
    // $LangName = \App\Models\Language::where('code',$lang)->first();
    // $LangName =\App\Models\Language::languageData($lang);
    $LangName = cache()->remember('full_language_data_' . $lang, now()->addHours(24), function () use ($lang) {
    return \App\Models\Language::languageData($lang);
    });

    $setting = \App\Models\Utility::settings();

    $unseenCounter=App\Models\ChMessage::where('to_id', Auth::user()->id)->where('seen', 0)->count();
?>


<header id="page-header">
    <!-- Header Content -->
    <div class="content-header">
      <!-- Left Section -->
      <div class="space-x-1">
        <!-- Toggle Sidebar -->
        <!-- Layout API, functionality initialized in Template._uiApiLayout()-->
        <button type="button" class="btn btn-alt-secondary" data-toggle="layout" data-action="sidebar_toggle">
          <i class="fa fa-fw fa-bars"></i>
        </button>
        <!-- END Toggle Sidebar -->

        
      </div>
      <!-- END Left Section -->

      <!-- Right Section -->
      <div class="space-x-1">
        <!-- User Dropdown -->
        <div class="dropdown d-inline-block">
          <button type="button" class="btn btn-alt-secondary" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-fw fa-user d-sm-none"></i>
            <span class="d-none d-sm-inline-block"><?php echo e(\Auth::user()->name); ?></span>
            <i class="fa fa-fw fa-angle-down opacity-50 ms-1 d-none d-sm-inline-block"></i>
          </button>
          <div class="dropdown-menu dropdown-menu-end p-0" aria-labelledby="page-header-user-dropdown">
            <div class="bg-primary-dark rounded-top fw-semibold text-white text-center p-3">
                <img src="<?php echo e(!empty(\Auth::user()->avatar) ? $profile . \Auth::user()->avatar :  $profile.'avatar.png'); ?>" class="img-fluid rounded-circle" style="width:30px;">
                <?php echo e(__('Hi, ')); ?><?php echo e(\Auth::user()->name); ?>

            </div>
            <div class="p-2">
              <a class="dropdown-item" href="<?php echo e(route('profile')); ?>">
                <i class="far fa-fw fa-user me-1"></i> <?php echo e(__('Profile')); ?>

              </a>
              <a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();" class="dropdown-item">
                <i class="ti ti-power text-dark"></i><span><?php echo e(__('Logout')); ?></span>
                </a>

                <form id="frm-logout" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                    <?php echo e(csrf_field()); ?>

                </form>
            </div>
          </div>
        </div>
        
      </div>
      <!-- END Right Section -->
    </div>
    <!-- END Header Content -->

    <!-- Header Search -->
    <div id="page-header-search" class="overlay-header bg-header-dark">
      <div class="bg-white-10">
        <div class="content-header">
          <form class="w-100" action="be_pages_generic_search.html" method="POST">
            <div class="input-group">
              <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
              <button type="button" class="btn btn-alt-primary" data-toggle="layout" data-action="header_search_off">
                <i class="fa fa-fw fa-times-circle"></i>
              </button>
              <input type="text" class="form-control border-0" placeholder="Search or hit ESC.." id="page-header-search-input" name="page-header-search-input">
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- END Header Search -->

    <!-- Header Loader -->
    <!-- Please check out the Loaders page under Components category to see examples of showing/hiding it -->
    <div id="page-header-loader" class="overlay-header bg-header-dark">
      <div class="bg-white-10">
        <div class="content-header">
          <div class="w-100 text-center">
            <i class="fa fa-fw fa-sun fa-spin text-white"></i>
          </div>
        </div>
      </div>
    </div>
    <!-- END Header Loader -->
  </header>
<?php /**PATH C:\xampp\htdocs\rezo2\resources\views/partials/admin/header.blade.php ENDPATH**/ ?>