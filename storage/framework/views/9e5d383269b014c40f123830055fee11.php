<?php

$employeeCounts = \App\Models\Employee::select('designations.name as designation_name',
    \DB::raw('COUNT(employees.designation_id) as count')
    )->leftJoin('designations', 'employees.designation_id', '=', 'designations.id')
    ->where('employees.designation_id', '!=', 0)
    ->whereNotNull('employees.designation_id')
    ->where('employees.created_by', \Auth::user()->creatorId())
    ->groupBy('employees.designation_id', 'designations.name')
    ->get();
?>

<div class="card">
    <div class="card-header">
        <?php echo e(__('Employee Units')); ?>

    </div>
    <div class="card-body">
        <div id="units"></div>
    </div>
</div>

<?php $__env->startPush('script-page'); ?>
<script>
    // Prepare data for charts
    let unitData = <?php echo $employeeCounts->pluck('count', 'designation_name'); ?>; // Prepare unit data
    var unitChart = new ApexCharts(document.querySelector("#units"), {
        series: Object.values(unitData),
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
        labels: Object.keys(unitData),
        title: {
            text: 'Employee Counts by Unit',
            align: 'center',
            margin: 20,
            offsetY: 10,
            style: {
                fontSize: '16px',
                color: '#333'
            }
        },
    });
    unitChart.render();
</script>
<?php $__env->stopPush(); ?><?php /**PATH C:\xampp\htdocs\rezo2\resources\views/dashboard/charts/employees/units.blade.php ENDPATH**/ ?>