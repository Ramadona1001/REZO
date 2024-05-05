@if (\Auth::user()->type != 'client')
   <ul class="nav-main">
      @if (Gate::check('show hrm dashboard') || Gate::check('show project dashboard') || Gate::check('show account dashboard') || Gate::check('show crm dashboard') || Gate::check('show pos dashboard'))
      <li class="nav-main-item">
         <a href="{{ route('dashboard') }}" class="nav-main-link {{ Request::segment(1) == 'account-dashboard' ? ' active' : '' }}">
            <i class="nav-main-link-icon fa fa-home"></i>
            <span class="nav-main-link-name">{{ __('Dashboard') }}</span>
         </a>
      </li>
      @endif

      @if (\Auth::user()->type == 'company')
      @can('manage position')
      <li class="nav-main-item">
         <a href="{{ route('position.index') }}" class="nav-main-link {{ Request::segment(1) == 'position' ? ' active' : '' }}">
            <i class="nav-main-link-icon fa fa-layer-group"></i>
            <span class="nav-main-link-name">{{ __('Positions') }}</span>
         </a>
      </li>
      @endcan
      @can('manage client')
      <li class="nav-main-item">
         <a href="{{ route('clients.index') }}" class="nav-main-link {{ Request::segment(1) == 'clients' ? ' active' : '' }}">
            <i class="nav-main-link-icon fa fa-users"></i>
            <span class="nav-main-link-name">{{ __('Clients') }}</span>
         </a>
      </li>
      @endcan
      @can('manage employee')
      <li class="nav-main-item">
         <a href="{{ route('employee.index') }}" class="nav-main-link {{ Request::segment(1) == 'employee' ? ' active' : '' }}">
            <i class="nav-main-link-icon fa fa-users"></i>
            <span class="nav-main-link-name">{{ __('Employees') }}</span>
         </a>
      </li>
      @endcan
      @can('manage department')
      <li class="nav-main-item">
         <a href="{{ route('department.index') }}" class="nav-main-link {{ Request::segment(1) == 'department' ? ' active' : '' }}">
            <i class="nav-main-link-icon fa fa-layer-group"></i>
            <span class="nav-main-link-name">{{ __('Departments') }}</span>
         </a>
      </li>
      @endcan
      @can('manage designation')
      <li class="nav-main-item">
         <a href="{{ route('designation.index') }}" class="nav-main-link {{ Request::segment(1) == 'designation' ? ' active' : '' }}">
            <i class="nav-main-link-icon fa fa-layer-group"></i>
            <span class="nav-main-link-name">{{ __('Units') }}</span>
         </a>
      </li>
      @endcan
      @can('manage service')
            <li class="nav-main-item">
               <a class="nav-main-link {{ Request::segment(1) == 'service' || Request::route()->getName() == 'service.list' || Request::route()->getName() == 'service.list' || Request::route()->getName() == 'service.index' || Request::route()->getName() == 'service.show' || request()->is('service/*') ? 'active' : '' }}" href="{{ route('service.index') }}">
                  <i class="nav-main-link-icon fa fa-layer-group"></i>
                  <span class="nav-main-link-name">{{ __('Services') }}</span>
               </a>
            </li>
      @endcan
      @can('manage project')
            <li class="nav-main-item">
               <a class="nav-main-link {{ Request::segment(1) == 'project' || Request::route()->getName() == 'projects.list' || Request::route()->getName() == 'projects.list' || Request::route()->getName() == 'projects.index' || Request::route()->getName() == 'projects.show' || request()->is('projects/*') ? 'active' : '' }}" href="{{ route('projects.index') }}">
                  <i class="nav-main-link-icon fa fa-layer-group"></i>
                  <span class="nav-main-link-name">{{ __('Projects') }}</span>
               </a>
            </li>
      @endcan
      @can('manage custom request')
            <li class="nav-main-item">
               <a class="nav-main-link {{ Request::segment(1) == 'custom' || Request::route()->getName() == 'customs.list' || Request::route()->getName() == 'customs.list' || Request::route()->getName() == 'customs.index' || Request::route()->getName() == 'customs.show' || request()->is('customs/*') ? 'active' : '' }}" href="{{ route('customs.index') }}">
                  <i class="nav-main-link-icon fa fa-layer-group"></i>
                  <span class="nav-main-link-name">{{ __('Custom Requests') }}</span>
               </a>
            </li>
      @endcan
      @can('manage freelancer')
            <li class="nav-main-item">
               <a class="nav-main-link {{ Request::segment(1) == 'freelancer' || Request::route()->getName() == 'freelancers.list' || Request::route()->getName() == 'freelancers.list' || Request::route()->getName() == 'freelancers.index' || Request::route()->getName() == 'freelancers.show' || request()->is('freelancers/*') ? 'active' : '' }}" href="{{ route('freelancers.index') }}">
                  <i class="nav-main-link-icon fa fa-users"></i>
                  <span class="nav-main-link-name">{{ __('Freelancers') }}</span>
               </a>
            </li>
      @endcan
      @can('manage project')
            <li class="nav-main-item">
               <a class="nav-main-link {{ Request::segment(1) == 'supplier' || Request::route()->getName() == 'suppliers.list' || Request::route()->getName() == 'suppliers.list' || Request::route()->getName() == 'suppliers.index' || Request::route()->getName() == 'suppliers.show' || request()->is('suppliers/*') ? 'active' : '' }}" href="{{ route('suppliers.index') }}">
                  <i class="nav-main-link-icon fa fa-users"></i>
                  <span class="nav-main-link-name">{{ __('Suppliers') }}</span>
               </a>
            </li>
      @endcan
      @endif
   </ul>
@endif