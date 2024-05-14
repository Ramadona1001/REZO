<?php
    $employeeCounts = \App\Models\Employee::select(
    \DB::raw('CASE WHEN employee_status = 1 THEN "Active" ELSE "Terminated" END AS employee_status'),
    \DB::raw('COUNT(*) as count')
)->groupBy('employee_status')
->where('created_by',\Auth::user()->creatorId())
->get();
    $dataArray = [['Status', 'No. Employees']];
    foreach ($employeeCounts as $count) {
        $dataArray[] = [$count->employee_status, $count->count];
    }
    $dataJson = json_encode($dataArray);
?>


<div id="employee_status"></div>
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
                title: "<?php echo e(__('Employees Status')); ?>"
            };

            var chart = new google.visualization.PieChart(document.getElementById('employee_status'));

            chart.draw(data, options);
        }
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\xampp\htdocs\rezo2\resources\views/dashboard/charts/employees/status.blade.php ENDPATH**/ ?>