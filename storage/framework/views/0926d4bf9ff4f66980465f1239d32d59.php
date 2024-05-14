<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Position')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Position')); ?></li>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('action-btn'); ?>
    <div class="float-end">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create position')): ?>
            <a href="#" data-url="<?php echo e(route('position.create')); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Create New Position')); ?>" data-bs-toggle="tooltip" title="<?php echo e(__('Create')); ?>"  class="btn btn-sm btn-primary">
                <i class="fa fa-plus"></i> <?php echo e(__('Add New Position')); ?>

            </a>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        
        <div class="col-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-vcenter js-dataTable-full">
                            <thead>
                            <tr>
                                <th><?php echo e(__('ID')); ?></th>
                                <th><?php echo e(__('Position')); ?></th>
                                <th><?php echo e(__('Descriptions')); ?></th>
                                <th><?php echo e(__('Salary Range')); ?></th>
                                <th width="200px"><?php echo e(__('Action')); ?></th>
                            </tr>
                            </thead>
                            <tbody class="font-style">
                            <?php $__currentLoopData = $positions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $position): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e(idFormat('position',$position->id)); ?></td>
                                    <td><?php echo e($position->name); ?></td>
                                    <td><?php echo e($position->descriptions); ?></td>
                                    <td><?php echo e($position->slaray_range); ?></td>

                                    <td class="Action d-flex justify-content-between">
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit position')): ?>
                                            <a href="#" class="btn btn-primary" data-url="<?php echo e(route('position.edit',$position->id)); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Edit Position')); ?>" data-toggle="tooltip" data-original-title="<?php echo e(__('Edit')); ?>">
                                                <i class="fa fa-pencil text-white"></i>
                                            </a>
                                            <?php endif; ?>

                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete position')): ?>
                                            <?php echo Form::open(['method' => 'DELETE', 'route' => ['position.destroy', $position->id],'id'=>'delete-form-'.$position->id]); ?>

                                                <a href="#" class="btn btn-danger bs-pass-para" data-toggle="tooltip" data-original-title="<?php echo e(__('Delete')); ?>" data-confirm="<?php echo e(__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')); ?>" data-confirm-yes="document.getElementById('delete-form-<?php echo e($position->id); ?>').submit();">
                                                    <i class="fa fa-trash text-white"></i>
                                                </a>
                                            <?php echo Form::close(); ?>

                                            <?php endif; ?>
                                    </td>
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

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\rezo2\resources\views/position/index.blade.php ENDPATH**/ ?>