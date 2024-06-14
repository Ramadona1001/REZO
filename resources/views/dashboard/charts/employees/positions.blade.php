@php
    $employeeCounts = \App\Models\Employee::select('positions.name as position_name',
    \DB::raw('COUNT(employees.position_id) as count')
    )->leftJoin('positions', 'employees.position_id', '=', 'positions.id')
    ->where('employees.position_id', '!=', 0)
    ->whereNotNull('employees.position_id')
    ->where('employees.created_by', \Auth::user()->creatorId())
    ->groupBy('employees.position_id', 'positions.name')
    ->get();
@endphp

<div class="card">
    <div class="card-header">
        {{ __('Employee Positions') }}
    </div>
    <div class="card-body">
        <div id="positions"></div>
    </div>
</div>

@push('script-page')
<script type="text/javascript">
    var employeeCounts = {!! $employeeCounts !!};
    
    var options = {
        series: [{
            name: 'Employee Count',
            data: employeeCounts.map(item => item.count)
        }],
        chart: {
            height: 350,
            type: 'bar',
        },
        plotOptions: {
            bar: {
                borderRadius: 10,
                dataLabels: {
                    position: 'top', // top, center, bottom
                },
            }
        },
        dataLabels: {
            enabled: true,
            formatter: function (val) {
                return val;
            },
            offsetY: -20,
            style: {
                fontSize: '12px',
                colors: ["#304758"]
            }
        },
        xaxis: {
            categories: employeeCounts.map(item => item.position_name),
            position: 'top',
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false
            },
            crosshairs: {
                fill: {
                    type: 'gradient',
                    gradient: {
                        colorFrom: '#D8E3F0',
                        colorTo: '#BED1E6',
                        stops: [0, 100],
                        opacityFrom: 0.4,
                        opacityTo: 0.5,
                    }
                }
            },
            tooltip: {
                enabled: true,
            }
        },
        yaxis: {
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false,
            },
            labels: {
                show: false,
            }
        },
        title: {
            text: 'Employee Counts by Position',
            floating: true,
            offsetY: 330,
            align: 'center',
            style: {
                color: '#444'
            }
        }
    };

    var chart = new ApexCharts(document.querySelector("#positions"), options);
    chart.render();
</script>

@endpush