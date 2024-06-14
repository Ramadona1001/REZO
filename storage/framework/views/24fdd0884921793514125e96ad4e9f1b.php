<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Dashboard')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('theme-script'); ?>
    <script src="<?php echo e(asset('assets/libs/apexcharts/dist/apexcharts.min.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php
$admin_payment_setting = Utility::getAdminPaymentSetting();
?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-6 col-xl-3">
            <a class="block block-rounded block-link-pop" href="javascript:void(0)">
              <div class="block-content block-content-full">
                <div class="d-flex align-items-center justify-content-between p-1">
                  <div class="me-3">
                    <p class="text-muted mb-0">
                        <?php echo e(__('Total Users')); ?>

                    </p>
                    <p class="fs-3 mb-0">
                        <?php echo e($user->total_user); ?>

                    </p>
                  </div>
                </div>
              </div>
            </a>
        </div>
        
        <div class="col-md-6 col-xl-3">
            <a class="block block-rounded block-link-pop" href="javascript:void(0)">
              <div class="block-content block-content-full">
                <div class="d-flex align-items-center justify-content-between p-1">
                  <div class="me-3">
                    <p class="text-muted mb-0">
                        <?php echo e(__('Paid Users')); ?>

                    </p>
                    <p class="fs-3 mb-0">
                        <?php echo e($user['total_paid_user']); ?>

                    </p>
                  </div>
                </div>
              </div>
            </a>
        </div>
        
        <div class="col-md-6 col-xl-3">
            <a class="block block-rounded block-link-pop" href="javascript:void(0)">
              <div class="block-content block-content-full">
                <div class="d-flex align-items-center justify-content-between p-1">
                  <div class="me-3">
                    <p class="text-muted mb-0">
                       <?php echo e(__('Total Orders')); ?>

                    </p>
                    <p class="fs-3 mb-0">
                        <?php echo e($user->total_orders); ?>

                    </p>
                  </div>
                </div>
              </div>
            </a>
        </div>
        
        <div class="col-md-6 col-xl-3">
            <a class="block block-rounded block-link-pop" href="javascript:void(0)">
              <div class="block-content block-content-full">
                <div class="d-flex align-items-center justify-content-between p-1">
                  <div class="me-3">
                    <p class="text-muted mb-0">
                        <?php echo e(__('Total Order Amount')); ?>

                    </p>
                    <p class="fs-3 mb-0">
                        <?php echo e(isset($admin_payment_setting['currency_symbol']) ? $admin_payment_setting['currency_symbol'] : '$'); ?><?php echo e($user['total_orders_price']); ?>

                    </p>
                  </div>
                </div>
              </div>
            </a>
        </div>
        
        <div class="col-md-6 col-xl-3">
            <a class="block block-rounded block-link-pop" href="javascript:void(0)">
              <div class="block-content block-content-full">
                <div class="d-flex align-items-center justify-content-between p-1">
                  <div class="me-3">
                    <p class="text-muted mb-0">
                        <?php echo e(__('Total Plans')); ?>

                    </p>
                    <p class="fs-3 mb-0">
                        <?php echo e($user->total_plan); ?>

                    </p>
                  </div>
                </div>
              </div>
            </a>
        </div>
        
        <div class="col-md-6 col-xl-3">
            <a class="block block-rounded block-link-pop" href="javascript:void(0)">
              <div class="block-content block-content-full">
                <div class="d-flex align-items-center justify-content-between p-1">
                  <div class="me-3">
                    <p class="text-muted mb-0">
                        <?php echo e(__('Most Purchase Plan')); ?>

                    </p>
                    <p class="fs-3 mb-0">
                        <?php echo e($user['most_purchese_plan']); ?>

                    </p>
                  </div>
                </div>
              </div>
            </a>
        </div>
        

        
    </div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\rezo2\resources\views/dashboard/super_admin.blade.php ENDPATH**/ ?>