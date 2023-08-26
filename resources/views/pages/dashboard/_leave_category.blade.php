<div class="card h-100 cstmzed">
    <div class="card-body p-9">

        <div class="card-header">
            <div class="m-0">
                <div class="card-title">
                    <h3 class="mb-0 text-gray-800">Leave Categories </h3>
                </div>
            </div>
        </div>

        <div class="card-body pt-0 pb-1">
            <div id="kt_charts_widget_leave_category" class="min-h-auto"></div>
        </div>
    </div>
</div>

<script>
    var chartDatas = @json( $leave_chart );
    console.log(chartDatas, 'chartDatas')
    var KTChartsWidgetLeaveCatgory = function() {
        // Private methods
        var initChart = function() {
            var element = document.getElementById("kt_charts_widget_leave_category");

            if (!element) {
                return;
            }

            var labelColor = KTUtil.getCssVariableValue('--bs-gray-800');
            var borderColor = KTUtil.getCssVariableValue('--bs-border-dashed-color');
            var maxValue = 18;

            var options = {
                series: [{
                    name: 'Sessions',
                    data: chartDatas
                }],
                chart: {
                    fontFamily: 'inherit',
                    type: 'bar',
                    height: 350,
                    toolbar: {
                        show: false
                    }
                },
                plotOptions: {
                    bar: {
                        borderRadius: 8,
                        horizontal: true,
                        distributed: true,
                        barHeight: 50,
                        dataLabels: {
                            position: 'bottom' // use 'bottom' for left and 'top' for right align(textAnchor)
                        }
                    }
                },
                dataLabels: { // Docs: https://apexcharts.com/docs/options/datalabels/
                    enabled: true,
                    textAnchor: 'start',
                    offsetX: 0,
                    style: {
                        fontSize: '14px',
                        fontWeight: '600',
                        align: 'left',
                    }
                },
                legend: {
                    show: false
                },
                colors: ['#3E97FF', '#F1416C', '#43a43c', '#FFC700', '#7239EA', '#eee'],
                xaxis: {
                    categories: ["Present", "Absent", 'EL', 'CL', 'ML', 'EOL'],
                    labels: {
                        formatter: function(val) {
                            return val + ""
                        },
                        style: {
                            colors: labelColor,
                            fontSize: '14px',
                            fontWeight: '600',
                            align: 'left'
                        }
                    },
                    axisBorder: {
                        show: false
                    }
                },
                yaxis: {
                    labels: {
                        formatter: function(val, opt) {
                            if (Number.isInteger(val)) {
                                var percentage = parseInt(val * 100 / maxValue).toString();
                                return val + ' - ' + percentage + '%';
                            } else {
                                return val;
                            }
                        },
                        style: {
                            colors: labelColor,
                            fontSize: '14px',
                            fontWeight: '600'
                        },
                        offsetY: 2,
                        align: 'left'
                    }
                },
                grid: {
                    borderColor: borderColor,
                    xaxis: {
                        lines: {
                            show: true
                        }
                    },
                    yaxis: {
                        lines: {
                            show: false
                        }
                    },
                    strokeDashArray: 4
                },
                tooltip: {
                    style: {
                        fontSize: '12px'
                    },
                    y: {
                        formatter: function(val) {
                            return val;
                        }
                    }
                }
            };

            var chart = new ApexCharts(element, options);

            // Set timeout to properly get the parent elements width
            setTimeout(function() {
                chart.render();
            }, 200);
        }

        // Public methods
        return {
            init: function() {
                initChart();
            }
        }
    }();

    // Webpack support
    if (typeof module !== 'undefined') {
        module.exports = KTChartsWidgetLeaveCatgory;
    }

    // On document ready
    KTUtil.onDOMContentLoaded(function() {
        KTChartsWidgetLeaveCatgory.init();
    });
</script>
