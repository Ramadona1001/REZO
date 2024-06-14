<div class="col-xl-12">
    <div class="card">
        <div class="card-body table-border-style">
            <div class="table-responsive">
                <table class="table datatable">
                    <thead>
                    <tr>
                        <th><?php echo e(__('Project ID')); ?></th>
                        <th><?php echo e(__('Project')); ?></th>
                        <th><?php echo e(__('Positions Count')); ?></th>
                        <th><?php echo e(__('Positions')); ?></th>
                        <th><?php echo e(__('Employees Assigned')); ?></th>
                        <th><?php echo e(__('Action')); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(isset($projects) && !empty($projects) && count($projects) > 0): ?>
                        <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $project_position_count = \App\Models\ProjectPosition::where('project_id',$project->id)->sum('position_employees_number');
                                $project_position_employee_count = \App\Models\ProjectEmployee::where('project_id',$project->id)->count();
                                $project_position = \App\Models\ProjectPosition::where('project_id',$project->id)->get();
                                $project_services = \App\Models\ProjectService::where('project_id',$project->id)->get();
                            ?>
                            <tr>
                                <td><a href="<?php echo e(route('projects.show',$project)); ?>" class="name mb-0 h6 text-sm btn btn-secondary btn-sm"><?php echo e(idFormat('project',$project->id)); ?></a></td>
                                <td>
                                    <p class="mb-0"><a href="<?php echo e(route('projects.show',$project)); ?>" class="name mb-0 h6 text-sm"><?php echo e($project->project_name); ?></a></p>
                                    <span class="badge bg-<?php echo e(\App\Models\Project::$status_color[$project->status]); ?> p-2 px-3 rounded"><?php echo e(__(\App\Models\Project::$project_status[$project->status])); ?></span>
                                </td>
                                <td>
                                   <span><?php echo e(__('Total Positions That Need').' : '.$project->positions); ?></span><br>
                                   <span><?php echo e(__('Assigned Positions').' : '.$project_position_count); ?></span><br>
                                   <span><?php echo e(__('Remain Positions').' : '.$project->positions - $project_position_count); ?></span><br>
                                </td>
                                <td>
                                    <?php if(count($project->project_positions) > 0): ?>
                                        <?php $__currentLoopData = $project->project_positions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pos): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <span><?php echo e(__('Position').' : '.$pos->position->name); ?><br><?php echo e(__('Count').' : '.$pos->position_employees_number); ?></span><hr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <?php echo e(__('Not Assigned Any Positions')); ?>

                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if(count($project->project_employees) > 0): ?>
                                        <?php $__currentLoopData = $project->project_employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <span><?php echo e(__('Position').' : '.$emp->position->name); ?><br><?php echo e(__('Employee').' : '.$emp->employee->name.' | '.$emp->count); ?></span><hr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <?php echo e(__('Not Assigned Any Employees')); ?>

                                    <?php endif; ?>
                                </td>
                                <td style=" display: flex; justify-content: space-between; ">
                                        <ul style="list-style: none;">
                                            <?php if(count($project_services) > 0): ?>
                                            <li class="mb-2">
                                                <a href="#" class="btn btn-sm btn-info w-100" data-url="<?php echo e(URL::to('projects/'.$project->id.'/services')); ?>" data-ajax-popup="true" data-size="lg" data-bs-toggle="tooltip" title="<?php echo e(__('Services')); ?>" data-title="<?php echo e(__('Services')); ?>">
                                                    <i class="fa fa-layer-group text-white"></i>
                                                    <?php echo e(__('Services')); ?>

                                                </a>
                                            </li>
                                            <?php endif; ?>
                                            <?php if($project_position_count < $project->positions): ?>
                                                <li class="mb-2">
                                                    <a href="#" class="btn btn-sm btn-primary w-100" data-url="<?php echo e(URL::to('projects/'.$project->id.'/positions')); ?>" data-ajax-popup="true" data-size="lg" data-bs-toggle="tooltip" title="<?php echo e(__('Project Positions')); ?>" data-title="<?php echo e(__('Project Positions')); ?>">
                                                        <i class="fa fa-user text-white"></i>
                                                        <?php echo e(__('Assign Positions')); ?>

                                                    </a>
                                                </li>
                                            <?php endif; ?>
                                            <?php if(($project->positions - $project_position_count) < $project->positions): ?>
                                                <li class="mb-2">
                                                    <a href="#" class="btn btn-sm btn-info w-100" data-url="<?php echo e(URL::to('projects/'.$project->id.'/edit-positions')); ?>" data-ajax-popup="true" data-size="lg" data-bs-toggle="tooltip" title="<?php echo e(__('Edit Project Positions')); ?>" data-title="<?php echo e(__('Edit Project Positions')); ?>">
                                                        <i class="fa fa-user text-white"></i>
                                                        <?php echo e(__('Edit Positions')); ?>

                                                    </a>
                                                </li>
                                            <?php endif; ?>
                                            <?php if(count($project_position) > 0): ?>
                                                <?php if($project_position_employee_count < $project->positions): ?>
                                                    <li class="mb-2">
                                                        <a href="<?php echo e(URL::to('projects/'.$project->id.'/employees')); ?>" class="btn btn-sm btn-primary w-100"  title="<?php echo e(__('Assign Employees')); ?>" data-title="<?php echo e(__('Assign Employees')); ?>">
                                                            <i class="fa fa-user text-white"></i>
                                                            <?php echo e(__('Assign Employees')); ?>

                                                        </a>
                                                    </li>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                            <li class="mb-2">
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit project')): ?>
                                                <a href="#" class="btn btn-sm btn-warning w-100" data-url="<?php echo e(URL::to('projects/'.$project->id.'/edit')); ?>" data-ajax-popup="true" data-size="lg" data-bs-toggle="tooltip" title="<?php echo e(__('Edit')); ?>" data-title="<?php echo e(__('Edit Project')); ?>">
                                                    <i class="fa fa-pencil text-white"></i>
                                                    <?php echo e(__('Edit Project')); ?>

                                                </a>
                                                <?php endif; ?>
                                            </li>
                                            <li class="mb-2">
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete project')): ?>
                                                    <?php echo Form::open(['method' => 'DELETE', 'route' => ['projects.destroy', [$project->id]]]); ?>

                                                    <a href="#" class="btn btn-sm btn-danger bs-pass-para w-100" data-bs-toggle="tooltip" title="<?php echo e(__('Delete')); ?>"><i class="fa fa-trash text-white"></i> <?php echo e(__('Delete Project')); ?></a>
                                                    <?php echo Form::close(); ?>

                                                <?php endif; ?>
                                            </li>
                                        </ul>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <tr>
                            <th scope="col" colspan="7"><h6 class="text-center"><?php echo e(__('No Projects Found.')); ?></h6></th>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php /**PATH C:\xampp\htdocs\rezo2\resources\views/projects/list.blade.php ENDPATH**/ ?>