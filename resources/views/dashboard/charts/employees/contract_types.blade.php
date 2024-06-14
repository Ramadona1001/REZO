@php
    $employeeCounts = \App\Models\Employee::select(
    \DB::raw('CASE WHEN contract_type = 1 THEN "Full Time" ELSE "Part Time" END AS contract_type'),
    \DB::raw('COUNT(*) as count')
)->groupBy('contract_type')
->where('created_by',\Auth::user()->creatorId())
->get();
@endphp

<div class="card">
    <div class="card-header">
        {{ __('Employee Contract Type') }}
    </div>
    <div class="card-body">
        <div id="contract_type"></div>
    </div>
</div>


@push('script-page')
<script>
    // Prepare data for charts
    let contract_typeData = {!! $employeeCounts->pluck('count', 'contract_type') !!}; // Prepare gender data
    var contract_typeChart = new ApexCharts(document.querySelector("#contract_type"), {
        series: Object.values(contract_typeData),
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
        labels: Object.keys(contract_typeData),
        title: {
            text: 'Employee Counts by Contract Type',
            align: 'center',
            margin: 20,
            offsetY: 10,
            style: {
                fontSize: '16px',
                color: '#333'
            }
        },
    });
    contract_typeChart.render();
</script>
@endpush