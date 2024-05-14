<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Employee')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Employee')); ?></li>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('action-btn'); ?>
    <div class="float-end">
        <a href="#" data-size="md"  data-bs-toggle="tooltip" title="<?php echo e(__('Import')); ?>" data-url="<?php echo e(route('employee.file.import')); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Import employee CSV file')); ?>" class="btn btn-sm btn-primary">
            <i class="fa fa-file-import"></i>
        </a>
        <a href="<?php echo e(route('employee.export')); ?>" data-bs-toggle="tooltip" title="<?php echo e(__('Export')); ?>" class="btn btn-sm btn-primary">
            <i class="fa fa-file-export"></i>
        </a>
        <a href="<?php echo e(route('employee.create')); ?>"
            data-title="<?php echo e(__('Create New Employee')); ?>" data-bs-toggle="tooltip" title="" class="btn btn-sm btn-primary"
            data-bs-original-title="<?php echo e(__('Create')); ?>">
            <i class="fa fa-plus"></i> <?php echo e(__('Add New Employee')); ?>

        </a>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-xl-12">
        <div class="card">
        <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-vcenter js-dataTable-full">
                            <thead>
                            <tr>
                                <th><?php echo e(__('Employee ID')); ?></th>
                                <th><?php echo e(__('Name')); ?></th>
                                <th><?php echo e(__('Email')); ?></th>
                                <th><?php echo e(__('Department')); ?></th>
                                <th><?php echo e(__('Section')); ?></th>
                                <th><?php echo e(__('Position')); ?></th>
                                <th><?php echo e(__('Hire Date')); ?></th>
                                <th><?php echo e(__('Contract End Date')); ?></th>
                                <th><?php echo e(__('Salary')); ?></th>
                                <th><?php echo e(__('Status')); ?></th>
                                <th><?php echo e(__('Contract Type')); ?></th>
                                <th width="200px"><?php echo e(__('Action')); ?></th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="Id">
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show employee profile')): ?>
                                            <a href="<?php echo e(route('employee.show',\Illuminate\Support\Facades\Crypt::encrypt($employee->id))); ?>" class="btn btn-outline-primary"><?php echo e(\Auth::user()->employeeIdFormat($employee->id)); ?></a>
                                        <?php else: ?>
                                            <a href="#"  class="btn btn-outline-primary"><?php echo e(\Auth::user()->employeeIdFormat($employee->id)); ?></a>
                                        <?php endif; ?>
                                    </td>
                                    <td class="font-style"><?php echo e($employee->name); ?></td>
                                    <td><?php echo e($employee->email); ?></td>
                                    
                                    <?php if($employee->department_id): ?>
                                        <td class="font-style"><?php echo e($employee->department ? $employee->department->name:''); ?></td>
                                    <?php else: ?>
                                        <td>-</td>
                                    <?php endif; ?>
                                    <?php if($employee->designation_id): ?>
                                        <td class="font-style"><?php echo e($employee->designation ? $employee->designation->name:''); ?></td>
                                    <?php else: ?>
                                        <td>-</td>
                                    <?php endif; ?>
                                    <?php if($employee->position_id): ?>
                                        <td class="font-style"><?php echo e($employee->position ? $employee->position->name:''); ?></td>
                                    <?php else: ?>
                                        <td>-</td>
                                    <?php endif; ?>
                                    <?php if($employee->company_doj): ?>
                                        <td class="font-style"><?php echo e(\Auth::user()->dateFormat($employee->company_doj )); ?></td>
                                    <?php else: ?>
                                        <td>-</td>
                                    <?php endif; ?>
                                    <?php if($employee->contract_end_date): ?>
                                        <td class="font-style"><?php echo e(\Auth::user()->dateFormat($employee->contract_end_date )); ?></td>
                                    <?php else: ?>
                                        <td>-</td>
                                    <?php endif; ?>
                                    <?php if($employee->salary): ?>
                                        <td class="font-style"><?php echo e($employee->salary); ?></td>
                                    <?php else: ?>
                                        <td>-</td>
                                    <?php endif; ?>
                                    <?php if($employee->employee_status): ?>
                                        <td class="font-style">
                                            <?php if($employee->employee_status == 1): ?>
                                                <span class="btn btn-success btn-sm"><?php echo e(__('Active')); ?></span>
                                            <?php else: ?>
                                                <span class="btn btn-danger btn-sm"><?php echo e(__('Terminated')); ?></span>
                                            <?php endif; ?>
                                        </td>
                                    <?php else: ?>
                                        <td>-</td>
                                    <?php endif; ?>
                                    <?php if($employee->contract_type): ?>
                                        <td class="font-style">
                                            <?php if($employee->contract_type == 1): ?>
                                                <span class="btn btn-info btn-sm"><?php echo e(__('Full Time')); ?></span>
                                            <?php else: ?>
                                                <span class="btn btn-info btn-sm"><?php echo e(__('Part Time')); ?></span>
                                            <?php endif; ?>
                                        </td>
                                    <?php else: ?>
                                        <td>-</td>
                                    <?php endif; ?>
                                    
                                    <?php if(Gate::check('edit employee') || Gate::check('delete employee')): ?>
                                    <td class="Action d-flex justify-content-between">
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show employee profile')): ?>
                                                <a href="<?php echo e(route('employee.show',\Illuminate\Support\Facades\Crypt::encrypt($employee->id))); ?>" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" title="<?php echo e(__('Details')); ?>" data-original-title="<?php echo e(__('Details')); ?>"><i class="fa fa-eye text-white"></i></a>
                                            <?php endif; ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit employee')): ?>
                                                    <a href="<?php echo e(route('employee.edit',\Illuminate\Support\Facades\Crypt::encrypt($employee->id))); ?>" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" title="<?php echo e(__('Edit')); ?>"
                                                    data-original-title="<?php echo e(__('Edit')); ?>"><i class="fa fa-pencil text-white"></i></a>
                                                <?php endif; ?>
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete employee')): ?>
                                                <?php echo Form::open(['method' => 'DELETE', 'route' => ['employee.destroy', $employee->id],'id'=>'delete-form-'.$employee->id]); ?>


                                                    <a href="#" class="btn btn-danger bs-pass-para" data-bs-toggle="tooltip" title="<?php echo e(__('Delete')); ?>" data-original-title="<?php echo e(__('Delete')); ?>" data-confirm="<?php echo e(__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')); ?>" data-confirm-yes="document.getElementById('delete-form-<?php echo e($employee->id); ?>').submit();"><i class="fa fa-trash text-white"></i></a>
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
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\rezo2\resources\views/employee/index.blade.php ENDPATH**/ ?>