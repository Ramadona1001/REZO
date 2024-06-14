<?php
    $salaries = \App\Models\Employee::where('created_by',\Auth::user()->creatorId())->get();
    $sum_salaries = \App\Models\Employee::where('created_by',\Auth::user()->creatorId())->sum('salary');
    $averageSalary = count($salaries) > 0 ? $sum_salaries / count($salaries) : 0;
?>

<div class="card">
    <div class="card-header">
        <?php echo e(__('Employee AVG Salaries')); ?>

    </div>
    <div class="card-body">
        <div id="salaries"></div>
    </div>
</div>


<?php $__env->startPush('script-page'); ?>
<script>
    var averageSalary = <?php echo $averageSalary; ?>; // Assuming $averageSalary is a numeric value

    var options = {
        series: [{
            name: 'Average Salary',
            data: [averageSalary]
        }],
        chart: {
            type: 'bar',
            height: 350,
            toolbar: {
                show: true,
                tools: {
                    download: true,
                    selection: false,
                    zoom: false,
                    zoomin: false,
                    zoomout: false,
                    pan: false,
                    reset: false,
                    customIcons: []
                },
                autoSelected: 'zoom'
            }
        },
        plotOptions: {
            bar: {
                horizontal: true
            }
        },
        dataLabels: {
            enabled: true,
            formatter: function (val) {
                return val.toFixed(2); // Format salary to two decimal places
            }
        },
        xaxis: {
            categories: ['Average Salary'],
            title: {
                text: 'Average Salary'
            },
            labels: {
                formatter: function (val) {
                    return '$' + val.toFixed(2); // Format salary labels with dollar sign
                }
            }
        },
        yaxis: {
            title: {
                text: 'Category'
            }
        },
        title: {
            text: 'Average Salary',
            align: 'center',
            margin: 20,
            offsetY: 10,
            style: {
                fontSize: '16px',
                color: '#333'
            }
        }
    };

    var chart = new ApexCharts(document.querySelector("#salaries"), options);
    chart.render();
</script>

<?php $__env->stopPush(); ?><?php /**PATH C:\xampp\htdocs\rezo2\resources\views/dashboard/charts/employees/salaries.blade.php ENDPATH**/ ?>