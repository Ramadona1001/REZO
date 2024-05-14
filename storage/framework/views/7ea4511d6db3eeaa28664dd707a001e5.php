<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Dashboard')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('script-page'); ?>
    <script>
        <?php if(\Auth::user()->can('show account dashboard')): ?>
            (function() {
                var chartBarOptions = {
                    series: [{
                            name: "<?php echo e(__('Income')); ?>",
                            data: <?php echo json_encode($incExpLineChartData['income']); ?>

                        },
                        {
                            name: "<?php echo e(__('Expense')); ?>",
                            data: <?php echo json_encode($incExpLineChartData['expense']); ?>

                        }
                    ],

                    chart: {
                        height: 250,
                        type: 'area',
                        // type: 'line',
                        dropShadow: {
                            enabled: true,
                            color: '#000',
                            top: 18,
                            left: 7,
                            blur: 10,
                            opacity: 0.2
                        },
                        toolbar: {
                            show: false
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        width: 2,
                        curve: 'smooth'
                    },
                    title: {
                        text: '',
                        align: 'left'
                    },
                    xaxis: {
                        categories: <?php echo json_encode($incExpLineChartData['day']); ?>,
                        title: {
                            text: '<?php echo e(__('Date')); ?>'
                        }
                    },
                    colors: ['#6fd944', '#ff3a6e'],


                    grid: {
                        strokeDashArray: 4,
                    },
                    legend: {
                        show: false,
                    },
                    // markers: {
                    //     size: 4,
                    //     colors: ['#6fd944', '#FF3A6E'],
                    //     opacity: 0.9,
                    //     strokeWidth: 2,
                    //     hover: {
                    //         size: 7,
                    //     }
                    // },
                    yaxis: {
                        title: {
                            text: '<?php echo e(__('Amount')); ?>'
                        },

                    }

                };
                var arChart = new ApexCharts(document.querySelector("#cash-flow"), chartBarOptions);
                arChart.render();
            })();

            (function() {
                var options = {
                    chart: {
                        height: 180,
                        type: 'bar',
                        toolbar: {
                            show: false,
                        },
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        width: 2,
                        curve: 'smooth'
                    },
                    series: [{
                        name: "<?php echo e(__('Income')); ?>",
                        data: <?php echo json_encode($incExpBarChartData['income']); ?>

                    }, {
                        name: "<?php echo e(__('Expense')); ?>",
                        data: <?php echo json_encode($incExpBarChartData['expense']); ?>

                    }],
                    xaxis: {
                        categories: <?php echo json_encode($incExpBarChartData['month']); ?>,
                    },
                    colors: ['#3ec9d6', '#FF3A6E'],
                    fill: {
                        type: 'solid',
                    },
                    grid: {
                        strokeDashArray: 4,
                    },
                    legend: {
                        show: true,
                        position: 'top',
                        horizontalAlign: 'right',
                    },
                    // markers: {
                    //     size: 4,
                    //     colors:  ['#3ec9d6', '#FF3A6E',],
                    //     opacity: 0.9,
                    //     strokeWidth: 2,
                    //     hover: {
                    //         size: 7,
                    //     }
                    // }
                };
                var chart = new ApexCharts(document.querySelector("#incExpBarChart"), options);
                chart.render();
            })();

            (function() {
                var options = {
                    chart: {
                        height: 140,
                        type: 'donut',
                    },
                    dataLabels: {
                        enabled: false,
                    },
                    plotOptions: {
                        pie: {
                            donut: {
                                size: '70%',
                            }
                        }
                    },
                    series: <?php echo json_encode($expenseCatAmount); ?>,
                    colors: <?php echo json_encode($expenseCategoryColor); ?>,
                    labels: <?php echo json_encode($expenseCategory); ?>,
                    legend: {
                        show: true
                    }
                };
                var chart = new ApexCharts(document.querySelector("#expenseByCategory"), options);
                chart.render();
            })();

            (function() {
                var options = {
                    chart: {
                        height: 140,
                        type: 'donut',
                    },
                    dataLabels: {
                        enabled: false,
                    },
                    plotOptions: {
                        pie: {
                            donut: {
                                size: '70%',
                            }
                        }
                    },
                    series: <?php echo json_encode($incomeCatAmount); ?>,
                    colors: <?php echo json_encode($incomeCategoryColor); ?>,
                    labels: <?php echo json_encode($incomeCategory); ?>,
                    legend: {
                        show: true
                    }
                };
                var chart = new ApexCharts(document.querySelector("#incomeByCategory"), options);
                chart.render();
            })();

            (function() {
                var options = {
                    series: [<?php echo e(round($storage_limit, 2)); ?>],
                    chart: {
                        height: 350,
                        type: 'radialBar',
                        offsetY: -20,
                        sparkline: {
                            enabled: true
                        }
                    },
                    plotOptions: {
                        radialBar: {
                            startAngle: -90,
                            endAngle: 90,
                            track: {
                                background: "#e7e7e7",
                                strokeWidth: '97%',
                                margin: 5, // margin is in pixels
                            },
                            dataLabels: {
                                name: {
                                    show: true
                                },
                                value: {
                                    offsetY: -50,
                                    fontSize: '20px'
                                }
                            }
                        }
                    },
                    grid: {
                        padding: {
                            top: -10
                        }
                    },
                    colors: ["#6FD943"],
                    labels: ['Used'],
                };
                var chart = new ApexCharts(document.querySelector("#limit-chart"), options);
                chart.render();
            })();
        <?php endif; ?>
    </script>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Home')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row">
            <h4><?php echo e(__('Statistics')); ?></h4>
            <?php $__currentLoopData = $statistics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-lg-4 col-md-6 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center justify-content-between">
                                <div class="col-auto mb-3 mb-sm-0">
                                    <div class="d-flex align-items-center">
                                        <div class="ms-3">
                                            <small class="text-muted"><?php echo e(__('Total Of')); ?></small>
                                            <h6 class="m-0"><?php echo e($key); ?></h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto text-end">
                                    <h4 class="m-0"><?php echo e($state); ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script-page'); ?>
    <script>
        if (window.innerWidth <= 500) {
            $('p').removeClass('text-sm');
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\rezo2\resources\views/dashboard/account-dashboard.blade.php ENDPATH**/ ?>