<?php
   // $profile=asset(Storage::url('uploads/avatar/'));
    $profile=\App\Models\Utility::get_file('uploads/avatar/');
?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Client')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('script-page'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Clients')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('action-btn'); ?>
    <div class="float-end">
        <a href="#" data-size="md" data-url="<?php echo e(route('clients.create')); ?>" data-ajax-popup="true"  data-bs-toggle="tooltip" title="<?php echo e(__('Create Client')); ?>"  data-bs-original-title="<?php echo e(__('create')); ?>" class="btn btn-sm btn-primary">
            <i class="fa fa-plus"></i> <?php echo e(__('New Client')); ?>

        </a>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="col-12">
    <div class="card">
        <div class="card-body table-border-style">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-vcenter js-dataTable-full">
                    <thead>
                    <tr>
                        <th><?php echo e(__('ID')); ?></th>
                        <th><?php echo e(__('Name')); ?></th>
                        <th><?php echo e(__('Industry')); ?></th>
                        <th><?php echo e(__('Address')); ?></th>
                        <th><?php echo e(__('Contact Data')); ?></th>
                        <th width="200px"><?php echo e(__('Action')); ?></th>
                    </tr>
                    </thead>
                    <tbody class="font-style">
                    <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e(idFormat('client',$client->id)); ?></td>
                            <td><?php echo e($client->name); ?></td>
                            <td><?php echo e($client->industry); ?></td>
                            <td><?php echo e($client->address); ?></td>
                            <td>
                                <?php $__currentLoopData = $client->contacts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contact): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <ul>
                                        <li><?php echo e(__('Contact Name').' : '.$contact->contact_name); ?></li>
                                        <li><?php echo e(__('Position').' : '.$contact->position); ?></li>
                                        <li><?php echo e(__('Mobile').' : '.$contact->mobile); ?></li>
                                        <li><?php echo e(__('Email').' : '.$contact->email); ?></li>
                                    </ul>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>    
                            </td>

                            <td class="Action d-flex justify-content-between">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit client')): ?>
                                    <a href="#" class="btn btn-primary" data-url="<?php echo e(route('clients.edit',$client->id)); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Edit Client')); ?>" data-toggle="tooltip" data-original-title="<?php echo e(__('Edit')); ?>">
                                        <i class="fa fa-pencil text-white"></i>
                                    </a>
                                    <?php endif; ?>

                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete client')): ?>
                                    <?php echo Form::open(['method' => 'DELETE', 'route' => ['clients.destroy', $client['id']],'id'=>'delete-form-'.$client['id']]); ?>

                                        <a href="#" class="btn btn-danger bs-pass-para" data-toggle="tooltip" data-original-title="<?php echo e(__('Delete')); ?>" data-confirm="<?php echo e(__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')); ?>" data-confirm-yes="document.getElementById('delete-form-<?php echo e($client->id); ?>').submit();">
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
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script-page'); ?>
    <script type="text/javascript">
    $(document).on('click', '#rowAdder', function() {
            newRowAdd = `<div class="row mt-3" id="row" style="background: #ededed; padding: 10px; border-top: 2px solid #c9c9c9; border-bottom: 2px solid #c9c9c9;">
                <div class="col-6 mb-3">
                    <label for="contact_name"><?php echo e(__('Contact Name')); ?></label>
                    <input type="text" name="contact_name[]" id="contact_name" class="form-control" required>
                </div>
                <div class="col-6 mb-3">
                    <label for="position"><?php echo e(__('Contact Position')); ?></label>
                    <input type="text" name="position[]" id="position" class="form-control" required>
                </div>
                <div class="col-6 mb-3">
                    <label for="mobile"><?php echo e(__('Contact Mobile')); ?></label>
                    <input type="text" name="mobile[]" id="mobile" class="form-control" required>
                </div>
                <div class="col-6 mb-3">
                    <label for="email"><?php echo e(__('Contact Email')); ?></label>
                    <input type="email" name="email[]" id="email" class="form-control" required>
                </div>
                <div class="col-12">
                    <button class="btn btn-danger" id="DeleteRow" type="button"><i class="fa fa-trash"></i></button>
                </div>
            </div>`;
            $('#newinput').append(newRowAdd);
        });
        $("body").on("click", "#DeleteRow", function () {
            $(this).parents("#row").remove();
        })
    </script>

    <script>
        $(document).on('change', '#password_switch', function() {
            if ($(this).is(':checked')) {
                $('.ps_div').removeClass('d-none');
                $('#password').attr("required", true);

            } else {
                $('.ps_div').addClass('d-none');
                $('#password').val(null);
                $('#password').removeAttr("required");
            }
        });
        $(document).on('click', '.login_enable', function() {
            setTimeout(function() {
                $('.modal-body').append($('<input>', {
                    type: 'hidden',
                    val: 'true',
                    name: 'login_enable'
                }));
            }, 2000);
        });
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\rezo2\resources\views/clients/index.blade.php ENDPATH**/ ?>