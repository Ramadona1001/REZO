<?php if(\Auth::user()->type != 'client'): ?>
   <ul class="nav-main">
      <?php if(Gate::check('show hrm dashboard') || Gate::check('show project dashboard') || Gate::check('show account dashboard') || Gate::check('show crm dashboard') || Gate::check('show pos dashboard')): ?>
      <li class="nav-main-item">
         <a href="<?php echo e(route('dashboard')); ?>" class="nav-main-link <?php echo e(Request::segment(1) == 'account-dashboard' ? ' active' : ''); ?>">
            <i class="nav-main-link-icon fa fa-home"></i>
            <span class="nav-main-link-name"><?php echo e(__('Dashboard')); ?></span>
         </a>
      </li>
      <?php endif; ?>

      <?php if(\Auth::user()->type == 'company'): ?>
      <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage position')): ?>
      <li class="nav-main-item">
         <a href="<?php echo e(route('position.index')); ?>" class="nav-main-link <?php echo e(Request::segment(1) == 'position' ? ' active' : ''); ?>">
            <i class="nav-main-link-icon fa fa-layer-group"></i>
            <span class="nav-main-link-name"><?php echo e(__('Positions')); ?></span>
         </a>
      </li>
      <?php endif; ?>
      <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage client')): ?>
      <li class="nav-main-item">
         <a href="<?php echo e(route('clients.index')); ?>" class="nav-main-link <?php echo e(Request::segment(1) == 'clients' ? ' active' : ''); ?>">
            <i class="nav-main-link-icon fa fa-users"></i>
            <span class="nav-main-link-name"><?php echo e(__('Clients')); ?></span>
         </a>
      </li>
      <?php endif; ?>
      <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage employee')): ?>
      <li class="nav-main-item">
         <a href="<?php echo e(route('employee.index')); ?>" class="nav-main-link <?php echo e(Request::segment(1) == 'employee' ? ' active' : ''); ?>">
            <i class="nav-main-link-icon fa fa-users"></i>
            <span class="nav-main-link-name"><?php echo e(__('Employees')); ?></span>
         </a>
      </li>
      <?php endif; ?>
      <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage department')): ?>
      <li class="nav-main-item">
         <a href="<?php echo e(route('department.index')); ?>" class="nav-main-link <?php echo e(Request::segment(1) == 'department' ? ' active' : ''); ?>">
            <i class="nav-main-link-icon fa fa-layer-group"></i>
            <span class="nav-main-link-name"><?php echo e(__('Departments')); ?></span>
         </a>
      </li>
      <?php endif; ?>
      <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage designation')): ?>
      <li class="nav-main-item">
         <a href="<?php echo e(route('designation.index')); ?>" class="nav-main-link <?php echo e(Request::segment(1) == 'designation' ? ' active' : ''); ?>">
            <i class="nav-main-link-icon fa fa-layer-group"></i>
            <span class="nav-main-link-name"><?php echo e(__('Units')); ?></span>
         </a>
      </li>
      <?php endif; ?>
      <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage service')): ?>
            <li class="nav-main-item">
               <a class="nav-main-link <?php echo e(Request::segment(1) == 'service' || Request::route()->getName() == 'service.list' || Request::route()->getName() == 'service.list' || Request::route()->getName() == 'service.index' || Request::route()->getName() == 'service.show' || request()->is('service/*') ? 'active' : ''); ?>" href="<?php echo e(route('service.index')); ?>">
                  <i class="nav-main-link-icon fa fa-layer-group"></i>
                  <span class="nav-main-link-name"><?php echo e(__('Services')); ?></span>
               </a>
            </li>
      <?php endif; ?>
      <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage project')): ?>
            <li class="nav-main-item">
               <a class="nav-main-link <?php echo e(Request::segment(1) == 'project' || Request::route()->getName() == 'projects.list' || Request::route()->getName() == 'projects.list' || Request::route()->getName() == 'projects.index' || Request::route()->getName() == 'projects.show' || request()->is('projects/*') ? 'active' : ''); ?>" href="<?php echo e(route('projects.index')); ?>">
                  <i class="nav-main-link-icon fa fa-layer-group"></i>
                  <span class="nav-main-link-name"><?php echo e(__('Projects')); ?></span>
               </a>
            </li>
      <?php endif; ?>
      <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage custom request')): ?>
            <li class="nav-main-item">
               <a class="nav-main-link <?php echo e(Request::segment(1) == 'custom' || Request::route()->getName() == 'customs.list' || Request::route()->getName() == 'customs.list' || Request::route()->getName() == 'customs.index' || Request::route()->getName() == 'customs.show' || request()->is('customs/*') ? 'active' : ''); ?>" href="<?php echo e(route('customs.index')); ?>">
                  <i class="nav-main-link-icon fa fa-layer-group"></i>
                  <span class="nav-main-link-name"><?php echo e(__('Custom Requests')); ?></span>
               </a>
            </li>
      <?php endif; ?>
      <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage freelancer')): ?>
            <li class="nav-main-item">
               <a class="nav-main-link <?php echo e(Request::segment(1) == 'freelancer' || Request::route()->getName() == 'freelancers.list' || Request::route()->getName() == 'freelancers.list' || Request::route()->getName() == 'freelancers.index' || Request::route()->getName() == 'freelancers.show' || request()->is('freelancers/*') ? 'active' : ''); ?>" href="<?php echo e(route('freelancers.index')); ?>">
                  <i class="nav-main-link-icon fa fa-users"></i>
                  <span class="nav-main-link-name"><?php echo e(__('Freelancers')); ?></span>
               </a>
            </li>
      <?php endif; ?>
      <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage project')): ?>
            <li class="nav-main-item">
               <a class="nav-main-link <?php echo e(Request::segment(1) == 'supplier' || Request::route()->getName() == 'suppliers.list' || Request::route()->getName() == 'suppliers.list' || Request::route()->getName() == 'suppliers.index' || Request::route()->getName() == 'suppliers.show' || request()->is('suppliers/*') ? 'active' : ''); ?>" href="<?php echo e(route('suppliers.index')); ?>">
                  <i class="nav-main-link-icon fa fa-users"></i>
                  <span class="nav-main-link-name"><?php echo e(__('Suppliers')); ?></span>
               </a>
            </li>
      <?php endif; ?>
      <?php endif; ?>
   </ul>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\rezo2\resources\views/partials/admin/menu/not_client_menu.blade.php ENDPATH**/ ?>