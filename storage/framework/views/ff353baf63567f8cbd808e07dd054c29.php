<?php
    $employeeCounts = \App\Models\Employee::select('position_id',
    \DB::raw('COUNT(position_id) as count')
    )->groupBy('position_id')
    ->where('position_id','!=','0')
    ->whereNotNull('position_id')
    ->where('created_by',\Auth::user()->creatorId())
    ->get();

    $dataArray = [["Position", "No. Employees"]];
    foreach ($employeeCounts as $count) {
        $dataArray[] = [$count->position->name, $count->count];
    }
    $dataJson = json_encode($dataArray);
?>


<div id="positions"></div>
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
                title: "<?php echo e(__('Employees Positions')); ?>"
            };

            var chart = new google.visualization.PieChart(document.getElementById('positions'));

            chart.draw(data, options);
        }
    </script>
<?php $__env->stopPush(); ?><?php /**PATH C:\xampp\htdocs\rezo2\resources\views/dashboard/charts/employees/positions.blade.php ENDPATH**/ ?>