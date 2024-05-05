<div class="col-xl-12">
    <div class="card">
        <div class="card-body table-border-style">
            <div class="table-responsive">
                <table class="table datatable">
                    <thead>
                    <tr>
                        <th><?php echo e(__('Request ID')); ?></th>
                        <th><?php echo e(__('Request Name')); ?></th>
                        <th><?php echo e(__('Request Type')); ?></th>
                        <th><?php echo e(__('Unit')); ?></th>
                        <th><?php echo e(__('Positions')); ?></th>
                        <th><?php echo e(__('Positions Need')); ?></th>
                        <th><?php echo e(__('Action')); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(isset($custom_requests) && !empty($custom_requests) && count($custom_requests) > 0): ?>
                        <?php $__currentLoopData = $custom_requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $custom_request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $custom_request_position_count = \App\Models\CustomRequestPosition::where('custom_request_id',$custom_request->id)->sum('position_employees_number');
                                $custom_request_position = \App\Models\CustomRequestPosition::where('custom_request_id',$custom_request->id)->get();
                            ?>
                            <tr>
                                <td><?php echo e(idFormat('custom_request',$custom_request->id)); ?></td>
                                <td>
                                    <p class="mb-0"><a href="<?php echo e(route('customs.show',$custom_request)); ?>" class="name mb-0 h6 text-sm"><?php echo e($custom_request->request_name); ?></a></p>
                                    <span class="badge bg-<?php echo e(\App\Models\Project::$status_color[$custom_request->status]); ?> p-2 px-3 rounded"><?php echo e(__(\App\Models\CustomRequest::$project_status[$custom_request->status])); ?></span>
                                </td>
                                <td>
                                    <?php if($custom_request->unit_position == 1): ?>
                                        <span class="badge bg-info"><?php echo e(__('Unit')); ?></span>
                                    <?php else: ?>
                                        <span class="badge bg-info"><?php echo e(__('Position')); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($custom_request->unit != null): ?>
                                        <?php echo e($custom_request->unit->name); ?>

                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($custom_request->positions); ?></td>
                                <td>
                                    <?php if(count($custom_request->custom_positions) > 0): ?>
                                        <?php $__currentLoopData = $custom_request->custom_positions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pos): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <span><?php echo e(__('Position').' : '.$pos->position->name); ?><br><?php echo e(__('Count').' : '.$pos->position_employees_number); ?></span><hr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <?php echo e(__('Not Assigned Any Positions')); ?>

                                    <?php endif; ?>
                                </td>
                                
                                <td style=" display: flex; justify-content: space-between; ">
                                        <ul style="list-style: none;">
                                            <?php if($custom_request_position_count < $custom_request->positions): ?>
                                                <li class="mb-2">
                                                    <a href="#" class="btn btn-sm btn-primary w-100" data-url="<?php echo e(URL::to('customs/'.$custom_request->id.'/positions')); ?>" data-ajax-popup="true" data-size="lg" data-bs-toggle="tooltip" title="<?php echo e(__('Project Positions')); ?>" data-title="<?php echo e(__('Project Positions')); ?>">
                                                        <i class="fa fa-user text-white"></i>
                                                        <?php echo e(__('Assign Positions')); ?>

                                                    </a>
                                                </li>
                                            <?php endif; ?>
                                            <?php if(($custom_request->positions - $custom_request_position_count) < $custom_request->positions): ?>
                                                <li class="mb-2">
                                                    <a href="#" class="btn btn-sm btn-info w-100" data-url="<?php echo e(URL::to('customs/'.$custom_request->id.'/edit-positions')); ?>" data-ajax-popup="true" data-size="lg" data-bs-toggle="tooltip" title="<?php echo e(__('Edit Project Positions')); ?>" data-title="<?php echo e(__('Edit Project Positions')); ?>">
                                                        <i class="fa fa-user text-white"></i>
                                                        <?php echo e(__('Edit Positions')); ?>

                                                    </a>
                                                </li>
                                            <?php endif; ?>
                                            <li class="mb-2">
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit project')): ?>
                                                <a href="#" class="btn btn-sm btn-warning w-100" data-url="<?php echo e(URL::to('customs/'.$custom_request->id.'/edit')); ?>" data-ajax-popup="true" data-size="lg" data-bs-toggle="tooltip" title="<?php echo e(__('Edit')); ?>" data-title="<?php echo e(__('Edit Project')); ?>">
                                                    <i class="fa fa-pencil text-white"></i>
                                                    <?php echo e(__('Edit Request')); ?>

                                                </a>
                                                <?php endif; ?>
                                            </li>
                                            <li class="mb-2">
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete project')): ?>
                                                    <?php echo Form::open(['method' => 'DELETE', 'route' => ['customs.destroy', [$custom_request->id]]]); ?>

                                                    <a href="#" class="btn btn-sm btn-danger bs-pass-para w-100" data-bs-toggle="tooltip" title="<?php echo e(__('Delete')); ?>"><i class="fa fa-trash text-white"></i> <?php echo e(__('Delete Request')); ?></a>
                                                    <?php echo Form::close(); ?>

                                                <?php endif; ?>
                                            </li>
                                        </ul>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <tr>
                            <th scope="col" colspan="7"><h6 class="text-center"><?php echo e(__('No Custom Requests Found.')); ?></h6></th>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php /**PATH C:\xampp\htdocs\rezo2\resources\views/custom_requests/list.blade.php ENDPATH**/ ?>