@php
    $employeeCounts = \App\Models\Employee::select('department_id',
    \DB::raw('COUNT(department_id) as count')
    )->groupBy('department_id')
    ->where('department_id','!=','0')
    ->whereNotNull('department_id')
    ->where('created_by',\Auth::user()->creatorId())
    ->get();

    $dataArray = [["Position", "No. Employees"]];
    foreach ($employeeCounts as $count) {
        if ($count->department != null) {
            $dataArray[] = [$count->department->name, $count->count];
        }
    }
    $dataJson = json_encode($dataArray);
@endphp


<div id="departments"></div>
@push('css-page')
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            var data = google.visualization.arrayToDataTable({!! $dataJson !!});

            var options = {
                title: "{{ __('Employees Departments') }}"
            };

            var chart = new google.visualization.PieChart(document.getElementById('departments'));

            chart.draw(data, options);
        }
    </script>
@endpush