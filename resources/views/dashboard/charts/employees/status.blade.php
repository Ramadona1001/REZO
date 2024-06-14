@php
    $employeeCounts = \App\Models\Employee::select(
        \DB::raw('CASE WHEN employee_status = 1 THEN "Active" ELSE "Terminated" END AS employee_status'),
        \DB::raw('COUNT(*) as count'),
    )
        ->groupBy('employee_status')
        ->where('created_by', \Auth::user()->creatorId())
        ->get();
@endphp

<div class="card">
    <div class="card-header">
        {{ __('Employee Status') }}
    </div>
    <div class="card-body">
        <div id="employee_status"></div>
    </div>
</div>

@push('script-page')
    <script>
        // Prepare data for charts
        let statusData = {!! $employeeCounts->pluck('count', 'employee_status') !!}; // Prepare status data
        var statusChart = new ApexCharts(document.querySelector("#employee_status"), {
            series: Object.values(statusData),
            chart: {
                type: 'pie',
                height: 350,
                toolbar: {
                    show: true,
                    tools: {
                        download: true,
                        selection: true,
                        zoom: true,
                        zoomin: true,
                        zoomout: true,
                        pan: true,
                        reset: true,
                        customIcons: []
                    },
                    autoSelected: 'zoom'
                }
            },
            labels: Object.keys(statusData),
            title: {
                text: 'Employee Counts by Status',
                align: 'center',
                margin: 20,
                offsetY: 10,
                style: {
                    fontSize: '16px',
                    color: '#333'
                }
            },
        });
        statusChart.render();
    </script>
@endpush
