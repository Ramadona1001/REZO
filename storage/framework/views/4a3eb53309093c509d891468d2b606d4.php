<?php
    $salaries = \App\Models\Employee::where('created_by',\Auth::user()->creatorId())->get();
    $sum_salaries = \App\Models\Employee::where('created_by',\Auth::user()->creatorId())->sum('salary');
    $averageSalary = count($salaries) > 0 ? $sum_salaries / count($salaries) : 0;
?>


<div id="salaries"></div>
<?php $__env->startPush('css-page'); ?>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {packages: ['corechart', 'bar']});
        google.charts.setOnLoadCallback(drawChart);
    
        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Category', 'Average Salary'],
                ['Average Salary', <?php echo e($averageSalary); ?>]
            ]);
    
            var options = {
                title: 'Average Salary',
                chartArea: {width: '50%'},
                hAxis: {
                    title: 'Average Salary',
                    minValue: 0
                },
                vAxis: {
                    title: 'Category'
                }
            };
    
            var chart = new google.visualization.BarChart(document.getElementById('salaries'));
    
            chart.draw(data, options);
        }
    </script>
<?php $__env->stopPush(); ?><?php /**PATH C:\xampp\htdocs\rezo2\resources\views/dashboard/charts/employees/salaries.blade.php ENDPATH**/ ?>