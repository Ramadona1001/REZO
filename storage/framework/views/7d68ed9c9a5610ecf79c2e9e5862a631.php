<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Leads')); ?> <?php if($pipeline): ?>
        - <?php echo e($pipeline->name); ?>

    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('css-page'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/summernote/summernote-bs4.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/plugins/dragula.min.css')); ?>" id="main-style-link">
<?php $__env->stopPush(); ?>
<?php $__env->startPush('script-page'); ?>
    <script src="<?php echo e(asset('css/summernote/summernote-bs4.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/dragula.min.js')); ?>"></script>
    <script>
        ! function(a) {
            "use strict";
            var t = function() {
                this.$body = a("body")
            };
            t.prototype.init = function() {
                a('[data-plugin="dragula"]').each(function() {
                    var t = a(this).data("containers"),
                        n = [];
                    if (t)
                        for (var i = 0; i < t.length; i++) n.push(a("#" + t[i])[0]);
                    else n = [a(this)[0]];
                    var r = a(this).data("handleclass");
                    r ? dragula(n, {
                        moves: function(a, t, n) {
                            return n.classList.contains(r)
                        }
                    }) : dragula(n).on('drop', function(el, target, source, sibling) {

                        var order = [];
                        $("#" + target.id + " > div").each(function() {
                            order[$(this).index()] = $(this).attr('data-id');
                        });

                        var id = $(el).attr('data-id');

                        var old_status = $("#" + source.id).data('status');
                        var new_status = $("#" + target.id).data('status');
                        var stage_id = $(target).attr('data-id');
                        var pipeline_id = '<?php echo e($pipeline->id); ?>';

                        $("#" + source.id).parent().find('.count').text($("#" + source.id + " > div")
                            .length);
                        $("#" + target.id).parent().find('.count').text($("#" + target.id + " > div")
                            .length);
                        $.ajax({
                            url: '<?php echo e(route('leads.order')); ?>',
                            type: 'POST',
                            data: {
                                lead_id: id,
                                stage_id: stage_id,
                                order: order,
                                new_status: new_status,
                                old_status: old_status,
                                pipeline_id: pipeline_id,
                                "_token": $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(data) {},
                            error: function(data) {
                                data = data.responseJSON;
                                show_toastr('error', data.error, 'error')
                            }
                        });
                    });
                })
            }, a.Dragula = new t, a.Dragula.Constructor = t
        }(window.jQuery),
        function(a) {
            "use strict";

            a.Dragula.init()

        }(window.jQuery);
    </script>
    <script>
        $(document).on("change", "#default_pipeline_id", function() {
            $('#change-pipeline').submit();
        });
    </script>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Lead')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('action-btn'); ?>
    <div class="float-end">
        <?php echo e(Form::open(['route' => 'deals.change.pipeline', 'id' => 'change-pipeline', 'class' => 'btn btn-sm'])); ?>

        <?php echo e(Form::select('default_pipeline_id', $pipelines, $pipeline->id, ['class' => 'form-control select me-2', 'id' => 'default_pipeline_id'])); ?>

        <?php echo e(Form::close()); ?>

        <a href="#" data-size="lg" data-url="<?php echo e(route('leads.create')); ?>" data-ajax-popup="true"
            data-bs-toggle="tooltip" title="<?php echo e(__('Create New Lead')); ?>" data-title="<?php echo e(__('Create Lead')); ?>"
            class="btn btn-sm btn-primary">
            <i class="fa fa-plus"></i>
        </a>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-sm-12">
            <?php
                $lead_stages = $pipeline->leadStages;
                $json = [];
                foreach ($lead_stages as $lead_stage) {
                    $json[] = 'task-list-' . $lead_stage->id;
                }
            ?>
            <div class="row kanban-wrapper horizontal-scroll-cards" style="row-gap: 20px"
                data-containers='<?php echo json_encode($json); ?>' data-plugin="dragula">
                <?php $__currentLoopData = $lead_stages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lead_stage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php ($leads = $lead_stage->lead()); ?>
                    <div class="col-4">
                        <div class="card">
                            <div class="card-header">
                                <div class="float-end">
                                    <span class="btn btn-sm btn-primary btn-icon count">
                                        <?php echo e(count($leads)); ?>

                                    </span>
                                </div>
                                <h4 class="mb-0"><?php echo e($lead_stage->name); ?></h4>
                            </div>
                            <div class="card-body kanban-box" id="task-list-<?php echo e($lead_stage->id); ?>"
                                data-id="<?php echo e($lead_stage->id); ?>">
                                <?php $__currentLoopData = $leads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lead): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="card" data-id="<?php echo e($lead->id); ?>" style="cursor: move;">
                                        <div class="card-body">
                                            <?php ($labels = $lead->labels()); ?>
                                            <?php if($labels): ?>
                                                <span><?php echo e(__('Labels')); ?></span>
                                                <?php $__currentLoopData = $labels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="badge-xs badge bg-<?php echo e($label->color); ?> p-2 px-3 rounded">
                                                        <?php echo e($label->name); ?></div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <hr>
                                            <?php endif; ?>
                                            <h5 class="text-center"><a
                                                    href="<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view lead')): ?><?php if($lead->is_active): ?><?php echo e(route('leads.show', $lead->id)); ?><?php else: ?>#<?php endif; ?> <?php else: ?>#<?php endif; ?>"><?php echo e($lead->name); ?></a>
                                            </h5>
                                            <?php if(Auth::user()->type != 'client'): ?>
                                                <div class="d-flex justify-content-center gap-2">
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit lead')): ?>
                                                        <a href="#!" data-size="md"
                                                            data-url="<?php echo e(URL::to('leads/' . $lead->id . '/labels')); ?>"
                                                            data-ajax-popup="true" class="btn btn-sm btn-primary"
                                                            data-bs-original-title="<?php echo e(__('Labels')); ?>">
                                                            <i class="fa fa-bookmark"></i>
                                                            <span><?php echo e(__('Labels')); ?></span>
                                                        </a>



                                                        <a href="#!" data-size="lg"
                                                            data-url="<?php echo e(URL::to('leads/' . $lead->id . '/edit')); ?>"
                                                            data-ajax-popup="true" class="btn btn-sm btn-primary"
                                                            data-bs-original-title="<?php echo e(__('Edit Lead')); ?>">
                                                            <i class="fa fa-pencil"></i>
                                                            <span><?php echo e(__('Edit')); ?></span>
                                                        </a>
                                                    <?php endif; ?>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete lead')): ?>
                                                        <?php echo Form::open([
                                                            'method' => 'DELETE',
                                                            'route' => ['leads.destroy', $lead->id],
                                                            'id' => 'delete-form-' . $lead->id,
                                                        ]); ?>

                                                        <a href="#!" class="btn btn-sm btn-danger bs-pass-para">
                                                            <i class="fa fa-archive"></i>
                                                            <span> <?php echo e(__('Delete')); ?> </span>
                                                        </a>
                                                        <?php echo Form::close(); ?>

                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>

                                            <ul class="list-inline mb-0 d-flex justify-content-center gap-2 mt-2">
                                                <li class="list-inline-item d-inline-flex align-items-center btn btn-sm btn-info"
                                                    data-bs-toggle="tooltip" title="<?php echo e(__('Source')); ?>">
                                                    <i
                                                        class="f-16 text-white fa fa-share-nodes"></i>&nbsp;<?php echo e(count($lead->sources())); ?>

                                                </li>
                                            </ul>
                                            <?php if(count($lead->sources()) > 0): ?>
                                                <div class="d-flex justify-content-center gap-2 mt-2">
                                                    <?php $__currentLoopData = $lead->sources(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $source): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <span style="background: #d8e9f9;padding:5px;border-radius:5px;color:#183a59;"><?php echo e($source->name); ?></span>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>

                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\rezo2\resources\views/leads/index.blade.php ENDPATH**/ ?>