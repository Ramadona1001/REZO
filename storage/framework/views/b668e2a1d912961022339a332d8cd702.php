<?php
    $employeeCounts = \App\Models\Employee::select(
    \DB::raw('YEAR(NOW()) - YEAR(dob) - (DATE_FORMAT(NOW(), "%m%d") < DATE_FORMAT(dob, "%m%d")) AS age'),
    \DB::raw('COUNT(*) as count'))->groupBy('age')
    ->where('created_by',\Auth::user()->creatorId())
    ->get();
    $dataArray = [["Age", "No. Employees", ["role" => "style"]]];
    foreach ($employeeCounts as $count) {
        $dataArray[] = ['Age '.$count->age, $count->count,"#055bbb"];
    }
    $dataJson = json_encode($dataArray);
?>


<div id="ages"></div>
<?php $__env->startPush('css-page'); ?>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load("current", {packages:['corechart']});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {
          var data = google.visualization.arrayToDataTable(<?php echo $dataJson; ?>);
    
          var view = new google.visualization.DataView(data);
          view.setColumns([0, 1,
                           { calc: "stringify",
                             sourceColumn: 1,
                             type: "string",
                             role: "annotation" },
                           2]);
    
          var options = {
            title: "<?php echo e(__('Employees Ages')); ?>",
            bar: {groupWidth: "95%"},
            legend: { position: "none" },
          };
          var chart = new google.visualization.ColumnChart(document.getElementById("ages"));
          chart.draw(view, options);
      }
      </script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\xampp\htdocs\rezo2\resources\views/dashboard/charts/employees/ages.blade.php ENDPATH**/ ?>