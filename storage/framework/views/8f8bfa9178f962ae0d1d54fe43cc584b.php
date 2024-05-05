<?php if(\Auth::user()->type == 'super admin'): ?>
   <ul class="nav-main">
      <?php if(Gate::check('manage super admin dashboard')): ?>
      <li class="nav-main-item">
         <a href="<?php echo e(route('client.dashboard.view')); ?>" class="nav-main-link <?php echo e(Request::segment(1) == 'dashboard' ? ' active' : ''); ?>">
            <i class="nav-main-link-icon fa fa-home"></i>
            <span class="nav-main-link-name"><?php echo e(__('Dashboard')); ?></span>
         </a>
      </li>
      <?php endif; ?>
      <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage user')): ?>
      <li
         class="nav-main-item">
         <a href="<?php echo e(route('users.index')); ?>" class="nav-main-link <?php echo e(Request::route()->getName() == 'users.index' || Request::route()->getName() == 'users.create' || Request::route()->getName() == 'users.edit' ? ' active' : ''); ?>">
            <i class="nav-main-link-icon fa fa-users"></i>
            <span class="nav-main-link-name"><?php echo e(__('Companies')); ?></span>
         </a>
      </li>
      <?php endif; ?>
      <?php if(Gate::check('manage plan')): ?>
      <li class="nav-main-item">
         <a href="<?php echo e(route('plans.index')); ?>" class="nav-main-link <?php echo e(Request::segment(1) == 'plans' ? 'active' : ''); ?>">
            <i class="nav-main-link-icon fa fa-trophy"></i>
            <span class="nav-main-link-name"><?php echo e(__('Plans')); ?></span>
         </a>
      </li>
      <?php endif; ?>
      <?php if(\Auth::user()->type == 'super admin'): ?>
      <li class="nav-main-item">
         <a href="<?php echo e(route('plan_request.index')); ?>" class="nav-main-link <?php echo e(request()->is('plan_request*') ? 'active' : ''); ?>">
            <i class="nav-main-link-icon fa fa-trophy"></i>
            <span class="nav-main-link-name"><?php echo e(__('Plans Requests')); ?></span>
         </a>
      </li>
      <?php endif; ?>
      
      <?php if(Gate::check('manage order')): ?>
      <li class="nav-main-item  ">
         <a href="<?php echo e(route('order.index')); ?>" class="nav-main-link <?php echo e(Request::segment(1) == 'order' ? 'active' : ''); ?>">
            <i class="nav-main-link-icon fa fa-cart-plus"></i>
            <span class="nav-main-link-name"><?php echo e(__('Orders')); ?></span>
         </a>
      </li>
      <?php endif; ?>
      
     
      <?php if(\Auth::user()->type == 'super admin'): ?>
      <?php echo $__env->make('landingpage::menu.landingpage', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php endif; ?>
      <?php if(Gate::check('manage system settings')): ?>
      <li
         class="nav-main-item ">
         <a href="<?php echo e(route('systems.index')); ?>" class="nav-main-link <?php echo e(Request::route()->getName() == 'systems.index' ? ' active' : ''); ?>">
            <i class="nav-main-link-icon fa fa-gear"></i>
            <span class="nav-main-link-name"><?php echo e(__('Settings')); ?></span>
         </a>
      </li>
      <?php endif; ?>


      <li class="nav-main-item">
         <a href="<?php echo e(url('/')); ?>" target="_blank" class="nav-main-link">
            <i class="nav-main-link-icon fa fa-globe"></i>
            <span class="nav-main-link-name"><?php echo e(__('Visit Website')); ?></span>
         </a>
      </li>
   </ul>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\rezo2\resources\views/partials/admin/menu/super_admin.blade.php ENDPATH**/ ?>