<?php echo e(Form::model($custom_request, ['route' => ['customs.update', $custom_request->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data'])); ?>

<div class="modal-body">

    <div class="row mb-3">
        <div class="form-group mb-3">
            <?php echo e(Form::label('Custom Request ID', __('Custom Request ID'),['class'=>'form-label'])); ?>

            <?php echo e(Form::text('Custom Request ID', $projectId, array('class' => 'form-control','placeholder'=>__('Enter client Name'),'required'=>'required','readonly'=>'readonly'))); ?>

        </div>
        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <?php echo e(Form::label('request_name', __('Custom Request Name'), ['class' => 'form-label'])); ?><span class="text-danger">*</span>
                <?php echo e(Form::text('request_name', null, ['class' => 'form-control','required'=>'required'])); ?>

            </div>
        </div>
    </div>
    
    <div class="row mb-3">
        <div class="col-sm-4 col-md-4 mb-3">
            <div class="form-group">
                <?php echo e(Form::label('positions', __('By Unit / Position'),['class'=>'form-label'])); ?><span class="text-danger">*</span>
                <?php echo e(Form::select('unit_position', [
                    1 => __('Unit'),
                    2 => __('Position'),
                ],null, ['class' => 'form-control'])); ?>

            </div>
        </div>
        <div class="col-sm-4 col-md-4 mb-3">
            <div class="form-group">
                <?php echo e(Form::label('positions', __('Positions'),['class'=>'form-label'])); ?><span class="text-danger">*</span>
                <?php echo e(Form::number('positions', null, ['class' => 'form-control'])); ?>

            </div>
        </div>
        <div class="col-sm-4 col-md-4 mb-3">
            <div class="form-group">
                <?php echo e(Form::label('budget', __('Budget'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::number('budget', null, ['class' => 'form-control'])); ?>

            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <?php echo e(Form::label('description', __('Description'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::textarea('description', null, ['class' => 'form-control', 'rows' => '4', 'cols' => '50'])); ?>

            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <?php echo e(Form::label('status', __('Status'), ['class' => 'form-label'])); ?>

                <select name="status" id="status" class="form-control main-element" >
                    <?php $__currentLoopData = \App\Models\CustomRequest::$project_status; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($k); ?>" <?php echo e(($custom_request->status == $k) ? 'selected' : ''); ?>><?php echo e(__($v)); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>
    </div>
    
</div>
<div class="modal-footer">
    <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="<?php echo e(__('Update')); ?>" class="btn  btn-primary">
</div>
<?php echo e(Form::close()); ?>


<?php /**PATH C:\xampp\htdocs\rezo2\resources\views/custom_requests/edit.blade.php ENDPATH**/ ?>