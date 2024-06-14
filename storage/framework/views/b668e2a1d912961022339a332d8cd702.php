<?php
    $employeeCounts = \App\Models\Employee::select(
        \DB::raw('YEAR(NOW()) - YEAR(dob) - (DATE_FORMAT(NOW(), "%m%d") < DATE_FORMAT(dob, "%m%d")) AS age'),
        \DB::raw('COUNT(*) as count'),
    )
        ->groupBy('age')
        ->where('created_by', \Auth::user()->creatorId())
        ->get();

?>

<div class="card">
    <div class="card-header">
        <?php echo e(__('Employee Ages')); ?>

    </div>
    <div class="card-body">
        <div id="ages"></div>
    </div>
</div>

<?php $__env->startPush('script-page'); ?>
    <script type="text/javascript">
        var employeeCounts = <?php echo $employeeCounts; ?>;

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
                formatter: function(val) {
                    return val;
                },
                offsetY: -20,
                style: {
                    fontSize: '12px',
                    colors: ["#304758"]
                }
            },
            xaxis: {
                categories: employeeCounts.map(item => item.age),
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
                text: 'Employee Counts by Age',
                floating: true,
                offsetY: 330,
                align: 'center',
                style: {
                    color: '#444'
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#ages"), options);
        chart.render();
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\xampp\htdocs\rezo2\resources\views/dashboard/charts/employees/ages.blade.php ENDPATH**/ ?>