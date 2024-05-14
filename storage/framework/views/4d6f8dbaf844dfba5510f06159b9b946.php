<?php
    $employeeCounts = \App\Models\Employee::select(
    'gender',
    \DB::raw('COUNT(*) as count')
)->groupBy('gender')
->where('created_by',\Auth::user()->creatorId())
->get();
    $dataArray = [['Gender', 'No. Employees']];
    foreach ($employeeCounts as $count) {
        $dataArray[] = [$count->gender, $count->count];
    }
    $dataJson = json_encode($dataArray);
?>


<div id="genders"></div>
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
                title: "<?php echo e(__('Employees Genders')); ?>"
            };

            var chart = new google.visualization.PieChart(document.getElementById('genders'));

            chart.draw(data, options);
        }
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\xampp\htdocs\rezo2\resources\views/dashboard/charts/employees/genders.blade.php ENDPATH**/ ?>