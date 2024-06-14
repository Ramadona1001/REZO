@php
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

@endphp

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">

    <title>{{ $setting['title_text'] ? $setting['title_text'] : config('app.name', 'ERPGO') }} - @yield('page-title')</title>

    <meta name="title" content="{{ $metatitle }}">
    <meta name="description" content="{{ $metsdesc }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ env('APP_URL') }}">
    <meta property="og:title" content="{{ $metatitle }}">
    <meta property="og:description" content="{{ $metsdesc }}">
    <meta property="og:image" content="{{ $meta_image . $meta_logo }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ env('APP_URL') }}">
    <meta property="twitter:title" content="{{ $metatitle }}">
    <meta property="twitter:description" content="{{ $metsdesc }}">
    <meta property="twitter:image" content="{{ $meta_image . $meta_logo }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <!-- Icons -->
    <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
    <link rel="icon"
        href="{{ $logo . '/' . (isset($company_favicon) && !empty($company_favicon) ? $company_favicon : 'favicon.png') }}"
        type="image" sizes="16x16">

    <!-- Stylesheets -->
    <!-- Dashmix framework -->
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables-responsive-bs5/css/responsive.bootstrap5.min.css') }}">
    <link rel="stylesheet" id="css-main" href="{{ asset('assets/css/dashmix.min.css') }}">
    {{-- <script src="{{ asset('js/jquery.min.js') }}"></script> --}}
    <style>
        .breadcrumb-item,.breadcrumb-item a{
            color:white !important;
        }
        .list-group-item.active{
            background:#1263be !important;
        }
    </style>
    
    @stack('css-page')
    
  </head>

  <body>
    
    <div id="page-container" class="sidebar-o sidebar-dark enable-page-overlay side-scroll page-header-fixed main-content-narrow">
        
        @include('partials.admin.menu2')
        @include('partials.admin.header')

      
        
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
        <div class="bg-image" style="background-image: url('{{ asset("assets/media/various/bg_dashboard.jpg") }}');">
          <div class="bg-primary-dark-op">
            <div class="content content-full">
              <div class="row my-3">
                <div class="col-md-6 d-md-flex align-items-md-center">
                  <div class="py-4 py-md-0 text-center text-md-start">
                    <h1 class="fs-2 text-white mb-2">@yield('page-title')</h1>
                    <ul class="breadcrumb">
                        @yield('breadcrumb')
                    </ul>
                  </div>
                </div>
                <div class="col-md-6 d-md-flex align-items-md-center">
                  <div class="row w-100 text-center">
                    <div class="col-12">
                        @yield('action-btn')
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
            @yield('content')
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
      @include('partials.admin.footer')
      {{-- @include('Chatify::layouts.footerLinks') --}}
      <!-- END Footer -->
    

  </body>
</html>
