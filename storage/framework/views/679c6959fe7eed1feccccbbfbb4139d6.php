<?php
    $employeeCounts = \App\Models\Employee::select(
    \DB::raw('CASE WHEN contract_type = 1 THEN "Full Time" ELSE "Part Time" END AS contract_type'),
    \DB::raw('COUNT(*) as count')
)->groupBy('contract_type')
->where('created_by',\Auth::user()->creatorId())
->get();
    $dataArray = [['Type', 'No. Employees']];
    foreach ($employeeCounts as $count) {
        $dataArray[] = [$count->contract_type, $count->count];
    }
    $dataJson = json_encode($dataArray);
?>


<div id="contract_type"></div>
<?php $__env->startPush('css-page'); ?>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            var data = google.visualization.arrayToDataTable(<?php echo $dataJson; ?>);

            var options = {
                title: "<?php echo e(__('Employees Contract Types')); ?>"
            };

            var chart = new google.visualization.PieChart(document.getElementById('contract_type'));

            chart.draw(data, options);
        }
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\xampp\htdocs\rezo2\resources\views/dashboard/charts/employees/contract_types.blade.php ENDPATH**/ ?>