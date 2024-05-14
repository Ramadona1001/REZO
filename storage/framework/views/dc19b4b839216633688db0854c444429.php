<?php
    $projects = \App\Models\Project::where('created_by',\Auth::user()->creatorId())->get();
    $dataArray = [['Project', 'No. Positions', 'Assigned Positions', 'Not Assigned Positions']];
    foreach ($projects as $project) {
        $assigned_positions = \App\Models\ProjectPosition::where('id',$project->id)->sum('position_employees_number');
        $dataArray[] = [
            $project->project_name,
            $project->positions,
            $assigned_positions,
            ($project->positions - $assigned_positions),

        ];
    }
    $dataJson = json_encode($dataArray);
?>

<div id="projects"></div>
<?php $__env->startPush('css-page'); ?>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawVisualization);
  
        function drawVisualization() {
          // Some raw data (not necessarily accurate)
          var data = google.visualization.arrayToDataTable(<?php echo $dataJson; ?>);
  
          var options = {
            title : '<?php echo e(__("Projects And Positions")); ?>',
            vAxis: {title: 'Count'},
            hAxis: {title: 'Projects'},
            seriesType: 'bars',
            series: {4: {type: 'line'}}
          };
  
          var chart = new google.visualization.ComboChart(document.getElementById('projects'));
          chart.draw(data, options);
        }
      </script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\xampp\htdocs\rezo2\resources\views/dashboard/charts/projects/project.blade.php ENDPATH**/ ?>