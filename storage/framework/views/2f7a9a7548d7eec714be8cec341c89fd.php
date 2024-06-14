<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Projects')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('script-page'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Projects')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('action-btn'); ?>
    <div class="float-end">
        


        
                <a href="#" class="btn btn-sm btn-primary action-item" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-filter"></i>
                </a>
                <div class="dropdown-menu  dropdown-steady" id="project_sort">
                    <a class="dropdown-item active" href="#" data-val="created_at-desc">
                        <i class="fa fa-sort-descending"></i><?php echo e(__('Newest')); ?>

                    </a>
                    <a class="dropdown-item" href="#" data-val="created_at-asc">
                        <i class="fa fa-sort-ascending"></i><?php echo e(__('Oldest')); ?>

                    </a>

                    <a class="dropdown-item" href="#" data-val="project_name-desc">
                        <i class="fa fa-sort-descending-letters"></i><?php echo e(__('From Z-A')); ?>

                    </a>
                    <a class="dropdown-item" href="#" data-val="project_name-asc">
                        <i class="fa fa-sort-ascending-letters"></i><?php echo e(__('From A-Z')); ?>

                    </a>
                </div>

            

            
                <a href="#" class="btn btn-sm btn-primary action-item" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="btn-inner--icon"><?php echo e(__('Status')); ?></span>
                </a>
                <div class="dropdown-menu  project-filter-actions dropdown-steady" id="project_status">
                    <a class="dropdown-item filter-action filter-show-all pl-4 active" href="#"><?php echo e(__('Show All')); ?></a>
                    <?php $__currentLoopData = \App\Models\Project::$project_status; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a class="dropdown-item filter-action pl-4" href="#" data-val="<?php echo e($key); ?>"><?php echo e(__($val)); ?></a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create project')): ?>
            <a href="#" data-size="lg" data-url="<?php echo e(route('projects.create')); ?>" data-ajax-popup="true" data-bs-toggle="tooltip" title="<?php echo e(__('Create New Project')); ?>" data-title="<?php echo e(__('Create Project')); ?>" class="btn btn-sm btn-primary">
                <i class="fa fa-plus"></i>
            </a>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row min-750" id="project_view"></div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script-page'); ?>
<script type="text/javascript">
    $( document ).ajaxComplete(function() {
        $("#addPosition").on('click',function () {
            newRowAdd = `
            <div class="row mb-3" id="row">
                <div class="col-sm-5 col-md-5">
                    <div class="form-group">
                        <?php echo e(Form::label('positions[]', __('Position Name'), ['class' => 'form-label'])); ?><span class="text-danger">*</span>
                        <?php echo e(Form::select('positions[]', $positions,null, ['class' => 'form-control'])); ?>

                    </div>
                </div>
                <div class="col-sm-5 col-md-5">
                    <div class="form-group">
                        <?php echo e(Form::label('positions_count[]', __('Position Count'), ['class' => 'form-label'])); ?><span class="text-danger">*</span>
                        <?php echo e(Form::number('positions_count[]',0, ['class' => 'form-control','step'=>0.5,'min' => 0])); ?>

                    </div>
                </div>
                <div class="col-sm-2 col-md-2">
                    <div class="form-group">
                        <label><?php echo e(__('Delete')); ?></label><br>
                        <button type="button" class="btn btn-sm btn-danger" id="DeleteRow"><i class="fa fa-trash"></i></button>
                    </div>
                </div>
            </div>
            `;

            $('#positionsData').append(newRowAdd);
        });
        $("body").on("click", "#DeleteRow", function () {
            $(this).parents("#row").remove();
        });
        
        //////////////////////////////////////////////////
        $("#addService").on('click',function () {
            newRowAdd = `
            <div class="row mb-3" id="services">
                <div class="col-sm-5 col-md-5">
                    <div class="form-group">
                        <?php echo e(Form::label('services', __('Service'), ['class' => 'form-label'])); ?>

                        <select name="services[]" id="services" class="form-control main-element" required>
                            <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($service->id); ?>"><?php echo e(__($service->name)); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-5 col-md-5">
                    <div class="form-group">
                        <?php echo e(Form::label('financial_value', __('Financial value'), ['class' => 'form-label'])); ?>

                        <input type="number" name="financial_value[]" id="financial_value" required step="0.01" min="0" value="0" class="form-control">
                    </div>
                </div>
                <div class="col-sm-2 col-md-2">
                    <div class="form-group">
                        <label><?php echo e(__('Delete')); ?></label><br>
                        <button type="button" class="btn btn-sm btn-danger" id="DeleteService"><i class="fa fa-trash"></i></button>
                    </div>
                </div>
            </div>
            `;

            $('#servicesData').append(newRowAdd);
        });
        $("body").on("click", "#DeleteService", function () {
            $(this).parents("#services").remove();
        });
    });
</script>

<script>
    $(document).ready(function () {
        var sort = 'created_at-desc';
        var status = '';
        ajaxFilterProjectView('created_at-desc');
        $(".project-filter-actions").on('click', '.filter-action', function (e) {
            if ($(this).hasClass('filter-show-all')) {
                $('.filter-action').removeClass('active');
                $(this).addClass('active');
            } else {
                $('.filter-show-all').removeClass('active');
                if ($(this).hasClass('active')) {
                    $(this).removeClass('active');
                    $(this).blur();
                } else {
                    $(this).addClass('active');
                }
            }

            var filterArray = [];
            var url = $(this).parents('.project-filter-actions').attr('data-url');
            $('div.project-filter-actions').find('.active').each(function () {
                filterArray.push($(this).attr('data-val'));
            });

            status = filterArray;

            ajaxFilterProjectView(sort, $('#project_keyword').val(), status);
        });

        // when change sorting order
        $('#project_sort').on('click', 'a', function () {
            sort = $(this).attr('data-val');
            ajaxFilterProjectView(sort, $('#project_keyword').val(), status);
            $('#project_sort a').removeClass('active');
            $(this).addClass('active');
        });

        // when searching by project name
        $(document).on('keyup', '#project_keyword', function () {
            ajaxFilterProjectView(sort, $(this).val(), status);
        });


        $(document).on('click', '.invite_usr', function () {
            var project_id = $('#project_id').val();
            var user_id = $(this).attr('data-id');

            $.ajax({
                url: '<?php echo e(route('invite.project.user.member')); ?>',
                method: 'POST',
                dataType: 'json',
                data: {
                    'project_id': project_id,
                    'user_id': user_id,
                    "_token": "<?php echo e(csrf_token()); ?>"
                },
                success: function (data) {
                    if (data.code == '200') {
                        show_toastr(data.status, data.success, 'success')
                        setInterval('location.reload()', 5000);
                    } else if (data.code == '404') {
                        show_toastr(data.status, data.errors, 'error')
                    }
                }
            });
        });
    });

    var currentRequest = null;

    function ajaxFilterProjectView(project_sort, keyword = '', status = '') {
        var mainEle = $('#project_view');
        var view = '<?php echo e($view); ?>';
        var data = {
            view: view,
            sort: project_sort,
            keyword: keyword,
            status: status,
        }

        currentRequest = $.ajax({
            url: '<?php echo e(route('filter.project.view')); ?>',
            data: data,
            beforeSend: function () {
                if (currentRequest != null) {
                    currentRequest.abort();
                }
            },
            success: function (data) {
                mainEle.html(data.html);
                $('[id^=fire-modal]').remove();
                loadConfirm();
            }
        });
    }
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\rezo2\resources\views/projects/index.blade.php ENDPATH**/ ?>