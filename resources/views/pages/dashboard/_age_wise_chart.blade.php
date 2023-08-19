<div class="card h-100 cstmzed">
    <div class="card-body p-9">
        <div class="card-title">
            <h3 class="mb-5 text-gray-800">Institution Wise Age Chart</h3>
        </div>
        <div class="card card- h-xl-100">
            <div class="card-body p-0 d-flex justify-content-between flex-column overflow-hidden">
                <div class="d-flex flex-stack flex-wrap flex-grow-1 px-9 pt-0 pb-3">
                    <div class="me-2">
                        <div class="d-flex flex-wrap px-0 mb-5">
                            @if (isset($total_institution_staff) && !empty($total_institution_staff))
                                @foreach ($total_institution_staff as $item)
                                    <div class="rounded min-w-125px py-3 px-4 my-1 me-6"
                                        style="border: 1px dashed rgba(0, 0, 0, 0.35)">
                                        <div class="d-flex align-items-center">
                                            <div class="text-dark fs-2 fw-bolder" data-kt-countup="true"
                                                data-kt-countup-value="{{ $item->total }}" data-kt-countup-prefix="">0
                                            </div>
                                        </div>
                                        <div class="fw-bold fs-6 text-dark opacity-50">{{ $item->name }} </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <div class="mixed-widget-10-chart-age" data-kt-color="primary" style="height: 175px"></div>

                {{-- <div class="fw-bolder fs-3 text-primary pb-9">
                    <div class="d-flex align-items-center px-9">
                        @if (isset($total_institution_staff) && !empty($total_institution_staff))
                            @foreach ($total_institution_staff as $item)
                                <div class="d-flex align-items-center me-6">
                                    <span class="rounded-1 bg-primary me-2 h-10px w-10px"></span>
                                    <span class="fw-semibold fs-6 text-gray-600">{{$item->name}}</span>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div> --}}
            </div>
        </div>

    </div>

</div>

<script>
    var age_json_data = @json($age_json_data);
    age_json_data = JSON.parse(age_json_data);

    console.log(typeof age_json_data, 'age_json_data')
    var initMixedWidget10 = function() {

        var charts = document.querySelectorAll('.mixed-widget-10-chart-age');

        var color;
        var height;
        var labelColor = KTUtil.getCssVariableValue('--bs-gray-500');
        var borderColor = KTUtil.getCssVariableValue('--bs-gray-200');
        var baseLightColor;
        var secondaryColor = KTUtil.getCssVariableValue('--bs-gray-300');
        var thirdColor = KTUtil.getCssVariableValue('--bs-gray-400');
        var fourthColor = KTUtil.getCssVariableValue('--bs-gray-600');
        var fifthColor = KTUtil.getCssVariableValue('--bs-orange-300');
        var baseColor;
        var options;
        var chart;

        [].slice.call(charts).map(function(element) {
            color = element.getAttribute("data-kt-color");
            height = parseInt(KTUtil.css(element, 'height'));
            baseColor = KTUtil.getCssVariableValue('--bs-' + color);

            options = {
                series: age_json_data,
                chart: {
                    fontFamily: 'inherit',
                    type: 'bar',
                    height: height,
                    toolbar: {
                        show: false
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: ['50%'],
                        borderRadius: 4
                    },
                },
                legend: {
                    show: false
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                xaxis: {
                    categories: ['1-25', '25-35', '35-45', '45-55', '55-80'],
                    axisBorder: {
                        show: false,
                    },
                    axisTicks: {
                        show: false
                    },
                    labels: {
                        style: {
                            colors: labelColor,
                            fontSize: '12px'
                        }
                    }
                },
                yaxis: {
                    y: 0,
                    offsetX: 0,
                    offsetY: 0,
                    labels: {
                        style: {
                            colors: labelColor,
                            fontSize: '12px'
                        }
                    }
                },
                fill: {
                    type: 'solid'
                },
                states: {
                    normal: {
                        filter: {
                            type: 'none',
                            value: 0
                        }
                    },
                    hover: {
                        filter: {
                            type: 'none',
                            value: 0
                        }
                    },
                    active: {
                        allowMultipleDataPointsSelection: false,
                        filter: {
                            type: 'none',
                            value: 0
                        }
                    }
                },
                tooltip: {
                    style: {
                        fontSize: '12px'
                    },
                    y: {
                        formatter: function(val) {
                            return "+" + val + " Staffs"
                        }
                    }
                },
                colors: [baseColor, secondaryColor, thirdColor, fourthColor, fifthColor],
                grid: {
                    padding: {
                        top: 10
                    },
                    borderColor: borderColor,
                    strokeDashArray: 4,
                    yaxis: {
                        lines: {
                            show: true
                        }
                    }
                }
            };

            chart = new ApexCharts(element, options);
            chart.render();
        });
    }


    if (typeof module !== 'undefined') {
        module.exports = initMixedWidget10;
    }

    // On document ready
    KTUtil.onDOMContentLoaded(function() {
        initMixedWidget10();
    });
</script>
