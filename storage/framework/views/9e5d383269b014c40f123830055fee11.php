<?php
    $employeeCounts = \App\Models\Employee::select('designation_id',
    \DB::raw('COUNT(designation_id) as count')
    )->groupBy('designation_id')
    ->where('designation_id','!=','0')
    ->whereNotNull('designation_id')
    ->where('created_by',\Auth::user()->creatorId())
    ->get();

    $dataArray = [["Unit", "No. Employees"]];
    foreach ($employeeCounts as $count) {
        $dataArray[] = [$count->designation->name, $count->count];
    }
    $dataJson = json_encode($dataArray);
?>


<div id="units"></div>
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
                title: "<?php echo e(__('Employees Units')); ?>"
            };

            var chart = new google.visualization.PieChart(document.getElementById('units'));

            chart.draw(data, options);
        }
    </script>
<?php $__env->stopPush(); ?><?php /**PATH C:\xampp\htdocs\rezo2\resources\views/dashboard/charts/employees/units.blade.php ENDPATH**/ ?>