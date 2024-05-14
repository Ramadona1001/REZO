<hr>
<h4><?php echo e(__('Employees Charts')); ?></h4>
<div class="col-6">
    <?php echo $__env->make('dashboard.charts.employees.contract_types', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div>
<div class="col-6">
    <?php echo $__env->make('dashboard.charts.employees.genders', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div><?php /**PATH C:\xampp\htdocs\rezo2\resources\views/dashboard/charts/employees/employees.blade.php ENDPATH**/ ?>