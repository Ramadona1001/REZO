<?php
    $employeeCounts = \App\Models\Employee::select('departments.name as department_name',
    \DB::raw('COUNT(employees.department_id) as count')
    )->leftJoin('departments', 'employees.department_id', '=', 'departments.id')
    ->where('employees.department_id', '!=', 0)
    ->whereNotNull('employees.department_id')
    ->where('employees.created_by', \Auth::user()->creatorId())
    ->groupBy('employees.department_id', 'departments.name')
    ->get();
?>

<div class="card">
    <div class="card-header">
        <?php echo e(__('Employee Departments')); ?>

    </div>
    <div class="card-body">
        <div id="departments"></div>
    </div>
</div>

<?php $__env->startPush('script-page'); ?>
<script>
    // Prepare data for charts
    let departmentData = <?php echo $employeeCounts->pluck('count', 'department_name'); ?>; // Prepare department data
    var departmentChart = new ApexCharts(document.querySelector("#departments"), {
        series: Object.values(departmentData),
        chart: {
            type: 'pie',
            height: 350,
            toolbar: {
                show: true,
                tools: {
                    download: true,
                    selection: true,
                    zoom: true,
                    zoomin: true,
                    zoomout: true,
                    pan: true,
                    reset: true,
                    customIcons: []
                },
                autoSelected: 'zoom'
            }
        },
        labels: Object.keys(departmentData),
        title: {
            text: 'Employee Counts by Department',
            align: 'center',
            margin: 20,
            offsetY: 10,
            style: {
                fontSize: '16px',
                color: '#333'
            }
        },
    });
    departmentChart.render();
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\xampp\htdocs\rezo2\resources\views/dashboard/charts/employees/departments.blade.php ENDPATH**/ ?>