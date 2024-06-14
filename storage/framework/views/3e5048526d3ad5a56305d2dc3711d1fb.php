<?php echo e(Form::open(array('url' => 'leads'))); ?>

<div class="modal-body">
    <div class="row">
        <div class="col-6 form-group">
            <?php echo e(Form::label('subject', __('Subject'),['class'=>'form-label'])); ?>

            <?php echo e(Form::text('subject', null, array('class' => 'form-control','required'=>'required' , 'placeholder'=>__('Enter Subject')))); ?>

        </div>
        <input type="hidden" name="user_id" value="<?php echo e(\Auth::user()->id); ?>">
        <div class="col-6 form-group">
            <?php echo e(Form::label('name', __('Name'),['class'=>'form-label'])); ?>

            <?php echo e(Form::text('name', null, array('class' => 'form-control','required'=>'required' , 'placeholder' => __('Enter Name')))); ?>

        </div>
        <div class="col-6 form-group">
            <?php echo e(Form::label('email', __('Email'),['class'=>'form-label'])); ?>

            <?php echo e(Form::text('email', null, array('class' => 'form-control','required'=>'required' , 'placeholder' => __('Enter email')))); ?>

        </div>
        <div class="col-6 form-group">
            <?php echo e(Form::label('phone', __('Phone'),['class'=>'form-label'])); ?>

            <?php echo e(Form::text('phone', null, array('class' => 'form-control','required'=>'required' , 'placeholder' => __('Enter Phone')))); ?>

        </div>
    </div>
</div>

<div class="modal-footer">
    <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="<?php echo e(__('Create')); ?>" class="btn  btn-primary">
</div>

<?php echo e(Form::close()); ?>


<?php /**PATH C:\xampp\htdocs\rezo2\resources\views/leads/create.blade.php ENDPATH**/ ?>