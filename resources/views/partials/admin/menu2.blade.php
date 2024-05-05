@php
    use App\Models\Utility;
    $setting = \App\Models\Utility::settings();
    $logo = \App\Models\Utility::get_file('uploads/logo/');

    $company_logo = $setting['company_logo_dark'] ?? '';
    $company_logos = $setting['company_logo_light'] ?? '';
    $company_small_logo = $setting['company_small_logo'] ?? '';

    $emailTemplate = \App\Models\EmailTemplate::emailTemplateData();
    $lang = Auth::user()->lang;

    $userPlan = \App\Models\Plan::getPlan(\Auth::user()->show_dashboard());
@endphp
<nav id="sidebar" aria-label="Main Navigation">
  <!-- Side Header -->
  <div class="bg-header-dark">
    <div class="content-header bg-white-5">

      <a class="fw-semibold text-white tracking-wide" href="{{ route('dashboard') }}">
        <img src="{{ $logo . '/' . (isset($company_logos) && !empty($company_logos) ? $company_logos : 'logo-light.png') }}" alt="{{ config('app.name', 'Resource-Managment') }}" class="logo logo-lg" style="width:50px;">
      </a>
        <button type="button" class="btn btn-sm btn-alt-secondary d-lg-none" data-toggle="layout" data-action="sidebar_close">
        <i class="fa fa-times-circle"></i>
      </button>
    </div>
  </div>

  <div class="js-sidebar-scroll simplebar-scrollable-y" data-simplebar="init">
    <div class="simplebar-wrapper" style="margin: 0px;">
      <div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div>
      <div class="simplebar-mask">
        <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
          <div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: 100%; overflow: hidden scroll;">
            <div class="simplebar-content" style="padding: 0px;">
              <div class="content-side">
                @include('partials.admin.menu.not_client_menu')
                @include('partials.admin.menu.client_menu')
                @include('partials.admin.menu.super_admin')
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  

</nav>