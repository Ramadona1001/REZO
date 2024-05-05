@if (\Auth::user()->type == 'super admin')
   <ul class="nav-main">
      @if (Gate::check('manage super admin dashboard'))
      <li class="nav-main-item">
         <a href="{{ route('client.dashboard.view') }}" class="nav-main-link {{ Request::segment(1) == 'dashboard' ? ' active' : '' }}">
            <i class="nav-main-link-icon fa fa-home"></i>
            <span class="nav-main-link-name">{{ __('Dashboard') }}</span>
         </a>
      </li>
      @endif
      @can('manage user')
      <li
         class="nav-main-item">
         <a href="{{ route('users.index') }}" class="nav-main-link {{ Request::route()->getName() == 'users.index' || Request::route()->getName() == 'users.create' || Request::route()->getName() == 'users.edit' ? ' active' : '' }}">
            <i class="nav-main-link-icon fa fa-users"></i>
            <span class="nav-main-link-name">{{ __('Companies') }}</span>
         </a>
      </li>
      @endcan
      @if (Gate::check('manage plan'))
      <li class="nav-main-item">
         <a href="{{ route('plans.index') }}" class="nav-main-link {{ Request::segment(1) == 'plans' ? 'active' : '' }}">
            <i class="nav-main-link-icon fa fa-trophy"></i>
            <span class="nav-main-link-name">{{ __('Plans') }}</span>
         </a>
      </li>
      @endif
      @if (\Auth::user()->type == 'super admin')
      <li class="nav-main-item">
         <a href="{{ route('plan_request.index') }}" class="nav-main-link {{ request()->is('plan_request*') ? 'active' : '' }}">
            <i class="nav-main-link-icon fa fa-trophy"></i>
            <span class="nav-main-link-name">{{ __('Plans Requests') }}</span>
         </a>
      </li>
      @endif
      {{-- @if (Gate::check('manage coupon'))
      <li class="nav-main-item {{ Request::segment(1) == 'coupons' ? 'active' : '' }}">
         <a href="{{ route('coupons.index') }}" class="nav-main-link">
         <span class="dash-micon"><i class="ti ti-gift"></i></span><span
            class="dash-mtext">{{ __('Coupon') }}</span>
         </a>
      </li>
      @endif --}}
      @if (Gate::check('manage order'))
      <li class="nav-main-item  ">
         <a href="{{ route('order.index') }}" class="nav-main-link {{ Request::segment(1) == 'order' ? 'active' : '' }}">
            <i class="nav-main-link-icon fa fa-cart-plus"></i>
            <span class="nav-main-link-name">{{ __('Orders') }}</span>
         </a>
      </li>
      @endif
      {{-- <li
         class="nav-main-item {{ Request::segment(1) == 'email_template' || Request::route()->getName() == 'manage.email.language' ? ' active dash-trigger' : 'collapsed' }}">
         <a href="{{ route('manage.email.language', [$emailTemplate->id, \Auth::user()->lang]) }}"
            class="dash-link">
         <span class="dash-micon"><i class="ti ti-template"></i></span>
         <span class="dash-mtext">{{ __('Email Template') }}</span>
         </a>
      </li> --}}
     
      @if (\Auth::user()->type == 'super admin')
      @include('landingpage::menu.landingpage')
      @endif
      @if (Gate::check('manage system settings'))
      <li
         class="nav-main-item ">
         <a href="{{ route('systems.index') }}" class="nav-main-link {{ Request::route()->getName() == 'systems.index' ? ' active' : '' }}">
            <i class="nav-main-link-icon fa fa-gear"></i>
            <span class="nav-main-link-name">{{ __('Settings') }}</span>
         </a>
      </li>
      @endif


      <li class="nav-main-item">
         <a href="{{ url('/') }}" target="_blank" class="nav-main-link">
            <i class="nav-main-link-icon fa fa-globe"></i>
            <span class="nav-main-link-name">{{ __('Visit Website') }}</span>
         </a>
      </li>
   </ul>
@endif