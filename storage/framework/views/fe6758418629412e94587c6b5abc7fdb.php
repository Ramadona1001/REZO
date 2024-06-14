<?php
    $dir = asset(Storage::url('uploads/plan'));
?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Plan')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('Plan')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('css-page'); ?>
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.dataTables.css">
<style>
    table,th{
        text-align: center !important;
    }
</style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('action-btn'); ?>
    <div class="float-end">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create plan')): ?>
        <a href="#" data-size="lg" data-url="<?php echo e(route('plans.create')); ?>" data-ajax-popup="true"
            data-bs-toggle="tooltip" title="<?php echo e(__('Create')); ?>" data-title="<?php echo e(__('Create New Plan')); ?>"
            class="btn btn-sm btn-primary">
            <i class="fa fa-plus"></i>
            <?php echo e(__('Create New Plan')); ?>

        </a>
            
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>


    <div class="row">
        <?php $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-4">
                <div class="plan_card">
                    <div class="card price-card price-1 wow animate__fadeInUp" data-wow-delay="0.2s"
                        style="
                       visibility: visible;
                       animation-delay: 0.2s;
                       animation-name: fadeInUp;
                       ">
                        <div class="card-body">
                            <span class="price-badge bg-primary p-2 text-white mb-2" style=" width: 100%; display: block; text-align: center; "><?php echo e($plan->name); ?></span>
                            <?php if(\Auth::user()->type == 'company' && \Auth::user()->plan == $plan->id): ?>
                                <div class="d-flex flex-row-reverse m-0 p-0 active-tag">
                                    <span class=" align-items-right">
                                        <i class="f-10 lh-1 fas fa-circle text-primary"></i>
                                        <span class="ms-2"><?php echo e(__('Active')); ?></span>
                                    </span>
                                </div>
                            <?php endif; ?>
                            <div class="d-flex flex-row-reverse m-0 p-0 active-tag">
                                <div class="form-check form-switch custom-switch-v1 float-end">
                                    <input type="checkbox" name="plan_disable"
                                    class="form-check-input input-primary is_disable" value="1"
                                    data-id='<?php echo e($plan->id); ?>' 
                                    data-name="<?php echo e(__('plan')); ?>"
                                    <?php echo e($plan->is_disable == 1 ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="plan_disable"></label>
                                </div>
                            </div>
                            <h1 class="mb-4 f-w-600 ">
                                <?php echo e(isset($admin_payment_setting['currency_symbol']) ? $admin_payment_setting['currency_symbol'] : '$'); ?><?php echo e(number_format($plan->price)); ?>

                                <small class="text-sm">/<?php echo e(__(\App\Models\Plan::$arrDuration[$plan->duration])); ?></small>
                            </h1>
                            <p class="mb-0">
                                <?php echo e(__('Free Trial Days : ') . __($plan->trial_days ? $plan->trial_days : 0)); ?><br />
                            </p>
    
                            <div class="row ">
                                
                                
                            </div>
    
                            <?php if(\Auth::user()->type == 'super admin'): ?>
                            <div class="row align-items-center">
                                <div class="col-3"></div>
                                <div class="col-2 me-3">
                                    <a title="<?php echo e(__('Edit Plan')); ?>" href="#" class="btn btn-primary btn-icon m-1"
                                        data-url="<?php echo e(route('plans.edit', $plan->id)); ?>" data-ajax-popup="true"
                                        data-title="<?php echo e(__('Edit Plan')); ?>" data-size="lg" data-toggle="tooltip"
                                        data-original-title="<?php echo e(__('Edit')); ?>">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </div>
                                <div class="col-3">
                                    <?php echo Form::open([
                                                                    'method' => 'DELETE',
                                                                    'route' => ['plans.destroy', $plan->id],
                                                                    'id' => 'delete-form-' . $plan->id,
                                                                ]); ?>

                                                                <a href="#!" class="bs-pass-para btn btn-danger btn-icon m-1">
                                                                    <i class="fa fa-trash"></i>
                                                                </a>
                                                                <?php echo Form::close(); ?>

                                    </div>
                            </div>
    
                            <?php endif; ?>
                            <?php if(isset($admin_payment_setting) && !empty($admin_payment_setting)): ?>
                                <?php if(
                                    $admin_payment_setting['is_manually_payment_enabled'] == 'on' ||
                                        $admin_payment_setting['is_bank_transfer_enabled'] == 'on' ||
                                        $admin_payment_setting['is_stripe_enabled'] == 'on' ||
                                        $admin_payment_setting['is_paypal_enabled'] == 'on' ||
                                        $admin_payment_setting['is_paystack_enabled'] == 'on' ||
                                        $admin_payment_setting['is_flutterwave_enabled'] == 'on' ||
                                        $admin_payment_setting['is_razorpay_enabled'] == 'on' ||
                                        $admin_payment_setting['is_mercado_enabled'] == 'on' ||
                                        $admin_payment_setting['is_paytm_enabled'] == 'on' ||
                                        $admin_payment_setting['is_mollie_enabled'] == 'on' ||
                                        $admin_payment_setting['is_skrill_enabled'] == 'on' ||
                                        $admin_payment_setting['is_coingate_enabled'] == 'on' ||
                                        $admin_payment_setting['is_paymentwall_enabled'] == 'on' ||
                                        $admin_payment_setting['is_paymentwall_enabled'] == 'on' ||
                                        $admin_payment_setting['is_toyyibpay_enabled'] == 'on' ||
                                        $admin_payment_setting['is_payfast_enabled'] == 'on' ||
                                        $admin_payment_setting['is_iyzipay_enabled'] == 'on' ||
                                        $admin_payment_setting['is_sspay_enabled'] == 'on' ||
                                        $admin_payment_setting['is_paytab_enabled'] == 'on' ||
                                        $admin_payment_setting['is_benefit_enabled'] == 'on' ||
                                        $admin_payment_setting['is_cashfree_enabled'] == 'on' ||
                                        $admin_payment_setting['is_aamarpay_enabled'] == 'on' ||
                                        $admin_payment_setting['is_paytr_enabled'] == 'on' ||
                                        $admin_payment_setting['is_yookassa_enabled'] == 'on' ||
                                        $admin_payment_setting['is_midtrans_enabled'] == 'on' ||
                                        $admin_payment_setting['is_xendit_enabled'] == 'on'): ?>
                                    <?php if(\Auth::user()->type != 'super admin'): ?>
                                        <?php if(
                                            $plan->price > 0 &&
                                                \Auth::user()->trial_plan == 0 &&
                                                \Auth::user()->plan != $plan->id && $plan->trial == 1): ?>
                                                
                                            <a href="<?php echo e(route('plan.trial', \Illuminate\Support\Facades\Crypt::encrypt($plan->id))); ?>"
                                                class="btn btn-lg btn-primary btn-icon m-1"><?php echo e(__('Start Free Trial')); ?></a>
                                        <?php endif; ?>
                                        <?php if($plan->id != \Auth::user()->plan): ?>
                                            <?php if($plan->price > 0): ?>
                                                <a href="<?php echo e(route('stripe', \Illuminate\Support\Facades\Crypt::encrypt($plan->id))); ?>"
                                                    class="btn btn-lg btn-primary btn-icon m-1"><?php echo e(__('Buy Plan')); ?></a>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <?php if($plan->id != 1 && $plan->id != \Auth::user()->plan): ?>
                                            <?php if(\Auth::user()->requested_plan != $plan->id): ?>
                                                <a href="<?php echo e(route('send.request', [\Illuminate\Support\Facades\Crypt::encrypt($plan->id)])); ?>"
                                                    class="btn btn-lg btn-primary btn-icon m-1"
                                                    data-title="<?php echo e(__('Send Request')); ?>" data-bs-toggle="tooltip"
                                                    title="<?php echo e(__('Send Request')); ?>">
                                                    <span class="btn-inner--icon"><i class="fa fa-corner-up-right"></i></span>
                                                </a>
                                            <?php else: ?>
                                                <a href="<?php echo e(route('request.cancel', \Auth::user()->id)); ?>"
                                                    class="btn btn-danger btn-icon m-1"
                                                    data-title="<?php echo e(__('`Cancle Request')); ?>" data-bs-toggle="tooltip"
                                                    title="<?php echo e(__('Cancle Request')); ?>">
                                                    <span class="btn-inner--icon"><i class="fa fa-x"></i></span>
                                                </a>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endif; ?>
     
                            <?php if(\Auth::user()->type == 'company' && \Auth::user()->trial_expire_date): ?>
                                <?php if(\Auth::user()->type == 'company' && \Auth::user()->trial_plan == $plan->id): ?>
                                <p class="display-total-time mb-0">
                                    <?php echo e(__('Plan Trial Expired : ')); ?>

                                    <?php echo e(!empty(\Auth::user()->trial_expire_date) ? \Auth::user()->dateFormat(\Auth::user()->trial_expire_date) : 'lifetime'); ?>

                                </p>
                                <?php endif; ?> 
                            <?php else: ?>
                                <?php if(\Auth::user()->type == 'company' && \Auth::user()->plan == $plan->id): ?>
                                <p class="display-total-time mb-0">
                                    <?php echo e(__('Plan Expired : ')); ?>

                                    <?php echo e(!empty(\Auth::user()->plan_expire_date) ? \Auth::user()->dateFormat(\Auth::user()->plan_expire_date) : 'lifetime'); ?>

                                </p>
                                <?php endif; ?> 
                            <?php endif; ?>                        
    
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script-page'); ?>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.js"></script>
    <script>
        new DataTable('#example');
        $(document).on('change', '#trial', function() {
            if ($(this).is(':checked')) {
                $('.plan_div').removeClass('d-none');
                $('#trial_days').attr("required", true);

            } else {
                $('.plan_div').addClass('d-none');
                $('#trial_days').removeAttr("required");
            }
        });
    </script>

    <script>
        $(document).on("click", ".is_disable", function() {

        var id = $(this).attr('data-id');
        var is_disable = ($(this).is(':checked')) ? $(this).val() : 0;

        $.ajax({
            url: '<?php echo e(route('plan.disable')); ?>',
            type: 'POST',
            data: {
                "is_disable": is_disable,
                "id": id,
                "_token": "<?php echo e(csrf_token()); ?>",
            },
            success: function(data) {
                if (data.success) {
                    show_toastr('success', data.success);
                } else {
                    show_toastr('error', data.error);

                }

            }
        });
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\rezo2\resources\views/plan/index.blade.php ENDPATH**/ ?>