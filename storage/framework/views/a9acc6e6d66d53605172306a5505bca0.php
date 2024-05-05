<div class="modal-body">
    <h4><?php echo e(__('Request').' : ('.$custom_request->request_name.') '.__('Positions')); ?></h4>
    <?php $__currentLoopData = $custom_request_position; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $position): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <form action="<?php echo e(route('customs.edit.positions',['id'=>$position->id])); ?>" method="post">
        <?php echo csrf_field(); ?>
        <table class="table table-bordered" style="text-align: center">
            <thead>
                <th><?php echo e(__('Request')); ?></th>
                <th><?php echo e(__('Positions Count')); ?></th>
                <th><?php echo e(__('Actions')); ?></th>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <?php if($position->position != null): ?>
                            <p><?php echo e($position->position->name); ?></p>
                        <?php endif; ?>
                    </td>
                    <td>
                        <input type="number" name="positions_count" style="text-align: center" class="form-control" value="<?php echo e($position->position_employees_number); ?>" min="0" step="0.5" required>
                    </td>
                    <td>
                        <input type="submit" value="<?php echo e(__('Save')); ?>" class="btn  btn-primary">
                        <a href="<?php echo e(route('customs.deletePositions',['id'=>$position->id])); ?>" onclick="return confirm ('Are You Sure?')" class="btn btn-danger"><?php echo e(__('Delete')); ?></a>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    
</div>
<div class="modal-footer">
    <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn  btn-light" data-bs-dismiss="modal">
</div>

<?php /**PATH C:\xampp\htdocs\rezo2\resources\views/custom_requests/edit-positions.blade.php ENDPATH**/ ?>