@php
    $employeeCounts = \App\Models\Employee::select(
    'gender',
    \DB::raw('COUNT(*) as count')
)->groupBy('gender')
->where('created_by',\Auth::user()->creatorId())
->get();

@endphp


<div class="card">
    <div class="card-header">
        {{ __('Employee Gender Chart') }}
    </div>
    <div class="card-body">
        <div id="genderChart"></div>
    </div>
</div>
@push('script-page')
<script>
    // Prepare data for charts
    let genderData = {!! $employeeCounts->pluck('count', 'gender') !!}; // Prepare gender data
    var genderChart = new ApexCharts(document.querySelector("#genderChart"), {
        series: Object.values(genderData),
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
        labels: Object.keys(genderData),
        title: {
            text: 'Employee Counts by Gender',
            align: 'center',
            margin: 20,
            offsetY: 10,
            style: {
                fontSize: '16px',
                color: '#333'
            }
        },
    });
    genderChart.render();
</script>
@endpush
