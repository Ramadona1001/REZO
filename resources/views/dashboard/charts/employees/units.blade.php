@php
    $employeeCounts = \App\Models\Employee::select('designation_id',
    \DB::raw('COUNT(designation_id) as count')
    )->groupBy('designation_id')
    ->where('designation_id','!=','0')
    ->whereNotNull('designation_id')
    ->where('created_by',\Auth::user()->creatorId())
    ->get();

    $dataArray = [["Unit", "No. Employees"]];
    foreach ($employeeCounts as $count) {
        if ($count->designation != null) {
            $dataArray[] = [$count->designation->name, $count->count];
        }
    }
    $dataJson = json_encode($dataArray);
@endphp


<div id="units"></div>
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
                title: "{{ __('Employees Units') }}"
            };

            var chart = new google.visualization.PieChart(document.getElementById('units'));

            chart.draw(data, options);
        }
    </script>
@endpush