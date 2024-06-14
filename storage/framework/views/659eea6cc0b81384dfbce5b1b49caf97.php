 
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Services')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('script-page'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Services')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('action-btn'); ?>
    <div class="float-end">
        

        <a href="#" data-size="lg" data-url="<?php echo e(route('service.create')); ?>" data-ajax-popup="true" data-bs-toggle="tooltip" title="<?php echo e(__('Create New Service')); ?>" class="btn btn-sm btn-primary">
            <i class="fa fa-plus"></i> <?php echo e(__('New Service')); ?>

        </a>

    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                            <tr>
                                <th><?php echo e(__('ID')); ?></th>
                                <th><?php echo e(__('Name')); ?></th>
                                <th><?php echo e(__('Hourly Rate')); ?></th>
                                <th><?php echo e(__('Action')); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $productServices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $productService): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="font-style">
                                    <td><?php echo e(idFormat('service',$productService->id)); ?></td>
                                    <td><?php echo e($productService->name); ?></td>
                                    <td><?php echo e($productService->hourly_rate); ?></td>

                                    <?php if(Gate::check('edit service') || Gate::check('delete service')): ?>
                                        <td class="Action" style=" display: flex; gap: 5px; ">

                                            
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit service')): ?>
                                            <a href="#" class="btn btn-primary btn-sm  align-items-center" data-url="<?php echo e(route('service.edit',$productService->id)); ?>" data-ajax-popup="true"  data-size="lg " data-bs-toggle="tooltip" title="<?php echo e(__('Edit')); ?>"  data-title="<?php echo e(__('Edit Product')); ?>">
                                                <i class="fa fa-pencil text-white"></i>
                                            </a>
                                            <?php endif; ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete service')): ?>
                                            <?php echo Form::open(['method' => 'DELETE', 'route' => ['service.destroy', $productService->id],'id'=>'delete-form-'.$productService->id]); ?>

                                            <a href="#" class="btn btn-danger btn-sm  align-items-center bs-pass-para" data-bs-toggle="tooltip" title="<?php echo e(__('Delete')); ?>" ><i class="fa fa-trash text-white"></i></a>
                                            <?php echo Form::close(); ?>

                                            <?php endif; ?>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\rezo2\resources\views/service/index.blade.php ENDPATH**/ ?>