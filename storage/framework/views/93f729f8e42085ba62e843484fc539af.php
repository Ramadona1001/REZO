<?php echo e(Form::open(array('url' => 'plans', 'enctype' => "multipart/form-data"))); ?>

<div class="modal-body">
    
    <?php
        $settings = \App\Models\Utility::settings();
    ?>
    <?php if(!empty($settings['chat_gpt_key'])): ?>
    <div class="text-end">
        <a href="#" data-size="md" class="btn  btn-primary btn-icon btn-sm" data-ajax-popup-over="true" data-url="<?php echo e(route('generate',['plan'])); ?>"
           data-bs-placement="top" data-title="<?php echo e(__('Generate content with AI')); ?>">
            <i class="fas fa-robot"></i> <span><?php echo e(__('Generate with AI')); ?></span>
        </a>
    </div>
    <?php endif; ?>
    
    <div class="row">
        <div class="form-group col-md-6">
            <?php echo e(Form::label('name',__('Name'),['class'=>'form-label'])); ?>

            <?php echo e(Form::text('name',null,array('class'=>'form-control font-style','placeholder'=>__('Enter Plan Name'),'required'=>'required'))); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('price',__('Price'),['class'=>'form-label'])); ?>

            <?php echo e(Form::number('price',null,array('class'=>'form-control','placeholder'=>__('Enter Plan Price'),'required'=>'required' ,'step' => '0.01'))); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('duration', __('Duration'),['class'=>'form-label'])); ?>

            <?php echo Form::select('duration', $arrDuration, null,array('class' => 'form-control select','required'=>'required')); ?>

        </div>
        
        
        
        
        

        <div class="form-group col-md-12">
            <?php echo e(Form::label('description', __('Description'),['class'=>'form-label'])); ?>

            <?php echo Form::textarea('description', null, ['class'=>'form-control summernote-simple','rows'=>'2']); ?>

        </div>

        <div class="col-md-6">
            <label class="form-check-label" for="trial"></label>
            <div class="form-group">
                <label for="trial" class="form-label"><?php echo e(__('Trial is enable(on/off)')); ?></label>
                <div class="form-check form-switch custom-switch-v1 float-end">
                    <input type="checkbox" name="trial" class="form-check-input input-primary pointer" value="1" id="trial">
                    <label class="form-check-label" for="trial"></label>
                </div>
            </div>
        </div>
        <div class="col-md-6 ">
            <div class="form-group plan_div d-none">
                <?php echo e(Form::label('trial_days', __('Trial Days'), ['class' => 'form-label'])); ?>

                <?php echo e(Form::number('trial_days',null, ['class' => 'form-control trial_days','placeholder' => __('Enter Trial days'),'step' => '1','min'=>'1'])); ?>

            </div>
        </div>

        

    </div>
</div>
<div class="modal-footer">
    <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="<?php echo e(__('Create')); ?>" class="btn  btn-primary">
</div>
    <?php echo e(Form::close()); ?>


<?php /**PATH C:\xampp\htdocs\rezo2\resources\views/plan/create.blade.php ENDPATH**/ ?>